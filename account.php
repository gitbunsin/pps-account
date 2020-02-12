<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Account Management">
<meta name="author" content="PPS Forex">
<title>PPS Forex Account</title>

<?php
	include_once("./head.php");
?>

<!-- Page Heading -->
<?php
$ibcode_filter=null;
if(isset($_SESSION['cibcode']) && $_SESSION['cibcode']!=""){
	$ibcode_filter="AND a.login IN(SELECT login FROM `account-relation` WHERE upline IN('".$_SESSION['cibcode']."'))";
}	
	
$filter = "AND a.login IN(SELECT login FROM `account-relation` WHERE upline IN('".$_SESSION['cibcode']."'))";	
if($_SESSION['cpositionid']==1){
	$filter=null;
}
$total_forex = $db->get_var("SELECT COUNT(*) AS total_mt4 FROM `account` AS a 
															WHERE a.group NOT IN('PPS_Dynasty','PPS-ZulA','PPS-ZuSTP') ".$ibcode_filter.$filter.";");

$total_dynasty= $db->get_var("SELECT COUNT(*) AS total_mt4 FROM `account` AS a 
															WHERE a.group IN('PPS_Dynasty') ".$ibcode_filter.$filter.";");
$name = $db->get_var("SELECT name FROM `user` WHERE ibcode='".$_SESSION['cibcode']."';");
?>

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
            <?php echo $name;?> <span class="badge"><?php echo ($total_forex + $total_dynasty);?></span>
      	</h2>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="./">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-bar-chart-o"></i> MT4 Account | IB Code: <?php echo $_SESSION['cibcode'];?>
          </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<!-- Flot Charts -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">MT4 Accounts <span class="badge"><?php echo $total_forex;?></span></h3>
            <div class="table-responsive">
  						<?php $group="general"; include("./mt4-account.php");?>
            </div>
    </div>
    <div class="col-lg-12">
        <h3 class="page-header">Dynasty Accounts <span class="badge"><?php echo $total_dynasty;?></span></h3>
            <div class="table-responsive">
							<?php $group="dynasty"; include("./mt4-account.php");?>
            </div>
    </div>

</div>
<!-- /.row -->

<?php include("./foot.php");?>

</body>
</html>