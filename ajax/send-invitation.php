<?php
$success=0;
if(isset($_POST['submit'])){
	//Send Email
	require_once ('../../components/PHPMailer-v5.2.22/PHPMailerAutoload.php');
	//----------------------
	// Send Email to Client
	//----------------------
	$mail = new PHPMailer;
	//
	$mail->isSMTP();                  			// Set mailer to use SMTP
	$mail->Host 		= 'mail.pps.com.kh';  	// Specify main and backup server
	$mail->SMTPAuth 	= true;          				// Enable SMTP authentication
	$mail->Username 	= 'support@pps.com.kh';	// SMTP username
	$mail->Password 	= 'Mail4PPS2013$';			// SMTP password
	$mail->Port 		= 465;									// STMT port

	$mail->SMTPSecure = true;
	$mail->SMTPOptions = array(
			'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
			)
	);
	//
	$mail->setFrom('no-reply@pps.com.kh', $_POST['name']);
	
	$email_array = explode(";", $_POST['to']);
	foreach ($email_array AS $key=>$email){
		$mail->addAddress(trim($email));		// Add a recipient
	}

	//Add CC Email Notification
	//$mail->AddCC($_POST['email']);

	$mail->isHTML(true);
	//
	$mail->Subject = 'PPS Forex - Account Invitation';

	$mail->Body = 
		'<html>
		<head>
		<title></title>
		</head>
		<body>
		'.$_POST['content'].'
		</body>
		</html>';

	//$mail->SMTPDebug  = 1;
	if($mail->send()) {
		$success = 1;
	}else{
		//echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
}
echo $success;
?>