<?php

	
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'GuestbookController.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'GuestbookModel.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'GuestbookEntry.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'common'. DIRECTORY_SEPARATOR. 'AbstractView.php';

	class GuestbookView extends AbstractView {
		private $_guestbookModel;
		private $_guestbookController;
		
		public function __construct($model, $controller) {
			$this->_guestbookController = $controller;
			$this->_guestbookModel = $model;
		}
		
		public function getGuestbookEntry($entryId) {
			return $this->_guestbookModel->getGuestbookEntry($entryId);
		}
		
		private function getGuestbookEntriesWithStatus($status, $reverse) {
			return $this->_guestbookModel->getGuestbookEntries($status, $reverse);
		}
		
		public function getGuestbookEntriesJSON($searchValue) {
			$entries = $this->_guestbookModel->findGuestbookEntries($searchValue);
			
			print($this->getEntriesAsJSON($entries));
		}
		
		public function getPendingGuestbookEntries() {
			return $this->getGuestbookEntriesWithStatus(0, FALSE);
		}
		
		public function getPendingGuestbookEntriesJSON() {
			$entries = $this->getPendingGuestbookEntries();
			
			print($this->getEntriesAsJSON($entries));
		}
		
		public function getApprovedGuestbookEntries($reverse) {
			return $this->getGuestbookEntriesWithStatus(1, $reverse);
		}
		
		public function printApprovedGuestbookEntries($reverse) {
			$entries = $this->getApprovedGuestbookEntries(true);
			
      		if(empty($entries)) {
      			print("Be the first to add an entry!");	
      		} else {
      			print('<table>');
      			foreach ($entries as $entry) {
      				$this->printEntryRow($entry);
      			}
      			
      			unset($entry);
				print('</table>');
      		}
      		
		}
		
		public function getApprovedGuestbookEntriesJSON() {
			$entries = $this->getApprovedGuestbookEntries(FALSE);
			
			print($this->getEntriesAsJSON($entries));
		}
		
		private function getEntriesAsJSON($entries) {
			
			if(empty($entries)) {
				$this->setErrorMessage('There are no guestbook entries');
     			return $this->getMessage();
			}
			
			$output = '{ "guestbookEntries" : [';
			
			$index = 0;
			foreach ($entries as $entry) {
				if ($index > 0) {
					$output = $output . ',';
				}
				$output = $output . $entry->getJSON();
				
				
				$index = $index + 1;
			}
			
			$output = $output . ']}';
			
			return $output;
		}
		
		function printEntryRow($entry) {
			if (!isset($entry)) {
				return;
			}
			
			$output = '<tr>';
			$output = $output.'<td>';
			
			// gravatar hash
			$emailHash = md5( strtolower( trim( $entry->getEntryAuthorMail() ) ) );
			
			$output = $output.'<img src"http://www.gravatar.com/avatar/'. $emailHash. '">';
			$output = $output. $entry->getEntryAuthorName();
			$output = $output.'</td>';
			
			$output = $output.'</td>';
			$output = $output.'<td>';
			$output = $output.'</td>';
			$output = $output.'</tr>';
			
			print($output);
		}
		
		function getPendingGuestbookEntriesCountJSON() {
			$count = $this->_guestbookModel->getPendingGuestbookEntriesCount();
			
			echo('{ "guestbookInfo": { "count": "'. $count.'"} }');
		}
	}
?>