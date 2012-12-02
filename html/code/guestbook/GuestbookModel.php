<?php

	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. 'GuestbookEntry.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'connection'.DIRECTORY_SEPARATOR.'ConnectionFactory.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'connection'.DIRECTORY_SEPARATOR.'Connection.php';
	
	class GuestbookModel {
		
		public function __construct() {
            
        }
		
		public function findGuestbookEntries($searchValue) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from guestbook_entry where entry_title like \'%'. $searchValue .'%\''.
			' or entry_comment like \'%'. $searchValue .'%\''.
			' or entry_author_name like \'%'. $searchValue .'%\''.
			' order by entry_date';
			
            $dbResult = $connection->query($dbCon, $query);
            $guestbookEntries = Array();
            
            $rows = $connection->getRows($dbResult);
            $row = $connection->fetchRow($dbResult);
          	
			 for ($i = 0; $row == true; $i++) {
            	
                $entryId = $connection->getColumnValue($dbResult, 'entry_id');
				$entryDate = $connection->getColumnValue($dbResult, 'entry_date');
                $entryTitle = $connection->getColumnValue($dbResult, 'entry_title');
                $entryComment = $connection->getColumnValue($dbResult, 'entry_comment');
				$entryAuthorName = $connection->getColumnValue($dbResult, 'entry_author_name');
				$entryAuthorEmail = $connection->getColumnValue($dbResult, 'entry_author_email');
				$userId = $connection->getColumnValue($dbResult, 'user_fk');
				$statusId = $connection->getColumnValue($dbResult, 'status_fk');
                
                $guestbookEntries[$i] = 
                	new GuestbookEntry($entryId,$entryDate, $entryTitle, $entryComment, 
                		$userId, $statusId, $entryAuthorName, $entryAuthorEmail);
                
                $row = $connection->fetchRow($dbResult);
            }
            
            $connection->close($dbCon);
			
            return $guestbookEntries;
		}
		
		public function getGuestbookEntries($status, $reverse) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from guestbook_entry where status_fk = ' . $status. ' order by entry_date';
			
			if (isset($reverse)) {
				if(is_bool($reverse) == TRUE) {
					
					$query = $query . ' desc;';
				}
			}
			
            $dbResult = $connection->query($dbCon, $query);
            $guestbookEntries = Array();
            
            $rows = $connection->getRows($dbResult);
            $row = $connection->fetchRow($dbResult);
          	
			 for ($i = 0; $row == true; $i++) {
            	
                $entryId = $connection->getColumnValue($dbResult, 'entry_id');
				$entryDate = $connection->getColumnValue($dbResult, 'entry_date');
                $entryTitle = $connection->getColumnValue($dbResult, 'entry_title');
                $entryComment = $connection->getColumnValue($dbResult, 'entry_comment');
				$entryAuthorName = $connection->getColumnValue($dbResult, 'entry_author_name');
				$entryAuthorEmail = $connection->getColumnValue($dbResult, 'entry_author_email');
				$userId = $connection->getColumnValue($dbResult, 'user_fk');
				$statusId = $connection->getColumnValue($dbResult, 'status_fk');
                
                $guestbookEntries[$i] = 
                	new GuestbookEntry($entryId,$entryDate, $entryTitle, $entryComment, 
                		$userId, $statusId, $entryAuthorName, $entryAuthorEmail);
                
                $row = $connection->fetchRow($dbResult);
            }
            
            $connection->close($dbCon);
			
            return $guestbookEntries;
		}

		public function addGuestbookEntry($entryDate, $entryAuthorName, $entryAuthorEmail, $entryTitle, $entryComment) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
            
			$query = 'insert into guestbook_entry (entry_date,entry_title,entry_comment,entry_author_name,entry_author_email,user_fk, status_fk)'.
				' values (\''. $entryDate .'\',\''. $entryTitle .'\',\''. $entryComment .'\',\''. $entryAuthorName .'\',\''. $entryAuthorEmail .'\',1, 0)';
			
            $dbResult = $connection->query($dbCon, $query);
			
			$connection->close($dbCon);
			
			return null;
		}
		
		public function getGuestbookEntry($entryId) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select * from guestbook_entry where entry_id = ' . $entryId;
			
			$dbResult = $connection->query($dbCon, $query);
			
			$rows = $connection->getRows($dbResult);
            
            $row = $connection->fetchRow($dbResult);
			
			$entryId = $connection->getColumnValue($dbResult, 'entry_id');
			$entryDate = $connection->getColumnValue($dbResult, 'entry_date');
            $entryTitle = $connection->getColumnValue($dbResult, 'entry_title');
            $entryComment = $connection->getColumnValue($dbResult, 'entry_comment');
			$entryAuthorName = $connection->getColumnValue($dbResult, 'entry_author_name');
			$entryAuthorEmail = $connection->getColumnValue($dbResult, 'entry_author_email');
			$userId = $connection->getColumnValue($dbResult, 'user_fk');
			$statusId = $connection->getColumnValue($dbResult, 'status_fk');
                
            $guestbookEntry = new GuestbookEntry($entryId,$entryDate, $entryTitle, $entryComment, 
                		$userId, $statusId, $entryAuthorName, $entryAuthorEmail);
			
			$connection->close($dbCon);
			
			return $guestbookEntry;
		}

		public function updateStatus($entryId, $status) {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'update guestbook_entry set status_fk = '.$status.' where entry_id = ' . $entryId;
			
			$dbResult = $connection->query($dbCon, $query);
			
			$connection->close($dbCon);
		}

		public function getPendingGuestbookEntriesCount() {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
			
			$query = 'select count(entry_id) as count from guestbook_entry where status_fk = 0';
			
            $dbResult = $connection->query($dbCon, $query);
            
            $row = $connection->fetchRow($dbResult);
			
			$count = $connection->getColumnValue($dbResult, 'count');
			
			$connection->close($dbCon);
			
			return $count;
		}
	}
?>