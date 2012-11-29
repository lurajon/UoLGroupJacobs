<?php

include_once 'reservation_connect.inc';
include_once 'reservation.inc';

class Model {

	public function __construct() {

	}

	function prepareDatesForQuery($value) {

		$getDate = explode("/", $value);
		$accessFormat = $getDate[1] . "/" . $getDate[0] . "/" . $getDate[2];
		return $accessFormat;
	}

	function getRoomSizesOfSameType($size) {

		$query = "SELECT rtype_fk FROM room_size WHERE rsize_id = " . $size . ";";
		$connect = New BaseConnection();
		$dbLink = $connect -> openConnection();
		$resultSet = $connect -> queryDB($dbLink, $query);

		$query = "SELECT TOP 1 rsize_id FROM room_size WHERE ((rsize_id<>" . $size . ") AND (rtype_fk=" . $connect -> getValue($resultSet, "rtype_fk") . "));";
		$resultSet = $connect -> queryDB($dbLink, $query);
		return $connect -> getValue($resultSet, "rsize_id");
		$connect -> closeConnection($dbLink);
	}

	function getRooms($filter) {

		$query = "SELECT room.room_id, room.room_name, room_size.rsize_id, room_size.rsize_name, room_size.rsize_price, room_type.rtype_id, room_type.rtype_name FROM room_type RIGHT JOIN (room_size RIGHT JOIN room ON room_size.rsize_id = room.rsize_fk) ON room_type.rtype_id = room_size.rtype_fk WHERE " . $filter;

		$connect = New BaseConnection();
		$dbLink = $connect -> openConnection();
		$resultSet = $connect -> queryDB($dbLink, $query);

		if (!empty($resultSet)) {

			$resultRow = $connect -> getTableRow($resultSet);
			if (!empty($resultRow)) {
				$i = 0;

				while ($resultRow == TRUE) {
					$contents[$i] = new Room($connect -> getValue($resultSet, "room_id"), $connect -> getValue($resultSet, "room_name"), $connect -> getValue($resultSet, "rsize_id"), $connect -> getValue($resultSet, "rsize_name"), $connect -> getValue($resultSet, "rtype_id"), $connect -> getValue($resultSet, "rtype_name"), $connect -> getValue($resultSet, "rsize_price"));

					$resultRow = $connect -> getTableRow($resultSet);
					$i++;
				}

				return $contents;
			}
		} else {
			return false;
		}
		$connect -> closeConnection($dbLink);

	}

	function getAllReservations($sentQuery) {

		$query = "SELECT reservations.rsvn_id, reservations.room_fk, room_size.rsize_name, reservations.date_arrive, reservations.date_depart, reservation_guest.guest_id, reservation_guest.guest_name, reservation_guest.guest_email, reservation_guest.guest_company, room_size.rsize_price, reservations.notes, reservations.user_fk, reservations.status_fk, DateDiff('d',[date_arrive],[date_depart],2) AS nights FROM (room_size RIGHT JOIN room ON room_size.rsize_id = room.rsize_fk) RIGHT JOIN (reservation_guest RIGHT JOIN reservations ON reservation_guest.guest_id = reservations.guest_fk) ON room.room_id = reservations.room_fk";
		
		if(!empty($sentQuery)) {
			$query .= " WHERE ".$sentQuery;
		}
		$query .=";";

		$connect = New BaseConnection();
		$dbLink = $connect -> openConnection();
		$resultSet = $connect -> queryDB($dbLink, $query);

		if (!empty($resultSet)) {
			$resultRow = $connect -> getTableRow($resultSet);
			if (!empty($resultRow)) {
				$i = 0;

				while ($resultRow == TRUE) {
					$contents[$i] = new Reservation($connect -> getValue($resultSet, "rsvn_id"), $connect -> getValue($resultSet, "room_fk"), date("d/m/Y",strtotime($connect -> getValue($resultSet, "date_arrive"))), date("d/m/Y",strtotime($connect -> getValue($resultSet, "date_depart"))), $connect -> getValue($resultSet, "notes"));
					$contents[$i]->setGuestID($connect -> getValue($resultSet, "guest_id"));
					$contents[$i]->setGuestName($connect -> getValue($resultSet, "guest_name"));
					$contents[$i]->setGuestEmail($connect -> getValue($resultSet, "guest_email"));
					$contents[$i]->setGuestCompany($connect -> getValue($resultSet, "guest_company"));
					$contents[$i]->setRoomSize($connect -> getValue($resultSet, "rsize_name"));
					$contents[$i]->setAdminID($connect -> getValue($resultSet, "user_fk"));
					$contents[$i]->setStatusID($connect -> getValue($resultSet, "status_fk"));
					$contents[$i]->setPrice($connect -> getValue($resultSet, "rsize_price"));
					
					if($connect -> getValue($resultSet, "nights")<1) {
					$contents[$i]->setLength(1);
						} else $contents[$i]->setLength($connect -> getValue($resultSet, "nights"));
					

					$resultRow = $connect -> getTableRow($resultSet);
					$i++;
				}

				return $contents;
			}
		} else {
			return false;
		}
		$connect -> closeConnection($dbLink);

	}

	function checkAvailability($dateA, $dateB, $type) {

		$dateArrive = $this -> prepareDatesForQuery($dateA);
		$dateDepart = $this -> prepareDatesForQuery($dateB);

		$query = "SELECT reservations.*, room.rsize_fk, room_size.rtype_fk
FROM (room_type RIGHT JOIN (room_size RIGHT JOIN room ON room_size.rsize_id = room.rsize_fk) ON room_type.rtype_id = room_size.rtype_fk) RIGHT JOIN reservations ON room.room_id = reservations.room_fk WHERE ( (room.rsize_fk=" . $type . " AND reservations.status_fk<3) AND (((reservations.date_depart) Between DateAdd('d',1,#" . $dateArrive . "#) AND #" . $dateDepart . "#)) OR (((#" . $dateDepart . "#) BETWEEN [date_arrive] And [date_depart])));";

		$connect = New BaseConnection();
		$dbLink = $connect -> openConnection();
		$resultSet = $connect -> queryDB($dbLink, $query);

		if (!empty($resultSet)) {
			$resultRow = $connect -> getTableRow($resultSet);
			if (!empty($resultRow)) {

				$i = 0;
				$filter = "";

				while ($resultRow == TRUE) {
					$filter .= $connect -> getValue($resultSet, "room_fk") . ",";

					$resultRow = $connect -> getTableRow($resultSet);
					$i++;
				}
				$filter = rtrim($filter, ",");
				return $filter;
			}
		} else {
			return false;
		}
		$connect -> closeConnection($dbLink);

	}

	function insertRecord($sentTable, $sentAttributes, $sentValues) {

		$query = "INSERT INTO " . $sentTable . " " . $sentAttributes . " VALUES " . $sentValues . ";";

		$connect = New BaseConnection();
		$dbLink = $connect -> openConnection();
		$resultSet = $connect -> queryDB($dbLink, $query);

		if ($resultSet != FALSE) {

			$query = "SELECT @@IDENTITY AS LastID;";
			$retrieveLastID = $connect -> queryDB($dbLink, $query);

			if ($retrieveLastID != FALSE) {

				return $connect -> getValue($retrieveLastID, "LastID");

			} else
				return FALSE;

		} else
			return FALSE;

	}

}
?>