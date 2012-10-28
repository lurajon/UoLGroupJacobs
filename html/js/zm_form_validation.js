// JavaScript Document

function validateFormOnSubmit(whichForm) {
	var errorCounter = 0;
	
errorCounter +=validateName(whichForm.customer_name);
errorCounter +=validateEmail(whichForm.customer_mail);

if ( errorCounter != 0 ) {
	//alert ("Please fill in all form fields!");
	return false;
}
else return true;
}


function validateName(box) {
	if(validateIsEmpty(box)) {
	document.getElementById('customer_error').textContent = "Field bellow is mandatory!";
	document.getElementById('customer_error').style.visibility = 'visible';
	box.style.background = 'yellow';
	return 1;
} else {
	document.getElementById('customer_error').textContent = "!";
	document.getElementById('customer_error').style.visibility = 'hidden';
	box.style.background = 'white';
	return 0;
}
}

function validateEmail(box){
	var validator = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; // regular expresion for email validation
	
	if(validateIsEmpty(box)) {
		document.getElementById('email_error').textContent = "Field bellow is mandatory!";
		document.getElementById('email_error').style.visibility = 'visible';
		box.style.background = 'yellow';
		return 1;
		} else {
			
			if (!validator.test(box.value)) {
				document.getElementById('email_error').textContent = "Invalid Email address!";
				document.getElementById('email_error').style.visibility = 'visible';
				box.style.background = 'yellow';
				return 1;
				} else {
				document.getElementById('email_error').textContent = "";
				document.getElementById('email_error').style.visibility = 'hidden';
				box.style.background = 'white';
				return 0;
				}
	
		}

}

function validateIsEmpty(box) {
if( box.value.length == 0 ){
return true;
} else return false;	
}
/*reason += validateUsername(theForm.username)+'<br/>';
reason += validatePassword(theForm.pwd)+'<br/>';
reason += validateEmail(theForm.email)+'<br/>';
reason += validatePhone(theForm.phone)+'<br/>';
reason += validateEmpty(theForm.from);*/

//whichForm = document.getElementById('form_w4q3'); // choose input elements from this form only

// Find form's input elements
/*inputNodes = whichForm.getElementsByTagName('input');
for (var i = 0; i < inputNodes.length; i++) {
	if ( inputNodes[i].type == 'text' ) { // check only text type input elements
		errorMsg += validateEmpty(inputNodes[i]);
	}
}*/

/*if (errorMsg != "") {
document.getElementById('box1').style.visibility= 'visible';
document.getElementById('box1').innerHTML = errorMsg ;
return false;
}
else return true;
}

function validateEmpty(fld) {
var error = "";
if (fld.value.length == 0) {
fld.style.background = 'Yellow';
error = "The required field <strong>" + returnLabel(fld) +"</strong> has not been filled in.<br />"
} else {
fld.style.background = 'White';
}
return error;
}

function validateUsername(fld) {
var error = "";
var illegalChars = /\W/; // allow letters, numbers, and underscores
if (fld.value == "") {
fld.style.background = 'Yellow';
error = "You didn't enter a username.\n";
} else if ((fld.value.length < 5) || (fld.value.length > 15)) {
fld.style.background = 'Yellow';
error = "The username is the wrong length.\n";
} else if (illegalChars.test(fld.value)) {
fld.style.background = 'Yellow';
error = "The username contains illegal characters.\n";
} else {
fld.style.background = 'White';
}
return error;
}

function validatePassword(fld) {
var error = "";
var illegalChars = /[\W_]/; // allow only letters and numbers
if (fld.value == "") {
fld.style.background = 'Yellow';
error = "You didn't enter a password.\n";
} else if ((fld.value.length < 7) || (fld.value.length > 15)) {
error = "The password is the wrong length. \n";
fld.style.background = 'Yellow';
} else if (illegalChars.test(fld.value)) {
error = "The password contains illegal characters.\n";
fld.style.background = 'Yellow';
} else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
error = "The password must contain at least one numeral.\n";
fld.style.background = 'Yellow';
} else {
fld.style.background = 'White';
}
return error;
}

function trim(s)
{
return s.replace(/^\s+|\s+$/, '');
}

function validateEmail(fld) {
var error="";
var tfld = trim(fld.value); // value of field with whitespace trimmed off
var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
if (fld.value == "") {
fld.style.background = 'Yellow';
error = "You didn't enter an email address.\n";
} else if (!emailFilter.test(tfld)) { //test email for illegal characters
fld.style.background = 'Yellow';
error = "Please enter a valid email address.\n";
} else if (fld.value.match(illegalChars)) {
fld.style.background = 'Yellow';
error = "The email address contains illegal characters.\n";
} else {
fld.style.background = 'White';
}
return error;
}

function validatePhone(fld) {
var error = "";
var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');
if (fld.value == "") {
error = "You didn't enter a phone number.\n";
fld.style.background = 'Yellow';
} else if (isNaN(parseInt(stripped))) {
error = "The phone number contains illegal characters.\n";
fld.style.background = 'Yellow';
} else if (!(stripped.length == 10)) {
error = "The phone number is the wrong length. Make sure you included an area code.\n";
fld.style.background = 'Yellow';
}
return error;
}

function returnLabel(fld){
	var labels=document.getElementsByTagName("label"),l;
	for( l=0; l<labels.length; l++ ){
		if( labels[l].htmlFor == fld.id)
		return labels[l].textContent;
		}
}*/