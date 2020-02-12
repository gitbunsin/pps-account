<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Forex - Account Security">
<meta name="author" content="PPS Forex">
<title>PPS Forex - Withdrawal</title>

<?php include("./head.php");?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Account Withdraw - <label class="badge" style="font-size: 18px;">A/C: <?php echo $_GET['login'];?></label></h2>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="./">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-dollar"></i> Account Withdraw
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<?php
$sql="SELECT a.*
			FROM `account-request` AS a
			WHERE id=".$_SESSION['account'].";";
//echo $sql;
$row = $db->get_row($sql);
	if(!empty($row)){
?>
<!-- Profile -->
<div class="row">
	<div class="col-lg-12">
		<form id="withdrawForm" action="./ajax/save-withdraw.php?<?php echo rand();?>" method="post" role="form">
				<h3>Your Bank Account that wtihdrawal will send to:</h3>				
				<hr>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Bank Name</label>
						<input class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php echo $row->bank_name;?>" required>
					</div>
					<div class="form-group col-sm-6">
						<label>Bank Country</label>
					<select class="form-control" id="bank_country" name="bank_country">
							<?php
								require_once("../conn/mt4-config.php");  
								$sql="SELECT * FROM `countries`";
								$results = $db->get_results($sql);
								if(!empty($results)){
									foreach ( $results as $row2 ) {
										$sel=null;
										if($row2->countryCode==$row->bank_country){
											$sel='selected="selected"';
										}
										echo '<option value="'.$row2->countryCode.'" '.$sel.'>'.$row2->countryName.'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Bank Address</label>
						<input class="form-control" id="bank_address" name="bank_address" placeholder="Bank Address" value="<?php echo $row->bank_address;?>" required>
					</div>
					<div class="form-group col-sm-3">
						<label>Swift Code</label>
						<input class="form-control" id="bank_swift" name="bank_swift" placeholder="Swift Code" value="<?php echo $row->bank_swift;?>" required>
					</div>
					<div class="form-group col-sm-3">
						<label>Account Currency</label>
						<input class="form-control" id="bank_currency" name="bank_currency" placeholder="USD" value="<?php echo $row->bank_currency;?>" required>
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Account Name (Full Name)</label>
						<input class="form-control" id="bank_account_name" name="bank_account_name" placeholder="Bank Account Name" value="<?php echo $row->bank_account_name;?>" required>
					</div>
					<div class="form-group col-sm-6">
						<label>Account Number</label>
						<input class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Bank Account Number" value="<?php echo $row->bank_account_no;?>" autocomplete="off" required>
					</div>
				</div>
			
				<hr>
				<h3>Enter Withdrawal Amount:</h3>

				<div class="row">
					<div class="form-group col-sm-6">
						<label>Trading Account</label>
						<select class="form-control" id="login" name="login" disabled>
								<?php
									require_once("./conn/mt4-config.php"); 
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
				<?php 
					$equity = $db->get_var("SELECT balance FROM `account` WHERE login=".$_GET['login']);
				?>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Account Equity:</label>
<input class="form-control" name="balance" id="balance" placeholder="Account Balance" value="<?php echo $equity;?>" disabled>
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Withdrawal Amount (USD)</label>
<input class="form-control" type="number" min="0.01" max="<?php echo $equity;?>" step="0.01" name="amount" id="amount" placeholder="Withdraw Amount" onkeyup="validateNumber(this); this.setCustomValidity(validity.valueMissing ? 'Please enter withdraw amount' : '');" required value="1">
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Confirm Login Password</label>
<input class="form-control" type="password"  name="password" id="password" placeholder="Password" onkeyup="this.setCustomValidity(validity.valueMissing ? 'Please enter withdraw amount' : '');" required>
					</div>
					<div class="form-group col-sm-6"></div>
				</div>
								
				<input type="checkbox" id="confirm_term" name="confirm_term" value="1" style="cursor: pointer;" required> <strong>I've confirmed the above withdrawal amount and I am responsible for any issues to the account: [<?php echo $_GET['login'];?>]</strong> 
				<hr>
				<?php //echo $_SESSION['email'];?>
				<input type="hidden" name="email" value="<?php echo $acc_email;?>">
				<input type="hidden" name="id" id="id" value="<?php echo $_SESSION['account'];?>">
				<input type="hidden" name="login" value="<?php echo $_GET['login'];?>">
				<input type="hidden" name="comment" value="MT4: <?php echo $_GET['login'];?>">
				<input type="hidden" name="reason" value="Withdraw">
				<input type="hidden" name="submit" id="submit" value="1">	
				<input type="submit" class="btn btn-primary" value="Request Withdraw">
			</form>
		</div>
</div>
<!-- /.row -->
<?php }; 
include("./foot.php");?>
<script>document.write("<script type='text/javascript' src='./withdraw.js?v=" + Date.now() + "'><\/script>");</script>
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
                '//jquery-file-upload.appspot.com/' : '../components/jQuery-File-Upload-9.28.0/server/php/',
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