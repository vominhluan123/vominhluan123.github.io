<?php

// Change this with your blog name and email address
$the_blogname = 'Your blog name';
$the_myemail  = 'email@company.com';

if ( isset( $_POST['email'] ) ) {
	error_reporting( 0 );
	$errorC = false;

	$date        = $_POST['date'];
	$pers        = $_POST['pers'];
	$the_phone   = $_POST['phone'];
	$time        = $_POST['time'];
	$the_name    = $_POST['name'];
	$the_email   = $_POST['email'];
	$the_message = $_POST['message'];

	if ( ! checkmymail( $the_email ) ) {
		$errorC         = true;
		$the_emailclass = "error";
		echo 'Your email is not valid';
	} else {
		$the_emailclass = "valid";
	}

	if ( $the_message == "" ) {
		$errorC           = true;
		$the_messageclass = "error";
	} else {
		$the_messageclass = "valid";
	}

	if ( $errorC == false ) {
		$to      = $the_myemail;
		$subject = "New Message from " . $the_blogname;
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header .= 'From:' . $the_email . " \r\n";

		$message1 = nl2br( $the_message );

		if ( ! empty( $the_name ) ) {
			$the_name = "Name: $the_name <br/>";
		}
		if ( ! empty( $date ) ) {
			$date = "Reservation date: $date <br/>";
		}
		if ( ! empty( $time ) ) {
			$time = "Reservation time: $time <br/>";
		}
		if ( ! empty( $pers ) ) {
			$pers = "Nr. of Pers: $pers <br/>";
		}
		if ( ! empty( $the_phone ) ) {
			$the_phone = "Phone: $the_phone <br/>";
		}

		$message = "
			You have a new message! <br/>
			$the_name
			$date
			$time
			$pers
			$the_phone
			$the_website
			Message: $message1 <br />";


		if ( @mail( $to, $subject, $message, $header ) ) {
			$send = true;
		} else {
			$send = false;
		}

		if ( isset( $send ) ) {

			if ( $send ) {
				echo true;
			} else {
				echo false;
			}

		}
	}

}


function checkmymail( $mailadresse ) {
	$email_flag = preg_match( "!^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$!", $mailadresse );

	return $email_flag;
}
?>