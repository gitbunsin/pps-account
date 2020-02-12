<?php
//include_once "../conn/info.php";
//include_once "../conn/mt4-config.php";	

$email = $db->get_var("SELECT email FROM `account-request` WHERE id=".$_SESSION['account']." AND email_status IN('not verify');");

if(isset($_GET['verify']) && !empty($_GET['verify']) && !empty($email)){

	
	//echo 'Link:'.md5($_SESSION['login'].'+'.$email.'+'.date('Y-m-d'));
	
	if($_GET['verify'] == md5($_SESSION['account'].'+'.$email.'+'.date('Y-m-d'))){
		$sql="UPDATE `account-request` SET
					email_status	= 'verify'
					WHERE id	= ".$_SESSION['account'].";";
		//$success=$sql;			
		$db->query($sql);
		if($db->rows_affected !== 0){
			echo '<script>alert("Congraduation!!\n Your email is verified!");</script>';
			//Send Email
			require ('../components/PHPMailer-v5.2.22/PHPMailerAutoload.php');
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
			$mail->addAddress($email);		// Add a recipient

			//Add CC Email Notification
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
			include('./email/verify-email.php');
			$mail->Body = ob_get_contents();
			ob_end_clean();
			
			//$mail->SMTPDebug  = 1;
			$mail->send();
		}
	}//Submit		
}//Confirm
?>