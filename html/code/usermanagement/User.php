<?php

	class User {
		private $_userId;
		private $_firstName;
		private $_lastName;
		private $_email;
		private $_username;
		private $_passwordSha;
		
		public function __construct($userId, $firstName, $lastName, $email, $username, $passwordSha) {
			$this->setUserId($userId);
			$this->setEmail($email);
			$this->setFirstName($firstName);
			$this->setLastName($lastName);
			$this->setPasswordSha($passwordSha);
			$this->setUsername($username);
		}
		
		public function setUserId($userId) {
			$this->_userId = $userId;
		}
		
		public function getUserId() {
			return $this->_userId;
		}
		
		public function setUsername($username) {
			$this->_username = $username;
		}
		
		public function getUsername() {
			return $this->_username;
		}
		
		public function setFirstName($firstName) {
			$this->_firstName = $firstName;
		}
		
		public function getFirstName() {
			return $this->_firstName;
		}
		
		public function setLastName($lastName) {
			$this->_lastName = $lastName;
		}
		
		public function getLastName() {
			return $this->_lastName;
		}
		
		public function setEmail($email) {
			$this->_email = $email;
		}
		
		public function getEmail() {
			return $this->_email;
		}
		
		public function setPasswordSha($passwordSha) {
			$this->_passwordSha = $passwordSha;
		}
		
		public function getPasswordSha() {
			return $this->_passwordSha;
		}
		
		public function getJSON() {
			return '{ "user" : { "userId": "'. $this->getUserId().'",'.
			 '"firstName": "'. $this->getFirstName().'",'.
			 '"lastName": "'. $this->getLastName().'",'.
			 '"email": "'. $this->getEmail().'",'.
			 '"username": "'. $this->getUsername().'",'.
			 '"passwordSha": "'. $this->getPasswordSha().'"}}';
		}
	}
?>