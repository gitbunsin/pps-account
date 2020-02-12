<?php	session_start();
$msg=0; $sql=null;
//Security Type: Modern
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){
		//Invalid Security Code
		$msg = 2;
	}else{
		if(isset($_POST['login'])){
			include_once "../conn/mt4-config.php";
			include_once("../conn/info.php");
			include_once("../include/function.php");
			
			$sql="SELECT u.*, 
						(SELECT title FROM `title` WHERE titleid=u.titleid) AS title1, 
						COUNT(*) AS exist
						FROM `account-request` AS u 
						WHERE (u.email='".$_POST['email']."' OR u.phone='".$_POST['email']."') 
						AND u.password='".md5($_POST['password'])."' AND type NOT IN('ib');";
			//echo $sql;
			$row = $db->get_row($sql);
			//Login Success
			if((int)($row->exist)>0){
				$session = "off";
				//MoxieManager Override Config
				$_SESSION['isLoggedIn']	= true;
				$_SESSION['login']			=	$row->id;
				$_SESSION["moxiemanager.filesystem.rootpath"] = 'D:/www/pps-forex/account/uploads/'.$row->id;
				//SESSION["moxiemanager.filesystem.rootpath"] = 'D:/wamp/www/pps-forex/account/uploads/'.$row->id;
				//Cpanel Variable
				$_SESSION['name']		=	ucfirst($row->title1).". ".$row->firstname." ".$row->lastname;
				$_SESSION['country']=	$row->countryCode;
				$_SESSION['phone']	=	$row->phone;
				$_SESSION['email']	=	$row->email;
				$_SESSION['type']		=	$row->type;
				$_SESSION['ibcode']		=	$row->ibcode;
				$msg=1;
				//$msg = $sql;
			}else{
				$msg=0;
				//$msg= $sql;
			}
		}
	}

echo $msg;
//echo doLogin();
?>