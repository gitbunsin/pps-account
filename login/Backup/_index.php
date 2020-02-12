<?php session_start();
if(isset($_SESSION['login'])){
	header('Location: ../');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>PPS Social Trading | Log in</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="./plugins/iCheck/square/blue.css">

</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="./"><b style="color:#069">PPS</b> Affiliate Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your earning with PPS</p>

    <form id="login" action="./login.php?<?php echo rand();?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" required />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password"  required />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group">
          <table cellpadding="0" cellspacing="0"><tr><td>
            <input type="text" class="form-control" id="captcha_code" name="captcha_code" style="width:100px" AutoComplete="off" placeholder="Enter Code" required />
          </td>
          <td style="padding-left:5px;" >
            <img src="../components/phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'>
          </td>
          <td style="padding-left:5px;">
            <button id="btnRefresh" class="btn btn-success btn-block btn-flat" type="button" title="Refresh" onclick="javascript:refreshCaptcha();"><li class="fa fa-refresh"></li></button>
            <script type='text/javascript'>
							function refreshCaptcha(){
								var img = document.images['captchaimg'];
								img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
							}
						</script>
          </td>
          </tr></table>

      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          <input type="hidden" name="login" value="1" />
        </div>
        <!-- /.col -->
      </div>
    </form>
		<!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    -->
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="https://www.pps-forex.com/open-zulu" class="text-center">Register a new <b>Affiliate Broker</b></a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php 
	include("modal/invalid_code_msgbox.php");
	include("modal/invalid_login_msgbox.php");
	include("modal/error_msgbox.php");
?>

<!-- jQuery 2.2.3 -->
<script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- jQuery 2.2.3 -->
<script src="../components/jquery-loading-overlay-v1.5.3/src/loadingoverlay.min.js"></script>
<!-- Sumbit Form -->
<script src="./login.js?v=<?php echo rand();?>"></script>

<!-- Bootstrap 3.3.6 -->
<script src="../js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>