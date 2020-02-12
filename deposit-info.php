<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Forex - Account Security">
<meta name="author" content="PPS Forex">
<title>PPS Forex - Deposit/Funding</title>

<?php include("./head.php");
	$account = 0;
	if(isset($_GET['login'])){
		$account = $_GET['login'];
	}	
?>
<style>
@media (max-width: 767px) {
    .pt-5 {
      padding-top: 5px;
    }
    .pt-10 {
      padding-top: 10px;
    }
    .pt-15{
      padding-top: 15px;
    }
    .pt-20 {
      padding-top: 20px;
    }
}  
</style>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Account Deposit Info.</h2>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="./">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-dollar"></i> Account Deposit
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<?php
$sql="SELECT id, password FROM `account-request`
			WHERE id=".$_SESSION['account'].";";
//echo $sql;
$row = $db->get_row($sql);
	if(!empty($row)){
		$pass1 = $row->password;
?>
<!-- Profile -->
<div class="row">
	<div class="col-lg-12">
				<h3><i class="fa fa-check" style="color: #009900;"></i> Deposit Successful</h3>				
				<hr>
				<h4 style="padding-top: 20px; padding-bottom: 30px;"><strong>You made a successful deposit. Please check your Trading Account.</strong></h4>
  <h4><i class="fa fa-bank"></i> MT4 ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="color: #009900"><?php echo $account;?></strong></h4>
  <h4><i class="fa fa-money"></i> Amount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $<strong style="color: #009900;">1000.00</strong></h4>
  <br>
<hr>
 <br>
  <h4>Check your <a href="./payment-report.php?type=deposit" style="font-weight: bold!important;">Account</a> Balance</h4>
<br>

  </div>
</div>
<!-- /.row -->
<?php }; 
include("./foot.php");?>
<script>document.write("<script type='text/javascript' src='./deposit.js?v=" + Date.now() + "'><\/script>");</script>
</body>
</html>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
-->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="../components/jQuery-File-Upload-9.28.0/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script> 
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation 
<script src="_https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="../components/jQuery-File-Upload-9.28.0/js/jquery.fileupload-validate.js"></script>
<script>