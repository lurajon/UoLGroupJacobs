<?php

	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'GuestbookView.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'GuestbookModel.php';

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
		
		/**
		 * cleans user input: removes html tags and slashes
		 */
		public function cleanInput($input) {
			$value = strip_tags($input);
			$value = stripslashes($value);

			return $value;
		}
		
		public function addGuestbookEntry($name, $email, $title, $comment) {
			date_default_timezone_set('Europe/London'); 
			$now = date('d/m/Y H:i:s');
			
			$name = $this->cleanInput($name);
			$email = $this->cleanInput($email); 
			$title = $this->cleanInput($title);
			$comment = $this->cleanInput($comment);
			    
			$guestbookEntry = $this->_guestbookModel->addGuestbookEntry($now, $name, $email, $title, $comment);
			$this->_guestbookView->printInfoMessage('Your entry has been submitted. It will be displayed when the entry has been approved');
		}
		
		public function guestbookEntryDetails($entryId) {
			header('Location: ../../adminpanel/guestbook/entryDetails.php?entryId='. $entryId);
		}
		
		public function approveGuestbookEntry($entryId) {
			$entryId = strip_tags($entryId);
            $entryId = stripslashes($entryId);
			
			$entry = $this->_guestbookModel->getGuestbookEntry($entryId);
			
			if (!isset($entry)) {
				$this->_guestbookView->printErrorMessage('Entry with id ' . $entryId .' does not exist');
				return;
			}
			
			$this->_guestbookModel->updateStatus($entryId, 2);
			$this->_guestbookView->printInfoMessage('Entry approved');
		}
		
		public function disableGuestbookEntry($entryId) {
			$entryId = strip_tags($entryId);
            $entryId = stripslashes($entryId);
			
			$entry = $this->_guestbookModel->getGuestbookEntry($entryId);
			
			if (!isset($entry)) {
				$this->_guestbookView->printErrorMessage('Entry with id ' . $entryId .' does not exist');
				return;
			}
			
			$this->_guestbookModel->updateStatus($entryId, -1);
			$this->_guestbookView->printInfoMessage('Entry deleted');
		}

		public function getPendingGuestbookEntriesCount() {
			$this->_guestbookView->getPendingGuestbookEntriesCountJSON();
		}
		
		public function searchGuestbookEntries($searchValue) {
			$this->_guestbookView->getGuestbookEntriesJSON($searchValue);
		}
	}
	
	extract($_REQUEST);
	
	$guestbookModel = new GuestbookModel();
	$guestbookController = new GuestbookController($guestbookModel);
	$guestbookView = new GuestbookView($guestbookModel, $guestbookController);
	$guestbookController->setGuestbookView($guestbookView);
	
	if (isset($list)) {
		
		if (strcmp($list, 'pending') == 0) {
			$guestbookController->getPendingGuestbookEntries();
		} elseif (strcmp($list, 'approved') == 0) {
			$guestbookController->getApprovedGuestbookEntries();
		}
	} elseif(isset($action)) {
		if (strcmp($action, 'add') == 0) {
			$guestbookController->addGuestbookEntry($name, $email, $title, $comment);
		} elseif (strcmp($action,'details') == 0) {
			$guestbookController->guestbookEntryDetails($entryId);
		}
	} elseif (isset($operation)) {
		if (strcmp($operation, 'post') == 0) {
			$guestbookController->approveGuestbookEntry($entryId);
		} elseif (strcmp($operation, 'delete') == 0) {
			$guestbookController->disableGuestbookEntry($entryId);
		} 
	} elseif (isset($info)) {
		if (strcmp($info, 'pendingCount') == 0) {
			$guestbookController->getPendingGuestbookEntriesCount();
		}
	} elseif (isset($search)) {
		if (strcmp($search, 'Search') == 0) {
			$guestbookController->searchGuestbookEntries($searchValue);
		}
	}
	
?>