<?php
	
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'User.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'connection'.DIRECTORY_SEPARATOR.'ConnectionFactory.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'connection'.DIRECTORY_SEPARATOR.'Connection.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'utility'.DIRECTORY_SEPARATOR.'EmailValidator.php';
	class UserManagementModel {
		
		public function __construct() {
			
		}
		
		public function getUsersCount() {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select count(user_id) as count from uol_user';
			
            $dbResult = $connection->query($dbCon, $query);
            
            $row = $connection->fetchRow($dbResult);
			
			$count = $connection->getColumnValue($dbResult, 'count');
			
			$connection->close($dbCon);
			
			return $count;
		}
		
		public function getUsers() {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from uol_user';
			
            $dbResult = $connection->query($dbCon, $query);
			
            $users = Array();
           
		    $row = $connection->fetchRow($dbResult);
			
			for ($i = 0; $row == true; $i++) {
				
				$user = $this->mapUser($dbResult, $connection);
				
				$users[$i] = $user;
                
                $row = $connection->fetchRow($dbResult);
			}
			
			unset($row);
			
			$connection->close($dbCon);
			
			return $users;
		}

		public function getUser($userId) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from uol_user where user_id = '. $userId;
			
            $dbResult = $connection->query($dbCon, $query);
			
		    $row = $connection->fetchRow($dbResult);
			
			$user = $this->mapUser($dbResult, $connection);
				
			$connection->close($dbCon);
			
			return $user;	
		}
		
		public function searchUsers($searchValue) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from uol_user '. 
				'where user_uname like \'%'. $searchValue . '%\''.
				' or user_first_name like \'%'. $searchValue . '%\''. 
				' or user_last_name like \'%'. $searchValue . '%\'';
				' or user_email like \'%'. $searchValue .'%\''.
				' order by user_uname';
			
			
            $dbResult = $connection->query($dbCon, $query);
			
            $users = Array();
           
		    $row = $connection->fetchRow($dbResult);
			
			for ($i = 0; $row == true; $i++) {
				
				$user = $this->mapUser($dbResult, $connection);
				
				$users[$i] = $user;
                
                $row = $connection->fetchRow($dbResult);
			}
			
			unset($row);
			
			$connection->close($dbCon);
			
			return $users;
		}
		
		public function getUserByUsername($username) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from uol_user where user_uname = \''. $username. '\'';
			
            $dbResult = $connection->query($dbCon, $query);
			
		    $row = $connection->fetchRow($dbResult);
			
			$user = $this->mapUser($dbResult, $connection);
				
			$connection->close($dbCon);
			
			return $user;	
		}
		
		private function mapUser($dbResult,$connection) {
			$userId = $connection->getColumnValue($dbResult, 'user_id');
			$firstName = $connection->getColumnValue($dbResult, 'user_first_name');
			$lastName = $connection->getColumnValue($dbResult, 'user_last_name');
			$email = $connection->getColumnValue($dbResult, 'user_email');
			$username = $connection->getColumnValue($dbResult, 'user_uname');
			$passwordSha = $connection->getColumnValue($dbResult, 'user_password_sha');
				
			return new User($userId,$firstName, $lastName, $email, $username, $passwordSha);
		}

		public function addUser($username, $firstName, $lastName, $email, $passwordSha) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'insert into uol_user (user_uname, user_first_name, user_last_name, user_password_sha, user_email) '.
				'values(\''. $username .'\',\''. $firstName .'\',\''. $lastName .'\',\''. $passwordSha .'\',\''. $email .'\')';
			
			
            $dbResult = $connection->query($dbCon, $query);	
			
			$connection->close($dbCon);
			
		}
		
		public function editUser($userId, $firstName, $lastName, $email, $passwordSha, $updatePassword) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'update uol_user set user_first_name = \''. $firstName .'\','.
				'user_last_name = \''. $lastName .'\', user_email = \''. $email .'\' where user_id = '. $userId;
				
			$dbResult = $connection->query($dbCon, $query);
			
			if ($updatePassword == true) {
				$query = 'update uol_user set user_password_sha = \''. $passwordSha .'\' where user_id = '. $userId;
				$dbResult = $connection->query($dbCon, $query);
			}
			
			$connection->close($dbCon);
		}
	}
?>