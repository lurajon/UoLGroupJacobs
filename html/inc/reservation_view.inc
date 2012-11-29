<?php

class View {

	public function __construct() {

	}

	public function showRooms($sentData) {

		foreach ($sentData as $room) {

			echo $room -> getID() . "	";
			echo $room -> getName() . "		";
			echo $room -> getSizeID() . "	";
			echo $room -> getSize() . "	";
			echo $room -> getTypeID() . "	";
			echo $room -> getType() . "	";
			echo $room -> getPrice() . "	<br />";
		}

	}

	public function showReservations($sentData) {
		foreach ($sentData as $reservation) {

			echo $reservation -> getID() . "	";
			echo $reservation -> getRoomID() . "	";
			echo $reservation -> getArriveDate() . "	";
			echo $reservation -> getDepartDate() . "	";
			echo $reservation -> getNotes() . "	<br />";

		}

	}

	public function showNoRoomsAvailable($sentData) {
		if ($sentData == 'original') {
			echo "<p style='color: red; font-size: 0.9em; font-weight: bold;'>We are very sorry, we have no such accomodations available within the given date range!</p>";
		}
	}

	public function showReservationForm($sentArriveDate, $sentDepartDate, $sentData, $sentVariant) {

		$output = "";

		if ($sentVariant == 'alternative') {

			$output .= "<p class='pad_top_10'>However we recommend you consider following alternative accomodation and proceed with reservation:</p>";

		}

		$output .= '<div class="pad_all_10 marg_left_10">
        <table width="100%" border="0" class="confirmation_table">
          <tr>
            <td width="30%">Date of Arrival:</td>
            <td><strong>' . $sentArriveDate . '</strong></td>
          </tr>
          <tr>
            <td>Date of Departure:</td>
            <td><strong>' . $sentDepartDate . '</strong></td>
          </tr>
          <tr>
            <td>Accommodation:</td>
            <td><strong>' . $sentData[0] -> getSize() . '</strong></td>
          </tr>
          <tr>
            <td>Rate per Day:</td>
            <td><strong>$' . $sentData[0] -> getPrice() . '</strong></td>
          </tr>
          </table>
      </div>';

		$output .= '<form id="reservation" action="reservation_confirmation.php" method="post" class="reservation_form" onsubmit="return validateFormOnSubmit(this)">
        <fieldset>
          <legend class="hidden">Please enter required information</legend>
          <span id="customer_name_error" class="required"></span>
          <label for="customer_name">* Name:</label>
          <input name="customer_name" type="text" id="customer_name" value="" class="date_range"/>
          <span id="customer_mail_error" class="required"></span>
          <label for="customer_mail">* Email:</label>
          <input name="customer_mail" type="text" id="customer_mail" value="" class="date_range"/>
          <label for="customer_company">Company:</label>
          <input name="customer_company" type="text" id="customer_company" value="" class="date_range"/>
          <label for="customer_message">Message:</label>
          <textarea name="customer_message" cols="37" rows="6" id="customer_message"></textarea>
          <label for="reservation_check"></label>
          <input type="hidden" name="room_id" value="' . $sentData[0] -> getID() . '"/>
          <input type="hidden" name="arrive_date" value="' . $sentArriveDate . '"/>
          <input type="hidden" name="depart_date" value="' . $sentDepartDate . '"/>
          <input id="reservation_check" type="submit" name="reservation_check" value="Make Reservation" class="date_range marg_top_10" />
        </fieldset>
      </form>';

		echo $output;

	}

	public function showReservationOK($sentData) {
		$output = "";

		$output .= '<p>Dear ' . $sentData[0] -> getGuestName() . ',<br />
         Thank you for choosing to stay with us at the UOL Hotel. We are pleased to confirm your reservation as follows:</p>
      <div class="pad_all_10 marg_top_10">
        <div class="listing float_left"> Confirmation Number: <br />
          Guest Name: <br />
          Date of Arrival: <br />
          Date of Departure: <br />
          Accommodation: <br />
          Rate per Night: <br />
          Total Amount: </div>
        <div class="listing float_right">' . $sentData[0] -> getID() . '<br />
          ' . $sentData[0] -> getGuestName() . ' <br />
          ' . $sentData[0] -> getArriveDate() . ' <br />
          ' . $sentData[0] -> getDepartDate() . ' <br />
          ' . $sentData[0] -> getRoomSize() . ' <br />
          ' . $sentData[0] -> getPrice() . ' <br />
          $' . ($sentData[0] -> getLength() * $sentData[0] -> getPrice()) . ' </div></div>
      <p>&nbsp;</p>
      <p>Should you require an early check-in, please make your request as soon as possible. Rates are quoted in U.S. funds and subject to applicable state and local taxes. If you find it necessary to cancel this reservation, the UoL Hotel requires notification by 4:00 P.M. the day before your arrival to avoid standard charges.</p>
      <p>&nbsp;</p>
      <p>Whatever we can do to make your visit extra special, call us at 800.888.8888. We\'ll assist you with advance reservations for airport transfers, dining, golf tee-times and spa treatments.</p>
      <p>&nbsp;</p>
      <p>We look forward to the pleasure of having you as our guest at the UoL Hotel. (Returnity)</p>';

		echo $output;

	}

	public function showReservationFailed() {
		echo "<p style='color: red; font-size: 0.9em; font-weight: bold;'>We are very sorry, <br />Our system encountered unexpected error, please try again later!</p>";
	}

}
?>