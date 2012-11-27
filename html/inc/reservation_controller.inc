<?php
include_once 'reservation_model.inc';
include_once 'reservation_view.inc';

class ReservationController {

	private $model, $view;

	public function __construct($sentModel, $sentView) {
		$this -> model = $sentModel;
		$this -> view = $sentView;
	}

	public function cleanInput($input) {// cleans user input: removes html tags and slashes
		$value = strip_tags($input);
		$value = stripslashes($value);

		return $value;

	}

	public function queryRoomsByID($sentValue) {

		$data = $this -> model -> getRooms("(room.room_id=$sentValue);");
		$this -> view -> showRooms($data);
	}

	public function queryRoomsByType($sentValue) {

		$data = $this -> model -> getRooms("(room_type.rtype_id=$sentValue);");
		$this -> view -> showRooms($data);
	}

	public function queryRoomsBySize($sentValue) {

		$data = $this -> model -> getRooms("(room_size.rsize_id=$sentValue);");
		return $data;
		//$this -> view -> showRooms($data);
	}

	public function queryReservations($sentData, $variant) {

		$sentArriveDate = $this -> cleanInput($sentData["arrive_date"]);
		$sentDepartDate = $this -> cleanInput($sentData["depart_date"]);
		$sentSize = $this -> cleanInput($sentData["room_size"]);

		$data = $this -> model -> checkAvailability($sentArriveDate, $sentDepartDate, $sentSize);
		if (!empty($data)) {// reservations found within given time frame
			$filter = "(((room.room_id) NOT IN ($data)) AND (room_size.rsize_id=$sentSize));";
			$available = $this -> model -> getRooms($filter);

			if (!empty($available)) {// rooms available
				$this -> view -> showReservationForm($sentArriveDate, $sentDepartDate, $available, $variant);
				// return available rooms
			} else {// no rooms available

				$this -> view -> showNoRoomsAvailable($variant);
				$variant = "alternative";
				$alternativeSize = $this -> model -> getRoomSizesOfSameType($sentSize);
				$sentData["room_size"] = $alternativeSize;
				$altReservations = $this -> queryReservations($sentData, $variant);
			}

		} else {// no reservations found, proceed with returning available rooms

			$available = $this -> queryRoomsBySize($sentSize);
			$this -> view -> showReservationForm($sentArriveDate, $sentDepartDate, $available, $variant);

		}
	}

	public function addReservation($sentData) {

		$sentArriveDate = $this -> cleanInput($sentData["arrive_date"]);
		$sentDepartDate = $this -> cleanInput($sentData["depart_date"]);
		$sentRoomID = $this -> cleanInput($sentData["room_id"]);
		$sentName = $this -> cleanInput($sentData["customer_name"]);
		$sentMail = $this -> cleanInput($sentData["customer_mail"]);
		$sentComapany = $this -> cleanInput($sentData["customer_company"]);
		$sentNote = $this -> cleanInput($sentData["customer_message"]);

		// handle guest
		$guestTable = "reservation_guest";
		$guestColumns = "(guest_name, guest_email, guest_company)";
		$guestValues = "('" . $sentName . "','" . $sentMail . "','" . $sentComapany . "')";
		$addGuest = $this -> model -> insertRecord($guestTable, $guestColumns, $guestValues);
		if ($addGuest == FALSE) {
			$this -> view -> showReservationFailed();
			exit ;
		} else {

			$reservationTable = "reservations";
			$reservationColumns = "(guest_fk, room_fk, date_arrive, date_depart, notes)";
			$guestID = $addGuest;
			$reservationValues = "(" . $guestID . "," . $sentRoomID . ",'" . $sentArriveDate . "','" . $sentDepartDate . "','" . $sentNote . "')";

			$addReservation = $this -> model -> insertRecord($reservationTable, $reservationColumns, $reservationValues);
			if ($addReservation == FALSE) {
				$this -> view -> showReservationFailed();
				exit ;
			} else {

				$filter = "(reservations.rsvn_id=" . $addReservation . ")";
				$reservationDetails = $this -> model -> getAllReservations($filter);
				$this -> view -> showReservationOK($reservationDetails);

			}

		}

	}

}
?>