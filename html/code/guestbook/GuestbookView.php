<?php
	include_once 'GuestbookController.php';
	include_once 'GuestbookModel.php';
	include_once 'GuestbookEntry.php';

	class GuestbookView {
		private $_guestbookModel;
		private $_guestbookController;
		
		private $_message;
		
		public function __construct($model, $controller) {
			$this->_guestbookController = $controller;
			$this->_guestbookModel = $model;
		}
		
		private function getGuestbookEntriesWithStatus($status) {
			
		}
		
		public function getPendingGuestbookEntries() {
			return $this->getGuestbookEntriesWithStatus(0);
		}
		
		public function getPendingGuestbookEntriesJSON() {
			$entries = $this->getPendingGuestbookEntries();
			
			print($this->getEntriesAsJSON($entries));
		}
		
		public function getApprovedGuestbookEntries() {
			return $this->getGuestbookEntriesWithStatus(1);
		}
		
		public function getApprovedGuestbookEntriesJSON() {
			$entries = $this->getApprovedGuestbookEntries();
			
			print($this->getEntriesAsJSON($entries));
		}
		
		private function getEntriesAsJSON($entries) {
			
			if(empty($entries)) {
				$this->setErrorMessage('There are no guestbook entries');
     			return $this->_message;
			}
			
			$output = '{ "guestbookEntries" : [';
			
			$index = 0;
			foreach ($entries as $entry) {
				if ($index > 0) {
					$output += ',';
				}
				$output += $entry->getJSON();
			}
			
			$output += ']};';
			
			return $output;
		}
		
		function printMessage() {
            print $this->_message;
        }
        
        function setErrorMessage($errorMessage) {
            $this->_message = '{ "message": { "type": "error", "content": "'. $errorMessage.'" } }';
           
        }
        
        function setInfoMessage($infoMessage) {
            $this->_message = '{ "message": { "type": "info", "content": "'. $infoMessage.'"} }';
            
        }
	}
?>