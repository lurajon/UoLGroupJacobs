<?php

class Reservation {

	private $reservationID, $guestFK, $roomFK, $roomSize, $roomPrice, $dateArrive, $dateDepart, $guestName, $guestEmail, $guestCompany, $notes, $adminFK, $statusFK, $length;

	function __construct($sentReservationID, $sentRoomFK, $sentDateArrive, $sentDateDepart, $sentNotes) {

		$this -> reservationID = $sentReservationID;
		$this -> roomFK = $sentRoomFK;
		$this -> dateArrive = $sentDateArrive;
		$this -> dateDepart = $sentDateDepart;
		$this -> notes = $sentNotes;

	}

	function getID() {
		return $this -> reservationID;
	}

	function setID($input) {
		$this -> reservationID = $input;
	}

	function getGuestID() {
		return $this -> guestFK;
	}

	function setGuestID($input) {
		$this -> guestFK = $input;
	}

	function getGuestName() {
		return $this -> guestName;
	}

	function setGuestName($input) {
		$this -> guestName = $input;
	}

	function getGuestEmail() {
		return $this -> guestEmail;
	}

	function setGuestEmail($input) {
		$this -> guestEmail = $input;
	}

	function getGuestCompany() {
		return $this -> guestCompany;
	}

	function setGuestCompany($input) {
		$this -> guestCompany = $input;
	}

	function getRoomID() {
		return $this -> roomFK;
	}

	function setRoomID($input) {
		$this -> roomFK = $input;
	}

	function getRoomSize() {
		return $this -> roomSize;
	}

	function setRoomSize($input) {
		$this -> roomSize = $input;
	}

	function getArriveDate() {
		return $this -> dateArrive;
	}

	function setArriveDate($input) {
		$this -> dateArrive = $input;
	}

	function getDepartDate() {
		return $this -> dateDepart;
	}

	function setDepartDate($input) {
		$this -> dateDepart = $input;
	}

	function getNotes() {
		return $this -> notes;
	}

	function setNotes($input) {
		$this -> notes = $input;
	}

	function getAdminID() {
		return $this -> adminFK;
	}

	function setAdminID($input) {
		$this -> adminFK = $input;
	}

	function getStatusID() {
		return $this -> statusFK;
	}

	function setStatusID($input) {
		$this -> statusFK = $input;
	}

	function getLength() {
		return $this -> length;
	}

	function setLength($input) {
		$this -> length = $input;
	}

	function getPrice() {
		return $this -> roomPrice;
	}

	function setPrice($input) {
		$this -> roomPrice = $input;
	}

}

class Room {
	private $roomID, $roomName, $roomSize, $roomSizeName, $roomType, $roomTypeName, $roomPrice;

	function __construct($sentID, $sentName, $sentSize, $sentSizeName, $sentType, $sentTypeName, $sentPrice) {

		$this -> setID($sentID);
		$this -> setName($sentName);
		$this -> setSizeID($sentSize);
		$this -> setSize($sentSizeName);
		$this -> setTypeID($sentType);
		$this -> setType($sentTypeName);
		$this -> setPrice($sentPrice);
	}

	function getID() {
		return $this -> roomID;
	}

	function setID($input) {
		$this -> roomID = $input;
	}

	function getName() {
		return $this -> roomName;
	}

	function setName($input) {
		$this -> roomName = $input;
	}

	function getSizeID() {
		return $this -> roomSize;
	}

	function setSizeID($input) {
		$this -> roomSize = $input;
	}

	function getSize() {
		return $this -> roomSizeName;
	}

	function setSize($input) {
		$this -> roomSizeName = $input;
	}

	function getTypeID() {
		return $this -> roomType;
	}

	function setTypeID($input) {
		$this -> roomType = $input;
	}

	function getType() {
		return $this -> roomTypeName;
	}

	function setType($input) {
		$this -> roomTypeName = $input;
	}

	function getPrice() {
		return $this -> roomPrice;
	}

	function setPrice($input) {
		$this -> roomPrice = $input;
	}

}
?>