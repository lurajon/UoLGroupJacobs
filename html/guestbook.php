<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- ZM: please do not forget to change page title -->
<title>UoL Hotel - Guestbook</title>
<!-- //ZM -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Yanone+Kaffeesatz:200,400' rel='stylesheet' type='text/css' />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/image_slider.js"></script>
<script type="text/javascript" src="js/form_validation.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script src="js/ajax_submit.js" type="text/javascript"></script>
<script type="text/javascript">
	
	function validateForm(form) {
		var output = document.getElementById('message');
		
		if (!validateFormOnSubmit(form)) {
			return;
		}
		
		var response = Ajax.xmlHttpPost('code/guestbook/GuestbookController.php', form, false);
		
		if (response.length == 0) {
			return;
		}
		
		try {
			var msgObj = JSON.parse(response);
		
			if (msgObj.message.type == 'error') {
                var errorElement = document.createElement('div');
                errorElement.className = 'message error';
                errorElement.innerHTML = msgObj.message.content;
                output.innerHTML = '';
                output.appendChild(errorElement);    
        	} else if (msgObj.message.type == 'info') {
                var infoElement = document.createElement('div');
                infoElement.className = 'message success';
                infoElement.innerHTML = msgObj.message.content;
                output.innerHTML = '';
                output.appendChild(infoElement);
        	}

			hideAddGuestbookEntryForm();
		} catch(e) {
			output.innerHTML = e;
		}
	    
	}
	
	function showAddGuestbookEntryForm() {
		toggleGuestbookEntryForm();
	}
	
	function hideAddGuestbookEntryForm() {
		toggleGuestbookEntryForm();
	}
	
	function toggleGuestbookEntryForm() {
		var addGuestbookEntryForm = document.getElementById('addGuestbookEntry');
		
		if (addGuestbookEntryForm.style.display == 'none') {
			addGuestbookEntryForm.style.display = 'block';
		} else {
			addGuestbookEntryForm.style.display = 'none';
		}
	}
	
	function loadApprovedEntries() {
		var response = Ajax.xmlHttpGet('code/guestbook/GuestbookController.php?list=approved', false);
		
		try {
		var jsonObj = JSON.parse(response);
        
        	if (jsonObj.message != null) {
        		buildEmptyList('guestbookEntries', jsonObj);
        	} else if (jsonObj.guestbookEntries != null) {
        		buildGuestbookList('guestbookEntries', jsonObj);
        	}
        } catch(e) {
        	buildMessage('guestbookEntries',"Failed to retrieve list: " + e);
        }
        
	}
	
	function buildEmptyList(outputElement, msgObj) {
		
		buildMessage(outputElement, msgObj.message.content);
		
	}
	
	function buildMessage(outputElement, message) {
		var output = document.getElementById(outputElement);
		output.innerHTML = '';
		
		var ele = document.createElement('div');
		
		ele.innerHTML = message;
		output.appendChild(ele);
	}
	
	function buildGuestbookList(outputElement, guestbookListObj) {
		var output = document.getElementById(outputElement);
		output.innerHTML = '';
		
		for (var index in guestbookListObj.guestbookEntries) {
			var entry = guestbookListObj.guestbookEntries[index];
			createEntry(output, entry.guestbookEntry);
		}
	}
	
	function createEntry(output, guestbookEntry) {
		var outer = document.createElement('div');
		outer.className = 'entry';
		
		var header = document.createElement('div');
		header.className = 'entry-hdr';
		
		var body = document.createElement('div');
		body.className = 'entry-bdy';
		
		var profile = document.createElement('div');
		profile.className = 'profile';
		
		var text = document.createElement('div');
		text.className = 'comment'
		
		text.innerHTML = '<div>' + guestbookEntry.entryTitle + '</div><div>'+ guestbookEntry.entryComment +'</div>';
		header.innerHTML = guestbookEntry.entryAuthorName;
		
		var profileImage = document.createElement('img');
		profileImage.src = 'http://www.gravatar.com/avatar/' + guestbookEntry.entryAuthorEmailHash;
		
		var entryDate = document.createElement('div');
		entryDate.className = 'date';
		entryDate.innerHTML = guestbookEntry.entryDate;
		
		profile.appendChild(profileImage);
		profile.appendChild(entryDate);
		
		var clearer = document.createElement('div');
		clearer.className = 'clear';
		
		body.appendChild(profile);
		body.appendChild(text);
		body.appendChild(clearer);
		
		outer.appendChild(header);
		outer.appendChild(body);
		
		output.appendChild(outer);
	}
</script>
</head>

<body onload="image_slider();loadApprovedEntries();">
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
      <div class="booking_form_small">
        <div class="header_holder booking">
          <h3>OnLine Reservations</h3>
        </div>
        <form action="reservation.php" method="post" id="booking_form" onsubmit="validateFormOnSubmit(this)">
          <fieldset>
            <span id="arrive_date_error" class="required short"></span>
            <label>Arrival:</label>
            <input name="arrive_date" type="text" id="arrive_date" value="dd/mm/yyyy" class="date_range" onfocus="delIntContent(this)" onblur="intContent(this)" />
            <div class="ui-button icon-only" onclick="datePicker.showCalendar(this, 'arrive_date')" ><span class="icon ui-icon-calendar" ></span></div>
            <span id="depart_date_error" class="required short"></span>
            <label>Departure:</label>
            <input name="depart_date" type="text" id="depart_date" value="dd/mm/yyyy" class="date_range" onfocus="delIntContent(this)" onblur="intContent(this)" />
            <div class="ui-button icon-only" onclick="datePicker.showCalendar(this, 'depart_date')"><span class="icon ui-icon-calendar" ></span></div>
            <label>Room Type:</label>
            <select name="room_type" id="room_type" class="small_form_select" onchange="sizeOptChange(this)">
              <option value="1" selected="selected">Guest Room</option>
              <option value="2">Conference Room</option>
            </select>
            <label>Room Size:</label>
            <select name="room_size" id="room_size" class="small_form_select">
              <option value="1" selected="selected">Single Bed</option>
              <option value="2">Double Bed</option>
            </select>
            <label></label>
            <input id="booking_check" type="submit" name="booking_check" value="Check Availability" class="date_range" />
          </fieldset>
        </form>
      </div>
    </div>
    <div class="clear pad_bot_5"></div>
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
        <!--<div class="image_slider" style="background-image: url(images/guestbook.png);">
        <div class="img_overlay large_color1">Tell us about your visit</div> --> 
      </div>
    </div>
     <div class="clear pad_bot_20"></div>
    <div class="w620 zero_margL">
      <div class="header_holder"> 
        <!-- ZM: enter your content header within <h1> element -->
        <h1>Guestbook</h1>
        <!-- // ZM --> 
      </div>
      <!-- ZM: please use space below to add your page contents -->
      <div>
    	<input type="button" value="Add new entry" onclick="showAddGuestbookEntryForm()" />
    	 <div class="pad_bot_20"></div>
    	 <div id="message"></div>
    	 
      </div>
      <div id="addGuestbookEntry" style="display: none;">
		<div class="header_holder"> 
      	  <h1>Add guestbook entry</h1>
	    </div>
	    
    	<form id="guestbook_form" action="code/guestbook/GuestbookController.php" method="post" onsubmit="validateForm(this); return false">
	        <div class="inner">
    	    	<input type="hidden" name="action" value="add" id="action" />
		    </div>
		    <div>
            	<label for="name" class="required-field">Name:</label>
	            <input type="text" value="" name="name" id="name" onfocus="errorOff(this)" />
    	        <span id="name_error" class="required"></span>
        	    <div class="clear"></div>
         	 </div>
          	<div>
            	<label for="email" class="required-field">E-mail:</label>
	            <input type="text" value="" name="email" id="email" onfocus="errorOff(this)" />
    	        <span id="email_error" class="required"></span>
        	    <div class="clear"></div>
          	</div>
            <div>
   	        	<label for="title" class="required-field">Title:</label>
	            <input type="text" value="" name="title" id="title" onfocus="errorOff(this)" />
    	        <span id="title_error" class="required"></span>
        	    <div class="clear"></div>
            </div>
         
  	        <div>
    	        <label class="clear-width" class="required-field">
        	    	Your comment:
            	</label>
            	<div class="clear"></div>
          	</div>
          	<div> <span id="comment_error" class="required"></span> </div>
          	<div>
            	<textarea id="comment" name="comment"  cols="40" rows="10" class="w100p borderBox" onfocus="errorOff(this)"></textarea>
          	</div>
          	<div>
            	<input type="submit" value="Submit" />
            	<input type="reset" value="Clear" />
            	<input type="button" value="Cancel" onclick="hideAddGuestbookEntryForm();" />
          	</div>
	    </form>
	    <div class="pad_bot_20"></div>
	  </div>
      <div id="guestbookEntries">
            
      </div>
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