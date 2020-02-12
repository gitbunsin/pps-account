<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Forex - My Account">
<meta name="author" content="PPS Forex">
<title>PPS Forex Account</title>

<?php $table='open_account'; include("./head.php");?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><img src="./images/icons/mt4.png" /> Trading Account <span class="badge"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-detail` WHERE id=".$_SESSION['account']);?></span></h3>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-globe"></i> MT4 Account
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<!-- Flot Charts -->
<div class="row">
	<div class="col-lg-12">
	<div class="table-responsive">
	<link href="./css/datatables.min.css" rel="stylesheet">
	<script src="./js/datatables.min.js"></script>
	<!--
	<br>
		<button id="btn-show-all-children-open-account" type="button">Expand All</button>
		<button id="btn-hide-all-children-open-account" type="button">Collapse All</button>
		<hr>
		-->
		<table id="<?php echo $table;?>" class="display" cellspacing="0" width="100%">
				<thead>
						<tr>
								<th>No.</th>
								<th>MT4 ID</th>
								<th>Open</th>
								<th>Name</th>
								<th>Closed</th>
								<th>Balance</th>
								<th>Floating</th>
								<th>Equity</th>
								<th>Volume</th>
								
								<!--<th class="none"></th>-->
						</tr>
				</thead>
				<!--
				<tfoot>
						<tr>
								<th>Name</th>
								<th>Position</th>
								<th>IB Code</th>
								<th>Team1</th>
								<th>Team2</th>
								<th>Team3</th>
						</tr>
				</tfoot>
				-->
				<tbody>
				<?php
				$sql="SELECT 
							a.login,
							DATE(a.regdate) AS date,
							a.name,
              (SELECT SUM(REPLACE(closed_pl,' ','')) FROM `history` WHERE login=a.login) AS closed,
							REPLACE(h.balance,' ','') AS balance,
              REPLACE(h.equity,' ','') AS equity,
              REPLACE(h.floating_pl,' ','' ) AS floating,
							(SELECT SUM(volume) FROM `report` WHERE login IN(a.login)) AS volume
							FROM `account` AS a
              LEFT JOIN `history` AS h ON h.login=a.login AND h.time=(SELECT MAX(time) FROM `history`)
							WHERE a.login IN(SELECT login FROM `account-detail` WHERE id=".$_SESSION['account'].");";
				//echo $sql;
				$mt4 = $db->get_results($sql);
					if(!empty($mt4)){
						$i=0;
						foreach ( $mt4 as $row ) {
							$i+=1;
							
							echo '
								<tr>
									<td>'.$i.'</td>
									<td><img src="./images/icons/mt4.png" /> <a href="./account-detail.php?login='.$row->login.'" title="View Account Details">'.$row->login.'</a></td>
									<td><i class="fa fa-calendar" aria-hidden="true"></i> '.$row->date.'</td>
									<td>'.$row->name.'</td>
                  <td>'.number_format($row->closed,2).'</td>
									<td>'.number_format($row->balance,2).'</td>
									<td>'.number_format($row->floating,2).'</td>
									<td>'.number_format($row->equity,2).'</td>
									<td>'.number_format($row->volume,2).'</td>';
              if($acc_type!='ib'){
                echo '
									<td><a href="./deposit.php?login='.$row->login.'" class="btn-sm btn-primary" title="Deposit Money">Deposit</a> &nbsp;|&nbsp; <a href="./withdraw.php?login='.$row->login.'" class="btn-sm btn-warning" title="Withdrawal Money">Withdraw</a></td>';
              }
              echo '
								</tr>													
							';
						}
					}
				?>
				</tbody>
				
				<tfoot>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
			</tfoot>
			
		</table>
    </div>
	</div>
</div>

<hr>
  <h3>Deposit/Funding Option:</h3> 
	
  <p>Please fund your Forex MT4 Account with following funding methods: </p>
  <ol type="1" style="font-size:14px;">
    <li>By <strong>Cash</strong> (Visit PPS's Office)</li>
    <li>By <strong>Bank transfer</strong>:</li>
  </ol>
  
  <p>The follwing are PPS's Bank Account information:</p>
	<?php
		require_once("../conn/mt4-config.php");
		$sql="SELECT * FROM `bank` WHERE status='on';";
		$results = $db->get_results($sql);
		if(!empty($results)){
			foreach ( $results as $row ) {
				echo '
				   <table class="table table-striped" style="font-size:14px;">
						<tr>
							<td><strong>Bank Name:</strong></td><td style="color:#009900"><img src="'.$row->logo.'" width="24px;" /> '.$row->bankname.'</td>
						</tr>
						<tr>
							<td><strong>Account Number:</strong></td><td><strong>'.$row->accountno.'</strong></td>
						</tr>
						<tr>
							<td><strong>Beneficiary Name:</strong></td><td>'.$row->accountname.'</td>
						</tr>
						<tr>
							<td><strong>Bic Number/SWIFT Code:</strong></td><td style="color:#009900">'.$row->swiftcode.'</td>
						</tr>
					</table>
					<hr>
				';
			}
		}
	?>
<!-- /.row -->
<script>
$(document).ready(function (){
    var table = $('#<?php echo $table;?>').DataTable({
        'responsive': true
    });
		
    // Handle click on "Expand All" button
    $('#btn-show-all-children-<?php echo $table;?>').on('click', function(){
        // Expand row details
        table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
    });
		
    // Handle click on "Collapse All" button
    $('#btn-hide-all-children-<?php echo $table;?>').on('click', function(){
        // Collapse row details
        table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
    });
});
</script>

<?php include("./foot.php");?>

</body>
</html>