<?php
	echo('<?xml version="1.0" encoding="UTF-8"?>');
	
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'code'. DIRECTORY_SEPARATOR.'usermanagement'. DIRECTORY_SEPARATOR.'UserManagementController.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'code'. DIRECTORY_SEPARATOR.'usermanagement'. DIRECTORY_SEPARATOR.'UserManagementModel.php';
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR.'code'. DIRECTORY_SEPARATOR.'usermanagement'. DIRECTORY_SEPARATOR. 'User.php';
	
	
	$userManagementModel = new UserManagementModel();
	$userManagementController = new UserManagementController($userManagementModel);
	$userManagementView = new UserManagementView($userManagementController, $userManagementModel);
	$userManagementController->setUserManagementView($userManagementView);
	
    $actionName = 'created';
	
	$username = '';
	$firstname = '';
	$lastname = '';
	$email = '';
	
	if (isset($_GET)) {
        extract($_GET);
        
        if ($actionComplete == 'edit') {
        	$actionName = 'edited';
        }
            
        $currentUser = $userManagementView->getUserByUsername($username);
        $firstname = $currentUser->getFirstName();
	    $lastname = $currentUser->getLastName();
		$email = $currentUser->getEmail();
        
    }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to UoL Hotel</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Yanone+Kaffeesatz:200,400' rel='stylesheet' type='text/css' />
<link href="../../css/admin-styles.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
  var seconds = 10;
  var timerElement;
  
  function startTimer() {
    timerElement = document.getElementById('timer');
   
   timeChange();
  }
  
  function timeChange() {
    seconds--;
    if (seconds == 0) {
      navigateToUsers();
    } else {
      timerElement.innerHTML = seconds;
      setTimeout('timeChange()', 1000);
    }
    
  }
  
  function navigateToUsers() {
    window.location.href = 'users.html';
  }
</script>
</head>

<body class="admin" onload="startTimer()">
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
    <div class="header_holder margin_top_10">
      <!-- JL: enter your content header within <h1> element -->
        <h1>User saved successfully</h1>
       <!-- // JL -->
      </div>
      <!-- JL: please use space below to add your page contents -->
        <div class="margin_top_10">You have <?php echo($actionName) ?> the user <?php echo($username) ?> with the following details</div>
        <table class="margin_top_10">
            <tbody>
              <tr>
                <td>First Name:</td>
                <td><?php echo($firstname) ?></td>
              </tr>
              <tr>
                <td>Last Name:</td>
                <td><?php echo($lastname) ?></td>
              </tr>
              <tr>
                <td>E-Mail</td>
                <td><?php echo($email) ?></td>
              </tr>
            </tbody>
        </table>
        
        <div class="margin_top_10">
          <a href="users.html">Back to users</a>
          <p>You will be redirected automatically in <span id="timer"></span> seconds</p>
        </div>
      <!-- //JL -->
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