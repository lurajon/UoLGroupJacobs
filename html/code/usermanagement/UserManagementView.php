<?php

	
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'UserManagementController.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'UserManagementModel.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'User.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'common'. DIRECTORY_SEPARATOR. 'AbstractView.php';
	
	class UserManagementView extends AbstractView {
		private $_userManagementController;
		private $_userManagementModel;
		
		public function __construct($userManagementController, $userManagementModel) {
			$this->_userManagementController = $userManagementController;
			$this->_userManagementModel = $userManagementModel;
		}
		
		public function getUser($userId) {
			return $this->_userManagementModel->getUser($userId);
		}
		
		public function getUserByUsername($username) {
			return $this->_userManagementModel->getUserByUsername($username);
		}
		
		public function getUsersCountJSON() {
			$count = $this->_userManagementModel->getUsersCount();
			
			echo('{ "usersInfo": { "count": "'. $count.'"} }');
		}
		
		public function getAllUsersJSON() {
			$users = $this->_userManagementModel->getUsers();
			
			if (empty($users)) {
				$this->setErrorMessage('No users found');
				$this->printMessage();
			} else {
				print($this->getUsersAsJSON($users));
			}
		}
		
		public function printUsersAsJSON($users) {
			print($this->getUsersAsJSON($users));
		}
		
		private function getUsersAsJSON($users) {
			
			if(empty($users)) {
				$this->setErrorMessage('There are no users');
     			return $this->_message;
			}
			
			$output = '{ "users" : [';
			
			$index = 0;
			foreach ($users as $user) {
				if ($index > 0) {
					$output = $output . ',';
				}
				$output = $output . $user->getJSON();
				
				
				$index = $index + 1;
			}
			
			$output = $output . ']}';
			
			return $output;
		}
		
	}
?>