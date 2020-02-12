<?php session_start();
$success=0;
if(isset($_POST['submit'])){
	include_once "../../conn/info.php";
	include_once "../../conn/mt4-config.php";
	$sql="UPDATE `account-request` SET
				email							= '".$_POST['email']."',
				phone							= '".$_POST['phone']."',
				
				nationalityid			= ".$_POST['nationality'].",
				
				idcard						= '".$_POST['idcard']."',
				date_of_birth			= '".$_POST['yyyy']."-".$_POST['mm']."-".$_POST['dd']."',
				street 						= '".$db->escape($_POST['street'])."',
				city 							= '".$_POST['city']."',
				state 						= '".$_POST['state']."',
				zip 							= '".$_POST['zip']."',
				
				bank_name 				= '".$db->escape($_POST['bank_name'])."',
				bank_country			= '".$_POST['bank_country']."',
				bank_address			= '".$db->escape($_POST['bank_address'])."',
				bank_swift				= '".$_POST['bank_swift']."',
				bank_currency			= '".$_POST['bank_currency']."',
				bank_account_name	= '".$db->escape($_POST['bank_account_name'])."',
				bank_account_no 	=	'".$_POST['bank_account_no']."'
				
				WHERE id					= ".$_POST['id'].";"; 
		//$success=$sql;			
		$db->query($sql);
		if($db->rows_affected !== 0){
       $success=1;
    }
	}//Submit
echo $success;
?>