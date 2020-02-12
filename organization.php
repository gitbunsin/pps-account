<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Account Management">
<meta name="author" content="PPS Forex">
<title>Organizaton</title>

<?php include("./head.php");?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <i class="fa fa-fw fa-sitemap"></i> Organization
      	</h3>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="./">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-fw fa-sitemap"></i> Organizaton
          </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-sm-12" style="max-width: 100%;">
      <h4 class="page-header">
        <i class="fa fa-pie-chart"></i> Accounts Summary
      </h4>
		 <table class="table">
 	<tr>
 		<th>Monthly Lot</th>
 		<th>Last Equity</th>
 		<th>Unrealized P/L</th>
 		<th>Last Balance</th>
 		<th>Daily Net Deposit</th>
 		<th>Net Deposit</th>
 		<th>Monthly P/L</th>
 		<th>Total Accounts</th>
 	</tr>
<?php
include_once("./conn/mt4-config.php");
$from = date('Y-m-01 00:00:00');
$to = date('Y-m-d 00:00:00');
       
$deposit = $db->get_var("SELECT SUM(profit) FROM `report` WHERE LOCATE('Dep',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`);");
$withdraw	= $db->get_var("SELECT SUM(profit) FROM `report` WHERE LOCATE('With',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`);");
$profit_loss = $db->get_var("SELECT SUM(profit) FROM `report` WHERE type IN('buy','sell') AND close_time<>'' AND login IN(SELECT login FROM `account-relation`);");
	
$last_balance = $db->get_var("SELECT FORMAT(SUM(r.profit),2) AS Last_Balance 
FROM `report` AS r INNER JOIN `account-relation` AS a ON a.login = r.login
WHERE r.type IN('balance') AND r.login IN(SELECT login FROM `account-relation`);");
	
$monthly_deposit = $db->get_var("SELECT SUM(profit) AS Monthly_Deposit
FROM `report`
WHERE LOCATE('Dep',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`) AND (open_time BETWEEN '".$from."' AND NOW());");
	
$monthly_widthdraw = $db->get_var("SELECT SUM(profit) AS Monthly_Withdraw
FROM `report`
WHERE LOCATE('Width',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`) AND (open_time BETWEEN '".$from."' AND NOW());");
$net_deposit = ($monthly_deposit - $monthly_widthdraw);

$monthly_pl = $db->get_var("SELECT FORMAT(SUM(profit),2) FROM `report` WHERE type IN('buy','sell') AND (close_time BETWEEN '".$from."' AND NOW()) AND login IN(SELECT login FROM `account-relation`);");	

$equity = ($deposit + $profit_loss);

$account = $db->get_var("SELECT COUNT(DISTINCT login) AS Monthly_Open
FROM `report` 
WHERE login IN(SELECT login FROM `account-relation`) AND type='balance' AND open_time BETWEEN '".$from."' AND NOW();
");
?>
 	<tr>
 		<tbody>
 			<td><?php //echo $total_lot;?></td>
 			<td><?php echo number_format($equity,2);?></td>
 			<td><?php echo number_format($profit_loss,2);?></td>
 			<td><?php echo ($last_balance);?></td>
 			<td><?php echo number_format(($monthly_deposit/24),2);?></td>
 			<td><?php echo number_format($net_deposit,2);?></td>
 			<td><?php echo $monthly_pl;?></td>
 			<td><?php echo $account;?></td>
 		</tbody>
 	</tr>
 </table>
  </div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-sm-12" style="max-width: 100%;">
    <h4 class="page-header">
      <img src="./images/icons/mt4.png" /> Pending Approval <span class="badge badge-primary" title="Pending Aprroval"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-request` WHERE status ='not verify' AND upline='".$_SESSION['ibcode']."';");?></span>
    </h4>
	<table class="table">
    <tr>
      <th>No.</th>
      <th>Date</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>A/C Type</th>
      <th>ID Card</th>
      <th>Country</th>
    </tr>
 	<tbody>
  <?php
  $sql="SELECT
        DATE_FORMAT(a.date,'%d-%m-%Y') reg_date,
        concat(t.title,'. ',a.lastname,' ',a.firstname) as fullname,
        a.phone,
        a.email,
        a.type,
        a.idcard,
        c.countryName
        FROM `account-request` AS a
        INNER JOIN title AS t ON a.titleid = t.titleid
        INNER JOIN countries AS c ON a.countryCode = c.countryCode
        WHERE a.status='not verify' AND a.upline='".$_SESSION['ibcode']."';";
  //echo $sql;
  $mt4 = $db->get_results($sql);
  if(!empty($mt4)){
    $i=0;
    foreach ( $mt4 as $row ) { 
      $i+=1;  $row_style=null;
      if($i%2){
        $row_style='style="background-color:#f8f8f8;"';
      }
      echo'    
      <tr '.$row_style.'>
        <td>'.$i.'</td>
        <td>'.$row->reg_date.'</td>
        <td>'.ucwords(strtolower($row->fullname)).'</td>
        <td>'.$row->phone.'</td>
        <td>'.$row->email.'</td>
        <td>'.strtoupper($row->type).'</td>
        <td>'.$row->idcard.'</td>
        <td>'.$row->countryName.'</td>
      </tr>';
        }
      }
  ?>
 	</tbody>
 </table>
  </div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-sm-12" style="max-width: 100%;">
	     <h4 class="page-header">
            <img src="./images/icons/mt4.png" /> Active Accounts <span class="badge badge-primary" title="Pending Aprroval"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-request` WHERE status ='verify' AND upline='".$_SESSION['ibcode']."';");?></span>
      	</h4>
	<table class="table">
 	<tr>
 		<th>No.</th>
 		<th>Date</th>
 		<th>Name</th>
 		<th>Phone</th>
 		<th>Email</th>
 		<th>A/C Type</th>
 		<th>ID Card</th>
 		<th>Country</th>
 	</tr>
 	<tbody>
   <?php
  $sql="SELECT
        DATE_FORMAT(a.date,'%d-%m-%Y') reg_date,
        concat(t.title,'. ',a.lastname,' ',a.firstname) as fullname,
        a.phone,
        a.email,
        a.type,
        a.idcard,
        c.countryName
        FROM `account-request` AS a
        INNER JOIN title AS t ON a.titleid = t.titleid
        INNER JOIN countries AS c ON a.countryCode = c.countryCode
        WHERE a.status='verify' AND a.upline='".$_SESSION['ibcode']."';";
  //echo $sql;
  $mt4 = $db->get_results($sql);
  if(!empty($mt4)){
    $i=0;
    foreach ( $mt4 as $row ) { 
      $i+=1;  $row_style=null;
      if($i%2){
        $row_style='style="background-color:#f8f8f8;"';
      }
      echo'    
      <tr '.$row_style.'>
        <td>'.$i.'</td>
        <td>'.$row->reg_date.'</td>
        <td>'.ucwords(strtolower($row->fullname)).'</td>
        <td>'.$row->phone.'</td>
        <td>'.$row->email.'</td>
        <td>'.strtoupper($row->type).'</td>
        <td>'.$row->idcard.'</td>
        <td>'.$row->countryName.'</td>
      </tr>';
        }
      }
  ?>
 	</tbody>
 </table>
  </div>
</div>
<!-- /.row -->
<?php include("./foot.php");?>

</body>
</html>