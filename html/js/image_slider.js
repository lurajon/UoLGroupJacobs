// JavaScript Document
sliderContent = new Array();

// Slider contents: array[big image location, small image location, overlay text, link]
sliderContent[0] = ["images/main_slider/Hotel_Crillon_centre_nice_-_hotel_nice.jpg","images/main_slider/Luxury-Contemporary-Hospitality-Interior-Design-of-Treasure-Island-Las-Vegas-Double-Bedroom.jpg","Spacious Single Bed and Double Bed Guest Rooms","guestrooms.html"]
sliderContent[1] = ["images/main_slider/Conference_room.jpg","images/main_slider/seasons-conference.jpg","Your events in our Conference Rooms","confrooms.html"]
sliderContent[2] = ["images/main_slider/spa_main.png","images/main_slider/spa.png","The best spa in eastern midlands","spa.html"]
sliderContent[3] = ["images/main_slider/instruction_4.jpg","images/main_slider/golf.png","Visit our golf course","golf.html"]

var startNum = Math.floor(Math.random()*4); // randomizing the first slide number, last number in function needs to be array length-1

function image_slider( sliderSize ) {
	
if ( startNum < sliderContent.length ){
startNum = startNum;
}
else {
 startNum = 0;
}


if ( sliderSize == "big" ) {
document.getElementById('big_slider_holder').style.backgroundImage = 'url("'+sliderContent[startNum][0]+'")'
} else {
document.getElementById('big_slider_holder').style.backgroundImage = 'url("'+sliderContent[startNum][1]+'")'
}

document.getElementById('big_slider_text').textContent = sliderContent[startNum][2]
var sliderLink = sliderContent[startNum][3];
document.getElementById('big_slider_holder').onclick = function() { location.href = sliderLink; }

startNum = startNum+1;

var delay = setTimeout("image_slider('"+sliderSize+"')",3500)

}