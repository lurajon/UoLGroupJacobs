<?php

	include_once 'GuestbookEntry.php';
	
	class GuestbookModel {
		
		function __construct() {
            
        }
		
		function getPendingGuestbookEntries() {
			$connection = ConnectionFactory::getConnection('odbc');
			
			$dbCon = $connection->connect();
            
            $dbResult = $connection->query($dbCon, 'select * from guestbook_entry where status_id = 0');
            
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
				$userId = $connection->getColumnValue($dbResult, 'user_id');
				$statusId = $connection->getColumnValue($dbResult, 'status_id');
                
                $guestbookEntries[$i] = 
                	new GuestbookEntry($entryId,$entryDate, $entryTitle, $entryComment, 
                		$userId, $statusId, $entryAuthorName, $entryAuthorEmail);
                
                $row = $connection->fetchRow($dbResult);
            }
            
            $connection->close($dbCon);
            
            return $guestbookEntries;
		}	
	}
?>