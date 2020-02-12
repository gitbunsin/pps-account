<?php //session_start();
//Original
//$url = explode(".",$_SERVER['HTTP_HOST']);
//$subdomain = trim((string)array_shift(($url)));
//if($subdomain=='www' || $subdomain=='khmerforex' || $subdomain=='kh' || $subdomain == 'localhost'){
//	$_SESSION['lang']=null;//khmer
//}else{
//	$_SESSION['lang']=$subdomain;
//}
	
//for Translate	
$_SESSION['lang']=null;	
if(isset($_GET['lang']) && ($_GET['lang']!="" || $_GET['lang']!="en")){	
	$_SESSION['lang']=$_GET['lang'];
}
//for SQL
$lang='_'.$_SESSION['lang'];//Not Khmer
if($_SESSION['lang']==null){
	$lang=null;
}
//Translate Kh <-> Eng.	
function switch_lang($en, $kh, $cn=null){
	switch($_SESSION['lang']){//en
		case 'kh':
			return $kh;
			break;
		case 'cn':
			if(isset($cn)){
				return $cn;
			}else{
				return $en;
			}
			break;
		default:
			return $en;
	}
}	
?>