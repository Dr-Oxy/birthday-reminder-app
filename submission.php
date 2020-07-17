<?php
​
//Contact Form
if ( isset( $_POST[ 'message' ] ) ) {
	
	// EDIT THESE LINES BELOW AS REQUIRED
	$email_from = "chiomaotu22@gmail.com";
	$email_to = "info@zzdigital.com";
​
	extract( $_POST );
	//reCaptcha thangz
	$captcha = $token;
	$secretKey = "6Le0YvAUAAAAALHoOnfyiJgwov1jnPqcGftFIXCw";
​
	// post request to server
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array('secret' => $secretKey, 'response' => $captcha);
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
​
	$context  = stream_context_create($options);
	$response = file_get_contents($url, false, $context);
	$responseKeys = json_decode($response,true);
	header('Content-type: application/json');
	if($responseKeys["success"]) {
		//SEND EMAIL
		$email_message = "Details below.\n\n";
		$email_message .= "Name: " . $name . "\n";
		$email_message .= "Email: " . $email . "\n";
		$email_message .= "Telephone: " . $phone . "\n";
		$email_message .= "Message: " . $message . "\n";
		$email_message = wordwrap($email_message,70);
​
		$email_subject = "Message from zzdigital.com";
​
		$headers = "From: ". $name . " <". $email_from .">\r\n" . 
		"CC: ".$email_CC . "\r\n".
		'Reply-To: '.$email."\r\n" .
		'X-Mailer: PHP/' . phpversion();
​
		if (mail($email_to,$email_subject,$email_message,$headers)){
		echo "success";
		}else{
		echo "failed";	
		}
	} else {
		echo "failed"
	}
​
}
​
?>