<?php session_start();
$success=0;
if(isset($_POST['submit'])){
	include_once "../../conn/info.php";
	include_once "../../conn/mt4-config.php";
	$pasword =$db->get_var("SELECT COUNT(*) FROM `account-request` 
													WHERE password='".md5($_POST['password'])."' 
													AND id='".$_POST['id']."';");
	if($pasword>0){//If Password Correct
		$sql="INSERT INTO `account-payment`(
					login,
					request_date,
					request_by,
					type,
					amount,
					fee,
					tax,
					method,
					comment,
					reason)
					VALUES(
					".$_POST['login'].",
					NOW(),
					".$_SESSION['account'].",
					'withdraw',
					".$_POST['amount'].",
					0.00,
					0.00,
					'bank',
					'".$db->escape($_POST['comment'])."',
					'".$db->escape($_POST['reason'])."');";
		//$insert_id=0;
		if($db->query($sql)){
			//Generate Order#
			$insert_id	= $db->insert_id;
			$trx_id			= 'WD'.sprintf('%06d', $insert_id);
			$trx_date		= date('Y-m-d H:i:s');	

			//-----------------
			//UPDATE BANK INFO
			//-----------------
			$sql2= "UPDATE `account-request` SET
							bank_name 				= '".$db->escape($_POST['bank_name'])."',
							bank_country			= '".$_POST['bank_country']."',
							bank_address			= '".$db->escape($_POST['bank_address'])."',
							bank_swift				= '".$_POST['bank_swift']."',
							bank_currency			= '".$_POST['bank_currency']."',
							bank_account_name	= '".$db->escape($_POST['bank_account_name'])."',
							bank_account_no 	=	'".$_POST['bank_account_no']."'
							WHERE id					= ".$_POST['id'].";";
			$db->query($sql2);
			
			//Update Trx ID
			$db->query("UPDATE `account-payment` SET trx_id='".$trx_id."' WHERE id=".$insert_id);
			
			$success=1;

			//Send Email
			require ('../../components/PHPMailer-v5.2.22/PHPMailerAutoload.php');
			//----------------------
			// Send Email to Client
			//----------------------
			$mail = new PHPMailer;
			//
			$mail->isSMTP();                  			// Set mailer to use SMTP
			$mail->Host 			= 'mail.pps.com.kh';  	// Specify main and backup server
			$mail->SMTPAuth 	= true;          				// Enable SMTP authentication
			$mail->Username 	= 'support@pps.com.kh';	// SMTP username
			$mail->Password 	= 'Mail4PPS2013$';			// SMTP password
			$mail->Port 			= 465;									// STMT port

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
			$mail->addAddress($_POST['email']);			// Add a recipient

			//Add CC Email Notification
			$sql_cc ="SELECT * FROM `notification` 
								WHERE status='on' AND withdraw='on';";
			$cc = $db->get_results($sql_cc);
			if(!empty($cc)){
				foreach ( $cc as $row ) {
					$mail->AddCC($row->email);
				}
			}
			
			$mail->isHTML(true);
			//
			$mail->Subject = 'PPS Forex Withdraw Form';

			ob_start();
			include('../email/withdraw-request.php');
			$mail->Body = ob_get_contents();
			ob_end_clean();

			//$mail->SMTPDebug  = 1;
			$mail->send();
		}
	}else{//If Password Wrong
		$success=2;
	}
}//End Submit
echo $success;
?>