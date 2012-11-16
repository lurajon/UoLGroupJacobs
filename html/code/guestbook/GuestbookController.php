<?php

	include_once 'GuestbookModel.php';
	include_once 'GuestbookView.php';

	class GuestbookController {
		private $_guestbookView;
		private $_guestbookModel;
		
		public function __construct($guestbookModel) {
			$this->_guestbookModel = $guestbookModel;
		}
		
		public function setGuestbookView($guestbookView) {
			$this->_guestbookView = $guestbookView;
		}
		
		public function getPendingGuestbookEntries() {
			if(!isset($this->_guestbookView)) {
				return;
			}
			
			$this->_guestbookView->getPendingGuestbookEntriesJSON();
		}
		
		public function getApprovedGuestbookEntries() {
			if(!isset($this->_guestbookView)) {
				return;
			}
			
			$this->_guestbookView->getApprovedGuestbookEntriesJSON();
		}
		
		public function addGuestbookEntry($name, $email, $title, $comment) {
			$now = getdate();
			$entryDate = $now['year'].'-'. $now['mon']. '-' .$now['mday']. ' '. $now['hours']. ':'. $now['minutes'];	
			$guestbookEntry = $this->_guestbookModel->addGuestbookEntry($entryDate, $name, $email, $title, $comment);
		}
	}
	
	extract($_REQUEST);
	
	$guestbookModel = new GuestbookModel();
	$guestbookController = new GuestbookController($guestbookModel);
	$guestbookView = new GuestbookView($guestbookModel, $guestbookController);
	$guestbookController->setGuestbookView($guestbookView);
	
	if (isset($list)) {
		
		if (strcmp($list, 'pending')) {
			$guestbookController->getPendingGuestbookEntries();
		} else if (strcmp($list, 'approved')) {
			$guestbookController->getApprovedGuestbookEntries();
		}
	} else if(isset($action)) {
		
		if (strcmp($action, 'add')) {
			$guestbookController->addGuestbookEntry($name, $email, $title, $comment);
		}
	}
?>