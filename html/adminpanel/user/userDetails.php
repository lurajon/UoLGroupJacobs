<?php
	echo('<?xml version="1.0" encoding="UTF-8"?>');
	
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'code'. DIRECTORY_SEPARATOR.'usermanagement'. DIRECTORY_SEPARATOR.'UserManagementController.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'code'. DIRECTORY_SEPARATOR.'usermanagement'. DIRECTORY_SEPARATOR.'UserManagementModel.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'code'. DIRECTORY_SEPARATOR.'usermanagement'. DIRECTORY_SEPARATOR. 'User.php';
	
	
	$userManagementModel = new UserManagementModel();
	$userManagementController = new UserManagementController($userManagementModel);
	$userManagementView = new UserManagementView($userManagementController, $userManagementModel);
	$userManagementController->setUserManagementView($userManagementView);
	
	$action = 'add';
    $actionName = 'Add';
	$validatePassword = 'true';
	
	$username = '';
	$firstname = '';
	$lastname = '';
	$email = '';
	
	if (isset($_GET)) {
        extract($_GET);
        if ($action == 'edit' && isset($userId)) {
            $currentUser = $userManagementView->getUser($userId);
            $actionName = 'Edit';
			$validatePassword = 'false';
            
            $username = $currentUser->getUsername();
			$firstname = $currentUser->getFirstName();
			$lastname = $currentUser->getLastName();
			$email = $currentUser->getEmail();
        } 
		
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to UoL Hotel</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Yanone+Kaffeesatz:200,400' rel='stylesheet' type='text/css' />
<link href="../../css/admin-styles.css" rel="stylesheet" type="text/css" />
<script src="../../js/form_validation.js"></script>
<script src="../../js/ajax_submit.js"></script>
<script type="text/javascript">
	
	function validateForm(form) {
		
		var validatePassword = document.getElementById('validatePassword');
		var action = document.getElementById('action');
		
		var passwordField = document.getElementById('password');
		
		if (action.value == 'save_add') {
			validatePassword.value = 'true';
		} else if (action.value == 'save_edit' && passwordField.value.length > 0) {
			validatePassword.value = 'true';
		}
		
		var clientValidationSuccess = validateFormOnSubmit(form);
		
		if (clientValidationSuccess == false) {
			return false;
		}
		
		var output = document.getElementById('output');
		
		if (action.value == 'save_add') {
			action.value = 'validate_add';
		} else {
			action.value = 'validate_edit';
		}
		
		var response = Ajax.xmlHttpPost('../../code/usermanagement/UserManagementController.php', form, false);
	
		var serverValidationSuccess = false;
		
		if (response == null || response.length == 0) {
			action.value = action.value.replace('validate', 'save');
			return true;
			
		}
		
		try {
			var messageObj = JSON.parse(response);
			
			if (messageObj.message) {
				output.innerHTML = messageObj.message.content;
				output.className = 'message error';
			}
		} catch (e) {
			output.innerHTML = 'A server side error has occured: ' + e;
				output.className = 'message error';
		}
		
		return false;
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
          <li><a href="users.html">User Management</a></li>
          <li><a href="../reservations/reservations.html">Reservations</a></li>
          <li><a href="../guestbook/guestbook.html">Guestbook Management</a></li>
          <li><a href="../../index.html">Back to Hotel Site</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="clear pad_bot_10"></div>
   <!-- Content -->
  <div class="w940">
    <div>
        
    </div>
    
    <div id="output">
      	
      </div>
      
    <div class="header_holder margin_top_10 admin_input_form">
      <!-- JL: enter your content header within <h1> element -->
        <h1><?php echo($actionName) ?> user</h1>
       <!-- // JL -->
      </div>
      
       <!-- JL: please use space below to add your page contents -->
      <form id="userDetails_form" action="../../code/usermanagement/UserManagementController.php" method="post" onsubmit="return validateForm(this);">
        <div class="inner">
        	<input type="hidden" value="save_<?php echo($action) ?>" name="action" id="action" />
        	
        	<?php
        		if ($action == 'edit') {
        			echo('<input type="hidden" id="userId" value="'.$userId.'" name="userId" />');
					echo('<input id="username" type="hidden" name="username" value="'. $username .'" />');
        		}
        	?>
        	<input class="hidden" type="text" id="validatePassword" name="validatePassword" value="<?php echo($validatePassword) ?>" />
        	
        <div>
          <label for="username" class="required-field">Username</label>
          <?php
        		if ($action == 'add') {
        			echo('<input id="username" type="text" name="username" value="" onfocus="errorOff(this)" /><span id="username_error" class="required"></span>');
				} else {
					echo('<span class="info-field">'.$username.'</span>');
				} 
			?>
          <div class="clear"></div>
        </div>
        <div>
          <label for="password" class="required-field">Password</label><input id="password" type="password" name="password" value="" onfocus="errorOff(this)" /><span id="password_error" class="required"></span>
          <div class="clear"></div>
        </div>
        <div>
          <label for="confirm" class="required-field">Confirm Password</label><input id="confirm" type="password" name="confirm" value="" onfocus="errorOff(this)" /><span id="confirm_error" class="required"></span>
          <div class="clear"></div>
        </div>
        <div>
          <label for="firstname" class="required-field">First Name:</label><input id="firstname" type="text" name="firstname" value="<?php echo($firstname) ?>" onfocus="errorOff(this)" /><span id="firstname_error" class="required"></span>
          <div class="clear"></div>
          </div>
        <div>
          <label for="lastname" class="required-field">Last Name:</label><input id="lastname" type="text" name="lastname" value="<?php echo($lastname) ?>" onfocus="errorOff(this)" /><span id="lastname_error" class="required"></span>
          <div class="clear"></div>
        </div>
        <div>
          <label for="email" class="required-field">E-mail:</label><input id="email" type="text" name="email" value="<?php echo($email) ?>" onfocus="errorOff(this)" /><span id="email_error" class="required"></span>
          <div class="clear"></div>
        </div>
        
        <div>
          <input type="submit" value="Save" />
        </div>
        </div>
      </form>
      <!-- // JL -->
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