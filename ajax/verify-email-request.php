<?php session_start();
$success=0;
if(isset($_POST['id']) && isset($_POST['email'])){
	//Generate Verification Link
	$link = md5($_POST['id'].'+'.$_POST['email'].'+'.date('Y-m-d'));
	//$link = $_POST['id'].'+'.$_POST['email'].'+'.date('Y-m-d');
	//Send Email
	require ('../../components/PHPMailer-v5.2.22/PHPMailerAutoload.php');
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
	$mail->setFrom('info@pps.com.kh', 'Phnom Penh Securities');
	$mail->addAddress($_POST['email']);		// Add a recipient

	//Add CC Email Notification
	include_once "../../conn/info.php";
	include_once "../../conn/mt4-config.php";
	$sql_cc ="SELECT * FROM `notification`
						WHERE status='on' AND verify_email='on';";
	$cc = $db->get_results($sql_cc);
	if(!empty($cc)){
		foreach ( $cc as $row ) {
			$mail->AddCC($row->email);
		}
	}

	$mail->isHTML(true);
	//
	$mail->Subject = 'PPS Forex - Email Verification';

	ob_start();
	include('../email/verify-email-request.php');
	$mail->Body = ob_get_contents();
	ob_end_clean();

	//$mail->SMTPDebug  = 1;
	if($mail->send()){
		$success=1;
	}
}
echo $success;
?>