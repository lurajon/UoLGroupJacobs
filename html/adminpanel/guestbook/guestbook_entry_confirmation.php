<?php

    // file to demonstrate AJAX JS -- NOT COMPLETE
    
    $guestbookEntryId = $_POST["entry_id"];
    $operation = $_POST["operation"];
    
    echo $postOperation;
    echo $deleteOperation;
    
    $successMessage = "";
    $errorMessage = "";
    
    $op = strcmp($operation, "post");
    
    if ($op == 0) {
        $successMessage = "Guestbook entry published";
        $errorMessage = "Error publishing the guestbook entry: ERROR MESSAGE HERE";
    } else {
        $successMessage = "Guestbook entry deleted successfully";
        $errorMessage = "Error deleting the guestbook entry: ERROR MESSAGE HERE ";
    }
    
    $success = false;
    
    if ($success) {
        echo "<div class=\"message success\"><span class=\"icon\"></span>". $successMessage."</div>";
    } else {
        echo "<div class=\"message error\"><span class=\"icon\"></span>". $errorMessage ."</div>";
    }

?>