<?php

	include_once 'UserManagementModel.php';
	include_once 'UserManagementView.php';
	
	class UserManagementController {
		private $_userManagementModel;
		private $_userManagementView;
		
		public function __construct($userManagementModel) {
			$this->_userManagementModel = $userManagementModel;
		}
		
		public function setUserManagementView($userManagementView) {
			$this->_userManagementView = $userManagementView;
		}
		
		public function getUsersCount() {
			$this->_userManagementView->getUsersCountJSON();
		}
		
		public function getAllUsers() {
			$this->_userManagementView->getAllUsersJSON();
		}
		
		public function addUser($username, $firstName, $lastName, $email, $password, $confirmPassword) {
			addslashes($username);
            addslashes($firstName);
            addslashes($lastName);
            addslashes($email);
			
			$success = $this->validateUserFields('add', $username, $firstName, $lastName, $email, $password, $confirmPassword);
			
			if ($success == false) {
				return;
			}
			
			$passwordSha = sha1($password);
			$this->_userManagementModel->addUser($username, $firstName,$lastName, $email, $passwordSha);
			
			header('Location: ../../adminpanel/user/confirmation.php?actionComplete=add&username=' . $username);
		}
		
		public function editUser($userId, $username, $firstName, $lastName, $email, $password, $confirmPassword) {
			addslashes($firstName);
            addslashes($lastName);
            addslashes($email);
			addslashes($userId);
			
			$updatePassword = false;
			$passwordSha = '';
			
			if (isset($password) && strlen($password) > 0) {
				$updatePassword = true;
				$passwordSha = sha1($password);
			}
			
			$success = $this->validateUserFields('edit', null, $firstName, $lastName, $email, $password, $confirmPassword);
			
			echo($success);
			
			if ($success == false) {
				return;
			}
			
			$this->_userManagementModel->editUser($userId, $firstName,$lastName, $email, $passwordSha, $updatePassword);
			
			header('Location: ../../adminpanel/user/confirmation.php?actionComplete=edit&username=' . $username);
		}
		
		public function searchUsers($searchValue) {
			addslashes($searchValue);
			
			$users = $this->_userManagementModel->searchUsers($searchValue);
			
			if (empty($users)) {
				$this->_userManagementView->printErrorMessage("No users found when searching for ". $searchValue);
				return;
			}
			
			$this->_userManagementView->printUsersAsJSON($users);
			return;
		}
		
		public function validateUserFields($action, $username, $firstname, $lastname, $email, $password, $confirmPassword) {
			
			if ($action == 'add') {
				// check if user exist;
				$user = $this->_userManagementModel->getUserByUsername($username);
				if (isset($user) && $user->getUsername() == $username) {
					$this->_userManagementView->printErrorMessage('User with the username'. $username .' already exist');
					return false;
				}
				
				// validate passwords;
				if (strlen($password) < 6) {
					$this->_userManagementView->printErrorMessage('Invalid password lenght. Requires 6 digits');
					return false;
				}
				
				if (strcmp($password, $confirmPassword) != 0) {
					$this->_userManagementView->printErrorMessage('Password mismatch');
					return false;
				}
				
			} else if ($action == 'edit') {
				// check if we need to validate passwords
				
				$updatePassword = false;
			
				if (isset($password) && strlen($password) > 0) {
					$updatePassword = true;
				}
			
				if ($updatePassword) {
					// validate passwords;
					if (strlen($password) < 6) {
						$this->_userManagementView->printErrorMessage('Invalid password length. Requires 6 digits');
						return false;
					}
				
					if (strcmp($password, $confirmPassword) != 0) {
						$this->_userManagementView->printErrorMessage('Password mismatch');
						return false;
					}	
				}
			}
			
			// common fields
			if (strlen(trim($firstname)) == 0) {
				$this->_userManagementView->printErrorMessage('Missing firstname');
						return false;
			}
			
			if (strlen(trim($lastname)) == 0) {
				$this->_userManagementView->printErrorMessage('Missing lastname');
						return false;
			}
			
			$emailMessage = EmailValidator::validateEmail($email);
			if (isset($emailMessage)) {
				$this->_userManagementView->printErrorMessage($emailMessage);
				return false;
			}
			
			return true;
		}
	}
	
	extract($_REQUEST);
	
	$userManagementModel = new UserManagementModel();
	$userManagementController = new UserManagementController($userManagementModel);
	$userManagementView = new UserManagementView($userManagementController, $userManagementModel);
	$userManagementController->setUserManagementView($userManagementView);
	
	if (isset($info)) {
		if ($info == 'count') {
			$userManagementController->getUsersCount();
		}
	} elseif (isset($list)) {
		if ($list == 'all') {
			$userManagementController->getAllUsers();
		}
	} elseif (isset($action)) {
		if ($action == 'save_edit') {
			$userManagementController->editUser($userId, $username, $firstname, $lastname, $email, $password, $confirm);
		} elseif ($action == 'save_add') {
			$userManagementController->addUser($username, $firstname, $lastname, $email, $password, $confirm);
		} elseif ($action == 'validate_edit') {
			$userManagementController->validateUserFields('edit', $username, $firstname, $lastname, $email, $password, $confirm);
		} elseif ($action == 'validate_add') {
			$userManagementController->validateUserFields('add', $username, $firstname, $lastname, $email, $password, $confirm);
		}
	} elseif (isset($search)) {
		if ($search == 'Search') {
			$userManagementController->searchUsers($searchValue);
		}
	}
?>