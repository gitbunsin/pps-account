<?php	session_start();
$data=0; $sql=null;
//Security Type: Modern
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){
		//Invalid Security Code
		$data = 2;
	}else{
		if(isset($_POST['login'])){
			include ('../../conn/mt4-config.php');
      include ('../../conn/info.php');
      include ('../../include/function.php');
			
			$sql="SELECT * FROM `account-request`
            WHERE (email='".$_POST['email']."' OR phone='".$_POST['email']."' OR ibcode='".$_POST['email']."') 
            AND password='".md5($_POST['password'])."' AND type NOT IN('ib');";
			//echo $sql;
			$row = $db->get_row($sql);
			//Login Success
			if(!empty($row)){
				$session = "off";
        $_SESSION['account']	=	$row->id;

				$data=1;
				//$data = $sql;
			}else{
				$data=0;
				//$data= $sql;
			}
		}
	}

echo $data;
//echo doLogin();
?>