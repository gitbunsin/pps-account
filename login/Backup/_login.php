<?php session_start();$msg = 0;
if(isset($_POST['login'])){
	include("../conn/info.php");
	
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){
		//Invalid Security Code
		$msg = 2;
	}else{
		include "../conn/config.php";
		include_once("../include/function.php");
		$sql="SELECT a.*, COUNT(*) AS foo
					FROM `mt4_account` AS a 
					WHERE a.email='".$_POST['email']."' 
					AND a.login='".$_POST['password']."';";
		//echo $sql;
		$row = $db->get_row($sql);
		//Login Success
		if((int)($row->foo)>0){
			$msg = 1;
			$session = "off";
			$foo = true;
			//MoxieManager Override Config
			$_SESSION['isLoggedIn']	= true;
			$_SESSION['login']			=	$row->login;
			$_SESSION["moxiemanager.filesystem.rootpath"] = 'D:/www/pps-forex/uploads/'.$row->login;
			//$_SESSION["moxiemanager.filesystem.rootpath"] = 'D:/wamp/www/pps-forex/uploads/'.$row->login;
			//Cpanel Variable
			$_SESSION['name']		=	$row->name;
			$_SESSION['email']			=	$row->email;
		}
	}
}
echo $msg;
?>