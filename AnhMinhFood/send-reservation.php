<?php

// Change this with your blog name and email address
$the_blogname = 'Your blog name';
$the_myemail  = 'email@company.com';

if ( isset( $_POST['email'] ) ) {
	error_reporting( 0 );
	$errorC = false;

	$date        = $_POST['date'];
	$persone     = $_POST['persone'];
	$phone       = $_POST['phone'];
	$time        = $_POST['time'];
	$the_name    = $_POST['name'];
	$the_email   = $_POST['email'];
	$the_message = $_POST['notice'];

	# want to add aditional fields? just add them to the form in template_contact.php,
	# you dont have to edit this file

	//added fields that are not set explicit like the once above are combined and added before the actual message
	$already_used = array(
		'email',
		'name',
		'phone',
		'persone',
		'notice',
		'myblogname',
		'tempcode',
		'temp_url',
		'ajax'
	);
	$attach       = '';

	foreach ( $_POST as $key => $field ) {
		if ( ! in_array( $key, $already_used ) ) {
			$attach .= $key . ": " . $field . "<br /> \n";
		}
	}
	$attach .= "<br /> \n";

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
			$the_name = "Name:  	$the_name <br/>";
		}
		if ( ! empty( $phone ) ) {
			$phone = "Phone:   $phone <br/>";
		}
		if ( ! empty( $persone ) ) {
			$persone = "Number of pers:   $persone <br/>";
		}

		$message = "
			You have a new message! <br/>
			$the_name
			$phone
			$persone
			$attach <br />
			Message: $message1 <br />";


		if ( @mail( $to, $subject, $message, $header ) ) {
			$send = true;
		} else {
			$send = false;
		}

		if ( isset( $send ) ) {

			if ( $send ) {
				echo '<h3>Your reservation has been sent!</h3><div class="confirm">
					<p class="textconfirm">Thank you for contacting us.<br/>We will get back to you as soon as possible.</p>
				  </div>';
			} else {
				echo '<h3>Oops!</h3><div class="confirm">
					<p class="texterror">Due to an unknown error, your form was not submitted, please resubmit it or try later.</p>
				  </div>';
			}

		}
	}

}


function checkmymail( $mailadresse ) {
	$email_flag = preg_match( "!^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$!", $mailadresse );

	return $email_flag;
}
?>