// JavaScript Document
function validateFormOnSubmit(whichForm) {
	var errorCounter = 0;
	if (whichForm.id == "room_reservation") {
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
	}
	if (errorCounter != 0) {
		return false;
	} else return true;
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
	} else {
		if (!validator.test(box.value)) {
			errorOn(box, "Invalid Email address!");
			return 1;
		} else {
			errorOff(box);
			return 0;
		}
	}
}

function validateDate(box) {
	if (validateIsEmpty(box)) {
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
				if (todayDate >= dateChecker) {
					errorOn(box, "Reservations are unavailabe on or before current date!");
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
	if (compDateA >= compDateB) {
		var errLabel = document.getElementById('depart_date_error');
		errLabel.textContent = "Please allow for at least 24hrs between Arrival and Departure";
		errLabel.style.visibility = 'visible';
		return 1;
	} else {
		return 0;
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

function errorOn(box, msg) {
	var constructLabel = box.id + "_error";
	var errLabel = document.getElementById(constructLabel);
	errLabel.textContent = msg;
	errLabel.style.visibility = 'visible';
	box.style.background = 'yellow';
}

function errorOff(box) {
	var constructLabel = box.id + "_error";
	var errLabel = document.getElementById(constructLabel);
	errLabel.textContent = "";
	errLabel.style.visibility = 'hidden';
	box.style.background = 'white';
}