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
	}
	
	extract($_GET);
	
	if (isset($list)) {
		$guestbookModel = new GuestbookModel();
		$guestbookController = new GuestbookController($guestbookModel);
		$guestbookView = new GuestbookView($guestbookModel, $guestbookController);
		$guestbookController->setGuestbookView($guestbookView);
		
		if (strcmp($list, 'pending')) {
			$guestbookController->getPendingGuestbookEntries();
		} else if (strcmp($list, 'approved')) {
			$guestbookController->getApprovedGuestbookEntries();
		}
	}
?>