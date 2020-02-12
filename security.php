<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Forex - Account Security">
<meta name="author" content="PPS Forex">
<title>PPS Forex Security</title>

<?php include("./head.php");?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Account Security</h2>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-lock"></i> Account Security
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<!-- Profile -->
<div class="row">
	<div class="col-lg-12">
		<form id="securityForm" action="./ajax/save-security.php?<?php echo rand();?>" method="post" role="form">
				<br>
				<h3>Account Password</h3>
				<hr>
				<input type="checkbox" id="change_pass" name="change_pass" value="1" style="cursor: pointer;"> <strong>Change Password:</strong> 
				<br><br>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Old Password</label>
<input type="password" autocomplete="off" class="form-control" name="pass0" id="pass0" placeholder="Old Password" required disabled value="">
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
				
				<div class="row">
					<div class="form-group col-sm-6">
						<label>New Password</label>
<input type="password" pattern="^\S{6,}$" autocomplete="off" class="form-control" name="pass1" id="pass1" placeholder="New Password" onkeyup="this.setCustomValidity(validity.valueMissing ? 'Please enter your Password.' : '');" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.pass2.pattern = this.value;" required disabled value="">
					</div>
					<div class="form-group col-sm-6">
						<label>Confirm New Password</label>
<input type="password" pattern="^\S{6,}$" autocomplete="off" class="form-control" name="pass2" id="pass2" placeholder="Confirm New Password" onkeyup="this.setCustomValidity(validity.valueMissing ? 'Please enter confirmed Password.' : '');" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" required disabled value="">
					</div>
				</div>

				<hr>
				<input type="hidden" name="id" id="id" value="<?php echo $_SESSION['account'];?>">
				<input type="hidden" name="submit" id="submit" value="1">	
				<input type="submit" id="btn_change" class="btn btn-primary" value="Change Password" disabled>	<br><br>	
			</form>
		</div>
</div>
<!-- /.row -->
<?php
include("./foot.php");?>
<script>document.write("<script type='text/javascript' src='./security.js?v=" + Date.now() + "'><\/script>");</script>
</body>
</html>