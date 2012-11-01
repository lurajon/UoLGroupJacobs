<?php
 
    // file to demonstrate AJAX JS -- NOT COMPLETE
    
    $resevationId = $_POST["reservationId"];
    
    $success = true;
    
    if ($success) {
        echo "<div class=\"message success\"><span class=\"icon\"></span>Reservation saved successfully (reservation id:". $resevationId .")</div>";
    } else {
        echo "<div class=\"message error\"><span class=\"icon\"></span>Error saving reservation: ERROR MESSAGE HERE (reservation id:". $resevationId .")</div>";
    }

?>
