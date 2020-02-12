<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Social IB Network">
<meta name="author" content="PPS Affiliates">
<title>PPS Social IB</title>

<?php include("./head.php");?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Investors
      </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="./">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-bar-chart-o"></i> Investor
          </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<!-- Flot Charts -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Investor Accounts <span class="badge">1</span></h3>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Acc. Date</th>
                            <th>Account No.</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Balance</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
										$sql="SELECT a.* FROM `mt4_account` AS a WHERE (a.email IN('".$_SESSION['cemail']."') OR a.name IN('".$_SESSION['cname']."')) AND a.group IN('PPS-S20L10-Zulu');";
										$results = $db->get_results($sql);
											if(!empty($results)){
												foreach ( $results as $row ) {
													echo '
														<tr>
															<td>'.$row->regdate.'</td>
															<td><img src="./images/icons/mt4.png" /> '.$row->login.'</td>
															<td>'.$row->name.'</td>
															<td>'.$row->phone.'</td>
															<td>'.$row->email.'</td>
															<td>'.$row->balance.'</td>
															<td>'.$row->credit.'</td>
														</tr>													
													';
												}
											}
										?>
                  </tbody>
                </table>
            </div>
    </div>
</div>
<!-- /.row -->

<?php include("./foot.php");?>

</body>
</html>