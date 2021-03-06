<?php

if(!isset($_POST["reservation_check"]) || $_POST["reservation_check"]<>"Make Reservation"){
	
header("Location: booking.html");
exit;	
} else {

include_once 'inc/reservation_model.inc';
include_once 'inc/reservation_controller.inc';
include_once 'inc/reservation_view.inc';

$pageModel = new Model();
$pageView = new View();
$reservationController = new ReservationController($pageModel, $pageView);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- ZM: please do not forget to change page title -->
<title>UoL Hotel : Reservation Form Processing</title>
<!-- //ZM -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Yanone+Kaffeesatz:200,400' rel='stylesheet' type='text/css' />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/image_slider.js"></script>
</head>

<body onload="image_slider();">
<div class="holder">
  <div class="w140 pad_left_800">
    <div class="member_entry"><a href="./adminpanel">Staff Only</a></div>
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
          <li><a href="index.html">Home Page</a></li>
          <li><a href="guestservice.html">Guest Services</a></li>
          <li><a href="activities.html">Activities</a></li>
          <li><a href="guestrooms.html">Guest Rooms</a></li>
          <li><a href="confrooms.html">Conference Rooms</a></li>
          <li><a href="booking.html">Booking</a></li>
          <li><a href="guestbook.php">Guestbook</a></li>
          <li><a href="contactus.html">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="clear pad_bot_10"></div>
  <div class="w300 bar_right">
    <div class="w300 zero_margL">
      <div class="confroom_link" onclick="location.href='confrooms.html'">
        <div class="img_overlay overlay_color1">Your events in our Conference Rooms</div>
      </div>
    </div>
    <div class="clear pad_bot_20"></div>
    <div class="w300 zero_margL">
      <div class="socnet_link">
        <ul>
          <li class="facebook"><a href="">Visit Hotel's Facebook Page</a></li>
          <li class="twitter"><a href="">Follow us on Twitter</a></li>
        </ul>
      </div>
    </div>
    <div class="clear"></div>
    <div class="w300 zero_margL">
      <div class="uol_link">
        <div class="menu_holder">
          <h2>University of Liverpool</h2>
        </div>
        <ul>
          <li><a href="http://www.liv.ac.uk/about/">About UoL</a></li>
          <li><a href="http://www.liv.ac.uk/study/">Study</a></li>
          <li><a href="http://www.liv.ac.uk/departments/">Departments and Services</a></li>
          <li><a href="http://www.liv.ac.uk/study/openday/">Open Days</a></li>
          <li><a href="http://www.liv.ac.uk/liverpool-life/">Liverpool Life</a></li>
        </ul>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="w620 bar_left">
    <div class="w620 zero_margL">
      <div id="big_slider_holder" class="image_slider">
        <div id="big_slider_text" class="img_overlay large_color1">&nbsp;</div>
      </div>
    </div>
    <div class="clear pad_bot_20"></div>
    <div class="w620 zero_margL">
      <div class="header_holder"> 
        <!-- ZM: enter your content header within <h1> element -->
        <h1>Thank you for using OnLine Reservation System</h1>
        <!-- // ZM --> 
      </div>
      <!-- ZM: please use space below to add your page contents -->
      <?php
	$reservationController -> addReservation($_POST);
      ?>
      <!-- //ZM --> 
    </div>
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
<?php } ?>