<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Forex - My Account">
<meta name="author" content="PPS Forex">
<title>PPS Forex - My Payments</title>

<?php include("./head.php");
	
//Cancel Payments
if(isset($_GET['cancel'])){
	$sql0="UPDATE `account-payment` SET status='cancel' WHERE status='panding' AND id=".$_GET['cancel'];
	$db->query($sql0);
	if($db->rows_affected !== 0){
		$type = $_GET['type'];
		echo '<script>alert("'.ucfirst($type).' has been cancelled!");</script>';
	}
}

$total_deposit = $db->get_var("SELECT SUM(amount) FROM `account-payment` WHERE type IN('deposit') AND login IN(SELECT login FROM `account-detail` WHERE id=".$_SESSION['account'].");");
if($total_deposit==""){
	$total_deposit = '0.00';
}	
$total_withdraw = $db->get_var("SELECT SUM(amount) FROM `account-payment` WHERE type IN('withdraw') AND login IN(SELECT login FROM `account-detail` WHERE id=".$_SESSION['account'].");");
if($total_withdraw==""){
	$total_withdraw = '0.00';
}	
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">My Payments: <span style="font-size:24px;">Deposit: <span class="badge">$<?php echo $total_deposit;?></span> - Withdraw: <span class="badge">$<?php echo $total_withdraw;?></span></span></h2>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-dollar"></i> <?php echo ucfirst($_GET['type']);?> Transaction
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
		<table id="<?php echo $_GET['type'];?>" class="display" cellspacing="0" width="100%">
				<thead>
						<tr>
								<th>Date</th>
								<th>Login</th>
								<th>Type</th>
								<th>Amount</th>
								<th>Fee</th>
								<th>Method</th>
								<th>Comment</th>
								<th>Status</th>
								<th>Reason</th>
								<th></th>
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
				$sql="SELECT a.* 
							FROM `account-payment` AS a
							WHERE type IN('".$_GET['type']."') AND a.login IN(SELECT login FROM `account-detail` WHERE id=".$_SESSION['account'].")
							ORDER BY a.request_date DESC;";
				//echo $sql;
				$mt4 = $db->get_results($sql);
					if(!empty($mt4)){
						$i=0;
						foreach ( $mt4 as $row ) {
							$i+=1;
							$disable_cancel=null;
							$status = '<span class="badge badge-warning" tittle="Panding">'.ucfirst($row->status).'</span>';
							if($row->status=='approve'){
								$status = '<span class="badge badge-info" tittle="Approved">'.ucfirst($row->status).'d</span>';
								$disable_cancel='disabled';
							}else if($row->status=='cancel'){
								$status = '<span class="badge badge-error" tittle="Cancelled">'.ucfirst($row->status).'led</span>';
							}
							echo '
								<tr>
									<td><i class="fa fa-calendar" aria-hidden="true"></i> '.$row->request_date.'</td>
									<td><img src="./images/icons/mt4.png" /> <a href="./payment-detail.php?login='.$row->login.'" title="View Account Details">'.$row->login.'</a></td>
									<td>'.ucfirst($row->type).'</td>
									<td><strong>'.$row->amount.'</strong></td>
									<td>'.$row->fee.'</td>
									<td>'.ucfirst($row->method).'</td>
									<td>'.$row->comment.'</td>
									<td>'.$status.'</td>
									<td>'.$row->reason.'</td>
									<td><a href="#" id="'.$row->id.'" data-trx-id="'.$row->trx_id.'" data-type="'.$row->type.'" class="cancel btn btn-sm btn-primary '.$disable_cancel.'" style="padding-top:2px; padding-bottom:2px;" title="Cancel Payment">Cancel</a> &nbsp;|&nbsp; <a href="#" class="btn btn-sm btn-warning" style="padding-top:2px; padding-bottom:2px;" title="View Detail">Detail</a></td>
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
						<th>&nbsp;</th>
					</tr>
			</tfoot>
			
		</table>
    </div>
	</div>
</div>
<!-- /.row -->
<script>
$(document).ready(function (){
    var table = $('#<?php echo $_GET['type'];?>').DataTable({
        'responsive': true
    });
		
    // Handle click on "Expand All" button
    $('#btn-show-all-children-<?php echo $_GET['type'];?>').on('click', function(){
        // Expand row details
        table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
    });
		
    // Handle click on "Collapse All" button
    $('#btn-hide-all-children-<?php echo $_GET['type'];?>').on('click', function(){
        // Collapse row details
        table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
    });
});
</script>

<?php include("./foot.php");?>

</body>
</html>