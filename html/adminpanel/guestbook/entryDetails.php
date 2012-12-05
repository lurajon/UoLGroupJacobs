<?php 

 	echo '<?xml version="1.0" encoding="UTF-8"?>';
	
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR.'guestbook'.DIRECTORY_SEPARATOR.'GuestbookModel.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR.'guestbook'.DIRECTORY_SEPARATOR.'GuestbookView.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR.'guestbook'.DIRECTORY_SEPARATOR.'GuestbookEntry.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR.'guestbook'.DIRECTORY_SEPARATOR.'GuestbookController.php';
	
 	extract($_REQUEST);
	
	$guestbookModel = new GuestbookModel();
	$guestbookController = new GuestbookController($guestbookModel);
	$guestbookView = new GuestbookView($guestbookModel, $guestbookController);
	$guestbookController->setGuestbookView($guestbookView);
	
	
	$guestbookEntry = $guestbookView->getGuestbookEntry($entryId);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to UoL Hotel</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Yanone+Kaffeesatz:200,400' rel='stylesheet' type='text/css' />
<link href="../../css/admin-styles.css" rel="stylesheet" type="text/css" />
<script src="../../js/ajax_submit.js"></script>
<script>
  function setOperation(element) {
    var operationElement = document.getElementById('operation');
    operationElement.value = element.name;
  }
  
  function updateStatus(form) {
  	var operationElement = document.getElementById('operation');
  	
  	var response = Ajax.xmlHttpPost('../../code/guestbook/GuestbookController.php', form, false);
  
  	var output = document.getElementById('output');
  	
  	if (response == null || response.length == 0) {
  		
  	}
  	var output = document.getElementById('output');
  	try {
  		var msgObj = JSON.parse(response);
  		
  		output.className = 'message ' + msgObj.message.type;
  		output.innerHTML = msgObj.message.content;
  		
  		if (msgObj.message.type == 'info') {
  			var statusEle = document.getElementById('status');
  			statusEle.innerHTML = 'Approved';
  			statusEle.className = 'status approved';
  		}
  		
  	} catch(e) {
  		output.className = 'message error';
  		output.innerHTML = e;	
  	}
  	
  	
  }
</script>
</head>

<body class="admin">
<div class="holder">
  <div class="w140 pad_left_800">
    <div class="member_entry">Admnistration</div>
  </div>
  <div class="clear"></div>
  <div class="w460">
    <div class="site_logo"> HOTEL </div>
  </div>
  <div class="clear pad_bot_10"></div>
  <div class="w940">
    <div class="menu_holder">
      <div class="menu_main">
        <ul>
          <li><a href="../index.html">Home</a></li>
          <li><a href="../user/users.html">User Management</a></li>
          <li><a href="../reservations/reservations.html">Reservations</a></li>
          <li><a href="guestbook.html">Guestbook Management</a></li>
          <li><a href="../../index.html">Back to Hotel Site</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="clear pad_bot_10"></div>
   <!-- Content -->
  <div class="w940">
    
    <div class="header_holder margin_top_10">
      <!-- JL: enter your content header within <h1> element -->
        <h1>Details</h1>
       <!-- // JL -->
      </div>
      <!-- JL: please use space below to add your page contents -->
      <form action="../../code/guestbook/GuestbookController.php" onsubmit="updateStatus(this);return false;">
        <input type="hidden" value="<?php echo($guestbookEntry->getEntryId()); ?>" name="entryId" id="entryId" />
        <input type="hidden" value="post" name="operation" id="operation" />
        <div id="output"></div>
        <table id="details" class="w100p margin_top_10">
            <tbody>
                <tr>
                  <td colspan="5">
                  	<?php 
                  		$status = $guestbookEntry->getStatusId();
						
						$statusStyle = 'status pending';
						$statusMsg = 'Pending';
						
						if ($status == 2) {
							$statusStyle = 'status approved';
							$statusMsg = 'Approved';
						}
						
                  		echo('<span id="status" class="'. $statusStyle. '">'. $statusMsg .'</span>'); ?></td>
                </tr>
                <tr>
                  <td>Title</td>
                  <td colspan="4"><?php echo($guestbookEntry->getEntryTitle()); ?></td>
               </tr>
                <tr>
                    <td>Posted By</td>
                    <td><?php echo($guestbookEntry->getEntryAuthorName()); ?></td>
                    <td></td>
                    <td>Posted Date</td>
                    <td><?php echo($guestbookEntry->getEntryDate()); ?></td>
                </tr>
               <tr>
                <td colspan="5"><?php echo($guestbookEntry->getEntryComment()); ?></td>
               </tr>
            </tbody>
        </table>
        <div class="margin_top_10">
          <!-- only visible when the status of the entry allows the entry to be posted -->
          <?php 
          	if ($status == 1) {
          		print ('<input type="submit" name="post" value="Post" onclick="setOperation(this);" />');
          	}
          ?>
          <input type="submit" name="delete" value="Delete" onclick="setOperation(this);" />
        </div>
      <!-- //JL -->
      </form>
    </div>
  
  <div class="clear pad_bot_20"></div>
  <div class="w940">
    <div class="footer pad_top_10">
      <div class="copyright">&copy; University of Liverpool Hotel</div>
      <div class="footer_contact">UoL Hotel, Street Address, City<br />
        t. +44 (0) 151 xxx xxxx | e. <a href="mailto:enquiries@uolhotel.com">enquiries@uolhotel.com</a></div>
    </div>
  </div>
</div>
</body>
</html>