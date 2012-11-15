<?php

	class GuestbookEntry {
		private $_entryId;
		private $_entryDate;
		private $_entryTitle;
		private $_entryComment;
		private $_userId;
		private $_statusId;
		private $_entry_author_name;
		private $_entry_author_email;
		
		function __construct($entryId, $entryDate, $entryTitle, $entryComment, $userId, $statusId, $entryAuthorName, $entryAuthorEmail) {
			$this->setEntryId($entryId);
			$this->setEntryDate($entryDate);
			$this->setEntryTitle($entryTitle);
			$this->setEntryComment($entryComment);
			$this->setEntryAuthorName($entryAuthorName);
			$this->setEntryAuthorEmail($entryAuthorEmail);
			$this->setUserId($userId);
			$this->setStatusId($statusId);
		}
		
		function getEntryId() {
			return $this->_entryId;
		}
		
		function setEntryId($entryId) {
			$this->_entryId = $entryId;
		}
		
		function getEntryDate() {
			return $this->_entryDate;
		}
		
		function setEntryDate($entryDate) {
			$this->_entryDate = $entryDate;
		}
		
		function getEntryTitle() {
			return $this->_entryTitle;
		}
		
		function setEntryTitle($entryTitle) {
			$this->_entryTitle = $entryTitle;
		}
		
		function getEntryComment() {
			return $this->_entryComment;
		}
		
		function setEntryComment($entryComment) {
			$this->_entryComment = $entryComment;
		}
		
		function getEntryAuthorName() {
			return $this->_entryAuthorName;
		}
		
		function setEntryAuthorName($entryAuthorName) {
			$this->_entryAuthorName = $entryAuthorName;
		}
		
		function getUserId() {
			return $this->_userId;
		}
		
		function setUserId($userId) {
			$this->_userId = $userId;
		}
		
		function getStatusId() {
			return $this->_statusId;
		}
		
		function setStatusId($statusId) {
			$this->_statusId = $statusId;
		}
		
		function getEntryAuthorEmail() {
			return $this->_entryAuthorEmail;
		}
		
		function setEntryAuthorEmail($entryAuthorEmail) {
			$this->_entryAuthorEmail = $entryAuthorEmail;
		}
		
		function getJSON() {
			return '{ "guestbookEntry" { "entryId": "'. $this->getEntryId().'",'.
			 '"entryTitle": "'. $this->getEntryTitle().'",'.
			 '"entryDate": "'. $this->getEntryDate().'",'.
			 '"entryComment": "'. $this->getEntryComment().'",'.
			 '"entryAuthorName": "'. $this->getEntryAuthorName().'",'.
			 '"entryAuthorEmail": "'. $this->getEntryAuthorEmail().'",'.
			 '"userId": "'. $this->getUserId().'",'.
			 '"statusId": "'. $this->getStatusId().'"}}';
		}
	}
?>