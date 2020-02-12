<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Social IB Network">
<meta name="author" content="PPS Affiliates">
<title>PPS Forex - Invite Friends</title>

<?php include("./head.php");
	$ib_code = $db->get_var("SELECT ibcode FROM `account-request` WHERE id=".$_SESSION['clogin']);
?>
 
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
       <h2 class="page-header">Introducing Friends</h2>
        <h3 class="page-header">
            Start invite your Friends to PPS Forex
        </h3>
    </div>
</div>
<div class="row">
  <div class="col-lg-9">
  	<p>Your Affliate Link: <b style="color:#009900"><a href="https://www.pps-forex.com/open-account?ib=<?php echo $ib_code;?>" target="_blank">https://www.pps-forex.com/open-account?ib=<?php echo $ib_code;?></a></b></p>
  	<p>...and earn a standard commission for each trade that they make, forever!</p>
		<br />
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Refer to your friend to start trade with PPS Forex</h3>
        </div>
        <div class="panel-body">
						<p>Enter your friends' e-mails separated by comma (,) or in a new line.</p>
            <form id="form-invitation" action="./ajax/send-invitation.php?v=<?php echo rand();?>" role="form">
              <div class="form-group">
                <label>To:</label>
                <input class="form-control" type="text" name="to" id="to" placeholder="friend@email.com">
                <p class="help-block">Example: friend@gmail.com; investor@yahoo.com; ...</p>
              </div>
              <div class="form-group">
                <label>Message</label>
                <small style="color:#009900">This will be your message. You may change it to personalize your invitation.</small>               
              	<textarea class="form-control" name="content" id="content" placeholder="Write your contents here" >
								<p>Dear Friend,</p> 
                <p>Hello, we are Phnom Penh Securities Plc (PPS), and we want to take this time to welcome you to the Forex Trading with PPS and to THANK YOU for joining our growing community.</p>
                <p>Traders at PPS have been successfully trading the market for many years. We are here to help you to create second income.</p>
                <p>To open Demo or Live Account, please click:<br>
                <a href="https://www.pps-forex.com/open-account?ib=<?php echo $ib_code;?>">https://www.pps-forex.com/open-account?ib=<?php echo $ib_code;?></a></p>
                <p>To know more about information, please feel free to contact me by phone: <?php echo $_SESSION['cphone'];?></p>
								<p>We want to again WELCOME you to the Forex Trading and THANK YOU for putting your trust in PPS and we truly look forward to a long lasting relationship.</p>
								<p>Best Regards,</p>
								<p><?php echo $_SESSION['cname'];?></p>
                </textarea>
              </div>
              <button type="submit" class="btn btn-primary">Send Message</button>
              <input type="hidden" name="submit" value="1"?/>
              <input type="hidden" name="name" value="<?php echo $_SESSION['cname'];?>"?/>
              <input type="hidden" name="email" value="<?php echo $_SESSION['cemail'];?>"?/>
              <input type="hidden" name="phone" value="<?php echo $_SESSION['cphone'];?>"?/>              
              <br />
            </form>
         </div>
    </div>
  </div>
  <div class="col-lg-3"><!--<img src="./images/social.png" style="width:200px;" />--></div>	
</div>
<!-- /.row -->

<?php include("./foot.php");?>
<script>document.write("<script type='text/javascript' src='./invite.js?v=" + Date.now() + "'><\/script>");</script>
</body>
</html>