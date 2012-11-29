// JavaScript Document

/**
 * Controller function to validate a form
 */
function validateFormOnSubmit(whichForm) {
	var errorCounter = 0;
	/*if (whichForm.id == "room_reservation") {
		errorCounter += validateName(whichForm.customer_name);
		errorCounter += validateEmail(whichForm.customer_mail);
		errorCounter += validateDate(whichForm.arrive_date);
		errorCounter += validateDate(whichForm.depart_date);
		if (errorCounter === 0) errorCounter += validateDateDiff(whichForm.arrive_date, whichForm.depart_date);
	}
	if (whichForm.id == "confroom_reservation") {
		errorCounter += validateName(whichForm.customer_name);
		errorCounter += validateEmail(whichForm.customer_mail);
		errorCounter += validateDate(whichForm.conf_date);
		errorCounter += validateTime(whichForm.conf_start);
		errorCounter += validateTime(whichForm.conf_end);
		if (errorCounter === 0) errorCounter += validateTimeDiff(whichForm.conf_start, whichForm.conf_end);
	}*/
	if (whichForm.id == "reservation") {
		errorCounter += validateName(whichForm.customer_name);
		errorCounter += validateEmail(whichForm.customer_mail);
	}
	if (whichForm.id == "availability_check" || whichForm.id == "booking_form" ) {
		errorCounter += validateDate(whichForm.arrive_date);
		errorCounter += validateDate(whichForm.depart_date);
		if (errorCounter === 0) errorCounter += validateDateDiff(whichForm.arrive_date, whichForm.depart_date);
	}

	if (whichForm.id == 'guestbook_form') {
		errorCounter += validateGuestBookForm(whichForm);
	}
	
	if (whichForm.id == 'userDetails_form') {
		errorCounter += validateUserDetailsForm(whichForm);
	}
	
	if (whichForm.id == 'reservation_details_form') {
		errorCounter += validateReservationDetailsForm(whichForm);
	}
	
	if (whichForm.id == 'personal_details_form') {
		errorCounter += validatePersonalDetailsForm(whichForm);
	}
	
	if (whichForm.id == 'contactusform') {
		errorCounter += validateContactusForm(whichForm);
	}
	
	if (errorCounter != 0) {
		return false;
	} else {
		return true;
	}
}

/**
 * Validate the guestbook form
 */
function validateGuestBookForm(form) {
	var errorCounter = 0;
	errorCounter += validateName(form.name);
	errorCounter += validateEmail(form.email);
	errorCounter += validateDefault(form.title);
	errorCounter += validateDefault(form.comment);
	
	return errorCounter;
}

function validateContactusForm(form) {
	var errorCounter = 0;
	
	errorCounter += validateName(form.name);
	errorCounter += validateEmail(form.email);
	errorCounter += validateDefault(form.comment);

	return errorCounter;
}

/**
 *
 */
function validateUserDetailsForm(form) {
	
	var errorCounter = 0;
	
	errorCounter += validateUsername(form.username);
	errorCounter += validateName(form.firstname);
	errorCounter += validateName(form.lastname);
	errorCounter += validateEmail(form.email);
	errorCounter += validatePassword(form.password);
	
	if (errorCounter === 0) {
		errorCounter += validateEqualPasswords(form.password, form.retype_password);
	}
	
	return errorCounter;
}

/**
 * Validate the resevation details form 
 */
function validateReservationDetailsForm(form) {
	var errorCounter = 0;
	
	errorCounter += validateEmail(form.email);
	errorCounter += validateDate(form.arrival_date);
	errorCounter += validateDate(form.departure_date);
	
	if (errorCounter === 0) {
		errorCounter += validateDateDiff(form.arrival_date, form.departure_date);
	}
	
	return errorCounter;
}

/**
 * Validate personal details form
 */
function validatePersonalDetailsForm(form) {
	var errorCounter = 0;
	
	errorCounter += validateName(form.customer_name);
	errorCounter += validateEmail(form.customer_mail);
	
	return errorCounter;
}

function validateName(box) {
	if (validateIsEmpty(box)) {
		errorOn(box, "Required field!");
		return 1;
	} else {
		errorOff(box);
		return 0;
	}
}

function validateEmail(box) {
	var validator = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; // regular expresion for email validation
	if (validateIsEmpty(box)) {
		errorOn(box, "Required field!");
		return 1;
	}
	
	if (!validator.test(box.value)) {
		errorOn(box, "Invalid Email address!");
		return 1;
	}
	
	errorOff(box);
	return 0;
	
}

function validateUsername(box) {
	
	if (validateIsEmpty(box)) {
		errorOn(box, "Required field!");
		return 1;
	}
	
	var value = box.value;
	
	if (value.length < 6) {
		errorOn(box, "The username must be at least 6 characters");
		return 1;
	}
	
	var validator = /^[a-zA-Z]*$/;
	if (!validator.test(value)) {
		errorOn(box, "The username can only consist of characters");
		return 1;
	}
	
	errorOff(box);
	
	return 0;
}

function validatePassword(box) {
	
	if (validateIsEmpty(box)) {
		errorOn(box, "Required field!");
		return 1;
	}
	
	var value = box.value;
	
	if (value.length < 6) {
		errorOn(box, "The password must be at least 6 characters");
		return 1;
	}
	
	errorOff(box);
	
	return 0;
}

function validateEqualPasswords(passwordElement, confirmPasswordElement) {
	var password = passwordElement.value;
	var confirmPassword = confirmPasswordElement.value;
	
	if (password != confirmPassword) {
		errorOn(passwordElement, 'The passwords do not match');
		errorOn(confirmPasswordElement,'');
		
		// reset passwords
		confirmPasswordElement.value = '';
		passwordElement.value = '';
		
		return 1;
	}
	
	errorOff(passwordElement);
	
	return 0;
}

function validateDate(box) {
	if (validateIsEmpty(box) || box.value == "dd/mm/yyyy") {
		errorOn(box, "Required field!");
		return 1;
	} else {
		box.value = box.value.replace(/-/g, "/").replace(/\./g, "/").replace(/\\/g, "/");
		var validator = /^\d{2}\/\d{2}\/\d{4}$/; //Basic check for required date format
		if (!validator.test(box.value)) {
			errorOn(box, "Invalid Date format! Please use dd/mm/yyyy");
			return 1;
		} else {
			// we split input based on delimiter to day, month and year
			var box_day = box.value.split("/")[0];
			var box_month = box.value.split("/")[1];
			var box_year = box.value.split("/")[2];
			// we create new Date object based on results
			var dateChecker = new Date(box_year, box_month - 1, box_day);
			// we check whether created Date object coresponds to user entry
			if ((dateChecker.getMonth() + 1 != box_month) || (dateChecker.getDate() != box_day) || (dateChecker.getFullYear() != box_year)) {
				errorOn(box, "Invalid Date detected! Please correct.");
				return 1;
			} else {
				var todayDate = new Date();
				var todayPlus3Months = new Date(); // used for limiting 3 months in advance
				todayPlus3Months.setMonth(todayDate.getMonth()+3); // limit to 3 months in future
				if (todayDate >= dateChecker) {
					errorOn(box, "Reservations are unavailabe on or before current date!");
					return 1;
				} else if (dateChecker>todayPlus3Months){
					errorOn(box, "Reservations are limited to 3 months in advance!");
					return 1;
				} else {
					errorOff(box);
					return 0;
				}
			}
		}
	}
}

function validateDateDiff(dateA, dateB) {
	var compDateA = dateCreate(dateA);
	var compDateB = dateCreate(dateB);
	var resourceType = document.getElementById('room_type');
	
	if (resourceType.selectedIndex == 0) {
	
	if (compDateA >= compDateB) {
		var errLabel = document.getElementById('depart_date_error');
		errLabel.textContent = "Please allow for at least 24hrs between Arrival and Departure";
		errLabel.style.visibility = 'visible';
		return 1;
	} else {
		return 0;
		}

	} else {
		
		if (compDateA > compDateB) {
		var errLabel = document.getElementById('depart_date_error');
		errLabel.textContent = "Please allow for at least 24hrs between Arrival and Departure";
		errLabel.style.visibility = 'visible';
		return 1;
	} else {
		return 0;
		}
		
		
	}

}

function validateTime(box) {
	if (validateIsEmpty(box)) {
		errorOn(box, "Required field!");
		return 1;
	} else {
		var validator = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
		if (!validator.test(box.value)) {
			errorOn(box, "Invalid Time format! Please use hh:mm");
			return 1;
		} else {
			errorOff(box);
			return 0;
		}
	}
}

function validateTimeDiff(timeA, timeB) {
	if (Date.parse('01/01/2012 ' + timeB.value) < Date.parse('01/01/2012 ' + timeA.value) + 3600000) { // minimum 1 hrs difference
		var errLabel = document.getElementById('conf_end_error');
		errLabel.textContent = "Minimal reservation length is 1 hour!";
		errLabel.style.visibility = 'visible';
		return 1;
	} else {
		return 0;
	}
}

function validateAge(box) {
	var age = box.value;
	
	if (!age) {
		errorOn(box, "Required Field!");
		return 1;
	}
	
	if (isNaN(parseInt(age))) {
		errorOn(box, "The age must be an integer 15 or above");
		return 1;
	}
	
	if (age < 15) {
		errorOn(box, "You are too young. You must be 15 years or older");
		return 1;
	}
	
	return 0;
}

function dateCreate(box) {
	// we split input based on delimiter to day, month and year
	var box_day = box.value.split("/")[0];
	var box_month = box.value.split("/")[1];
	var box_year = box.value.split("/")[2];
	// we create new Date object based on results
	var resultDate = new Date(box_year, box_month - 1, box_day);
	return resultDate;
}

function validateIsEmpty(box) {
	if (box.value.length == 0) {
		return true;
	} else return false;
}

function validateDefault(box) {
	if (validateIsEmpty(box)) {
		return 1;
	}
	
	return 0;
}

function errorOn(box, msg) {
	var constructLabel = box.id + "_error";
	var errLabel = document.getElementById(constructLabel);
	errLabel.textContent = msg;
	errLabel.style.visibility = 'visible';
	
	// box already have error class name
	if (box.className.indexOf('error') == -1) {
		box.className = box.className + ' error';
	}
}

function errorOff(box) {
	var constructLabel = box.id + "_error";
	var errLabel = document.getElementById(constructLabel);
	errLabel.textContent = "";
	errLabel.style.visibility = 'hidden';
	//box.style.background = 'white';
	box.className = box.className.replace(' error', '');
}

function delIntContent(box) {
	if (box.value == "dd/mm/yyyy") {
		box.value = "";
	}
}

function intContent(box) {
	if (box.value == "") {
		box.value = "dd/mm/yyyy";
	}
}

function sizeOptChange(box) {
	var boxChange = document.getElementById('room_size');
	boxChange.options.length = 0;
	var objectsA = {
		1: 'Single Bed',
		2: 'Double Bed'
	};
	var objectsB = {
		3: 'Conference Grand',
		4: 'Conference Medium'
	};
	if (box.selectedIndex == 1) {
		for (index in objectsB) {
			boxChange.options[boxChange.options.length] = new Option(objectsB[index], index);
		}
	} else {
		for (index in objectsA) {
			boxChange.options[boxChange.options.length] = new Option(objectsA[index], index);
		}
	}
	
	var errLabel = document.getElementById('depart_date_error');
		errLabel.textContent = "";
		errLabel.style.visibility = 'hidden';
}
