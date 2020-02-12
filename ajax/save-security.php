<?php session_start();
$success=0;
if(isset($_POST['submit'])){
	include_once "../../conn/info.php";
	include_once "../../conn/mt4-config.php";
	//Check Old Password
	$count = $db->get_var("SELECT COUNT(*) FROM `account-request` WHERE id=".$_POST['id']." AND password='".md5($_POST['pass0'])."';");
	if($count > 0){
		//Update New Password
		$sql="UPDATE `account-request` SET
					password	= '".md5($_POST['pass1'])."',
					password2	= '".trim($_POST['pass1'])."'
					WHERE id	= ".$_POST['id'].";";
		//$success=$sql;			
		$db->query($sql);
		if($db->rows_affected !== 0){
			 $success=1;
		}
	}else{
		$success=2;
	}
}//Submit
echo $success;
?>