<?php
$msg=0;
if(isset($_POST['email']) && filter_var(trim($_POST['email']),FILTER_VALIDATE_EMAIL)){
	include("../../conn/mt4-config.php");
	$count = $db->get_var("SELECT COUNT(*) FROM `account-request` WHERE email='".trim($_POST['email'])."';");
	if($count > 0){
		$msg = 1;
	}
}
echo $msg;
?>