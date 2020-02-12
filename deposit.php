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
        <h2 class="page-header">Account Deposit - <label class="badge" style="font-size: 18px;">A/C: <?php echo $account;?></label></h2>
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
		
				<h3>Deposit/Funding Option:</h3>				
				<hr>
  <h4>Please select your prefered payment methods: </h4>
<br>
   <div class="row">
	<div class="col-sm-4">
    <input type="radio" name="payment" value="bank" style="cursor: pointer;"/> <strong>Bank Deposit/Transfer</strong> &nbsp;<img src="./images/payments/canadia-logo.jpg" style="height: 32px;">&nbsp;<span style="color:#009900">Canadia Bank Plc</span>
     </div>
	<div class="col-sm-7 pt-10">
    <input type="radio" name="payment" value="card" style="cursor: pointer;"/> 
    <strong>Credit Card / Debit Card</strong> &nbsp;<img src="./images/payments/cards.png" style="height: 32px;">
     </div>
    </div>
<hr>
<div id="card-section" style="display: none;">
  <form id="cardForm" role="form" action="./deposit-info.php" method="post" enctype="multipart/form-data">
    <fieldset>
     <legend>Enter Deposit Amount:</legend>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="card_amount" style="padding-top: 10px;">Amount (USD)</label>
        <div class="col-sm-10">
          <div class="row" style="padding-top: 5px;">
            <div class="col-xs-4">
              <input type="text" class="form-control" name="card_amount" id="card_amount" value="1000" placeholder="1000" onkeyup="validateNumber(this); this.setCustomValidity(validity.valueMissing ? 'Please deposit amount.' : '');" required>
            </div>
            <div class="col-xs-8" style="white-space: nowrap;">
             <table><tr><td><strong>MT4 ID:</strong>&nbsp;</td><td><input type="text" class="form-control" value="<?php echo $account;?>" readonly></td></tr></table>
              
            </div>
          </div>
        </div>
      </div>
      
      <br><br>
      <legend>Enter Card Information:</legend>
      
      <div class="form-group">
        <label class="col-sm-2 control-label" for="card-holder-name" style="margin-top: 5px;">Name on Card</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name" required>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label" for="card-number" style="margin-top: 10px;">Card Number</label>
        <div class="col-sm-10" style="padding-top: 5px;">
          <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number" required>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label" for="expiry-month" style="padding-top: 10px;">Expiration Date</label>
        <div class="col-sm-10">
          <div class="row" style="padding-top: 5px;">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="col-xs-3">
              <select class="form-control" name="expiry-year">
                <option value="13">2020</option>
                <option value="14">2021</option>
                <option value="15">2022</option>
                <option value="16">2023</option>
                <option value="17">2024</option>
                <option value="18">2025</option>
                <option value="19">2026</option>
                <option value="20">2027</option>
                <option value="21">2028</option>
                <option value="22">2029</option>
                <option value="23">2030</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label" for="cvv" style="padding-top: 10px;">Card CVV</label>
        <div class="col-sm-2" style="padding-top: 5px;">
          <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code" required>
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10" >
         <hr>
          <button type="submit" class="btn btn-primary" id="btn-card-submit"><span class="fa fa-dollar"></span> Deposit Now</button>
          <br><br>
        </div>
      </div>
    </fieldset>
  </form>
</div>
<div id="bank-section" style="display: none;">
  <form id="depositForm" action="./ajax/save-deposit.php?<?php echo rand();?>" method="post" role="form">
  <h4>The follwing are PPS's Bank Account information:</h4>
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
						<tr>
							<td><strong>Remark/Comment:</strong></td><td>MT4: <strong>'.$account.'</strong></td>
						</tr>
						</table>
						<hr>';
				}
			}
	?>

		<h3>Uploading Deposit Slip:</h3>
			<div class="row">
					<div class="form-group col-sm-6">
						<label>Upload ID Card/Passport (Front and Back)</label><br>
						<!--<input id="upload" name="upload" type="file">-->

    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
				</span>
				<br>
				<br>
				<!-- The global progress bar -->
				<div id="progress" class="progress">
					<div class="progress-bar progress-bar-success"></div>
				</div>
				<!-- The container for the uploaded files -->
				<div id="files" class="files"></div>
				<br>
				</div>
				
				<div class="form-group col-sm-6">
				<label>My Uploaded Deposit Slip</label><br>
				<div style="border:1px solid #ddd; padding: 10px;">
					<div class="row">
					<?php
						$dir = dirname(realpath(__FILE__)).'/uploads/'.$_SESSION['account'].'/payments/thumbnail/';
						if(is_dir($dir)){
							$handle = opendir($dir);
							while($file = readdir($handle)){
								if($file !== '.' && $file !== '..'){
									echo '<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom:10px;">';
									echo '<a href="./uploads/'.$_SESSION['account'].'/payments/'.$file.'" target="_blank"><img src="./uploads/'.$_SESSION['account'].'/payments/thumbnail/'.$file.'" style="border:solid 1px #999; max-width:100%;" /></a>';
									echo '</div>';
								}
							}
						}
					?>
					</div>
					</div>
				</div>
				</div>
	
				<hr>
				
				<h3>Enter Deposit Amount:</h3>
        
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Trading Account</label>
						<select class="form-control" disabled>
								<?php
									require_once("../conn/mt4-config.php"); 
									$sql="SELECT login 
												FROM `account` AS a 
												WHERE a.login IN(SELECT login FROM `account-detail` WHERE id=".$_SESSION['account'].");";
									$results = $db->get_results($sql);
									if(!empty($results)){
										foreach ( $results as $row2 ) {
											$sel=null;
											if($row2->login==$account){
												$sel='selected="selected"';
											}
											echo '<option value="'.$row2->login.'" '.$sel.'>'.$row2->login.'</option>';
										}
									}
								?>
             </select>
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
				
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Account Balance:</label>
<input class="form-control" value="<?php echo $db->get_var("SELECT balance FROM `account` WHERE login=".$account);?>" disabled>
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Deposit Amount (USD)</label>
<input class="form-control" type="number" min="100" name="amount" id="amount" placeholder="Depsoit Amount" onkeyup="validateNumber(this); this.setCustomValidity(validity.valueMissing ? 'Please deposit amount.' : '');"  required value="1000">
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
				
				<input type="checkbox" id="confirm_term" name="confirm_term" value="1" style="cursor: pointer;" required> <strong>I've confirmed the above deposit amount.</strong> 
				<hr>
				<?php //echo $_SESSION['email'];?>
				<input type="hidden" name="email" value="<?php echo $acc_email;?>">			
				<input type="hidden" name="id" value="<?php echo $_SESSION['account'];?>">
				<input type="hidden" name="login" value="<?php echo $_GET['login'];?>">
				<input type="hidden" name="comment" value="MT4: <?php echo $_GET['login'];?>">
				<input type="hidden" name="reason" value="Deposit">
				<input type="hidden" name="submit" value="1">	
				<input type="submit" class="btn btn-primary" value="Submit Deposit">		
			</form>
		</div>
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
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '../components/jQuery-File-Upload-9.28.0/server/php/payment/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>