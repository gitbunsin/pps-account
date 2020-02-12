<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PPS Forex - My Profile">
<meta name="author" content="PPS Forex">
<title>PPS Forex - My Profile</title>

<?php 
	include("./head.php");
	include("./verify-email.php");
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">My Profile - <strong><?php echo $db->get_var("SELECT IFNULL(business_name, CONCAT(lastname, firstname)) AS name FROM `account-request` WHERE ibcode='".$acc_ibcode."';");?></strong></h3>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="./">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-user"></i> My Profile
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<?php
	$id=$_SESSION['account'];
	$reg_date=null;
	$branch=null;
	$upline="PPS";
//Persocnal Info
	$idcard=null;
	$date_of_birth=null;
	$street=null;
	$city=null;
	$state=null;
	$zip=null;
//Bank Info
	$bank_name=null;
	$bank_country=0;
	$bank_address=null;
	$bank_swift=null;
	$bank_currency=null;
	$bank_account_name=null;
	$bank_account_number=null;
	
	$readonly_personal=null;
	$readonly_bank=null;
	
$sql="SELECT a.*, t.title, n.nationality, c.countryCode, c.countryName,
			(SELECT branchname FROM `branch` WHERE branchid=a.branchid) AS branch,
			(SELECT countryName FROM `countries` WHERE countryCode=a.bank_country) AS bank_county,
			DATE(date) AS reg_date,
			(DATE_FORMAT(a.date_of_birth, '%Y')) AS yyyy, 
			(DATE_FORMAT(a.date_of_birth, '%m')) AS mm,
			(DATE_FORMAT(a.date_of_birth, '%d')) AS dd
			FROM `account-request` AS a
			LEFT JOIN `title` AS t ON t.titleid = a.titleid
			LEFT JOIN `nationality` AS n ON n.nationalityid = a.nationalityid
			LEFT JOIN `countries` AS c ON c.countryCode = a.countryCode
			WHERE a.id=".$_SESSION['account'].";";
//echo $sql;
$row = $db->get_row($sql);
	if(!empty($row)){
		$id 							= $row->id;
		$reg_date 				= $row->reg_date;
		$branch						= $row->branch;

    if(!empty($row->upline)){
		  $upline 				= $row->upline;
    }
		//Persocnal Info
		$idcard						=	$row->idcard;
		$dob							= $row->date_of_birth;
		$yyyy							=	$row->yyyy;
		$mm								= $row->mm;
		$dd								= $row->dd;
		$street						= $row->street;
		$city							= $row->city;
		$state						= $row->state;
		$zip							= $row->zip;
	//Bank Info
		$bank_name				= $row->bank_name;
		$bank_country			= $row->bank_county;
		$bank_address			= $row->bank_address;
		$bank_swift				= $row->bank_swift;
		$bank_currency		= $row->bank_currency;
		$bank_account_name= $row->bank_account_name;
		$bank_account_no	= $row->bank_account_no;
		
		if($row->status=='verify'){
			$readonly_personal = 'readonly';
		}
		
?>
<!-- Profile -->
<div class="row">
	<div class="col-lg-12">
		<form id="profileForm" action="./ajax/save-profile.php?<?php echo rand();?>" method="post" role="form">
		<strong>Branch:</strong> <span class="badge" style="font-size: 14px;"><?php echo $branch;?></span> &nbsp;|&nbsp; 
			<strong>Top Level:</strong> <span class="badge" style="font-size: 14px;"><?php echo $upline;?></span> &nbsp;|&nbsp; 
			<strong>Account Type:</strong> <span class="badge" style="font-size: 14px;"><?php echo strtoupper($acc_type);?></span>
				<div class="row" style="padding-top:20px;">
					<div class="form-group col-sm-2">
						<label>IB Code</label>
						<input class="form-control" id="ibcode" name="ibcode" value="<?php echo $row->ibcode;?>" readonly>
					</div>
					<div class="form-group col-sm-2">
						<label>Title</label>
						<select class="form-control" id="title" name="title" disabled>
								<?php
									require_once("../conn/mt4-config.php");
									$sql="SELECT * FROM `title`;";
									$results = $db->get_results($sql);
									if(!empty($results)){
										foreach ( $results as $row1 ) {
											$sel=null;
											if($row1->titleid==$row->titleid){
												$sel='selected="selected"';
											}
											echo '<option value="'.$row1->titleid.'" '.$sel.'>'.ucfirst($row1->title).'.</option>';
										}
									}
								?>
						</select>
					</div>
					<div class="form-group col-sm-4">
						<label>First Name</label>
						<input class="form-control" id="firstname" name="firstname" value="<?php echo $row->firstname;?>" readonly>
					</div>
					<div class="form-group col-sm-4">
						<label>Last Name</label>
						<input class="form-control" id="lastname" name="lastname" value="<?php echo $row->lastname;?>" readonly>
					</div>
				</div>
				
				<?php
					$email_status = '<i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color:#f00;" title="Email Not Verified"></i> Not Verified&nbsp;<a id="verify-email" class="btn btn-sm btn-primary" title="Verify Email" data-id="'.$_SESSION['account'].'">Verify</a>';
					$width = '45%';
					$readonly_email = null;
					if($db->get_var("SELECT email_status FROM `account-request` WHERE id=".$_SESSION['account'])=='verify'){
						$email_status = '<i class="fa fa-check-circle" aria-hidden="true" style="font-size:20px; color:#5cb85c;" title="Email Verified"></i> Verified';
						$width='25%';
						$readonly_email = 'readonly';
					}
				?>							

				<div class="row">
					<div class="form-group col-sm-6">
						<label>Email</label>
						<table style="width: 100%"><tr><td>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row->email;?>" required <?php echo $readonly_email;?>>
							</td>
							<td style="width:<?php echo $width;?>">&nbsp;
							<?php echo $email_status;?>
							</td>
							</tr>
						</table>
					</div>
					<div class="form-group col-sm-6">
						<label>Phone</label>
						<input class="form-control" placeholder="Phone" id="phone" name="phone" value="<?php echo $row->phone;?>" <?php echo $readonly_personal;?>>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Country</label>
						<select class="form-control" id="country" name="country" disabled>
                <?php
									require_once("../conn/mt4-config.php");
									$sql="SELECT * FROM `countries`";
									$results = $db->get_results($sql);
									if(!empty($results)){
										
										foreach ( $results as $row2 ) {
											$sel=null;
											if($row2->countryCode==$row->countryCode){
												$sel='selected="selected"';
											}
											echo '<option value="'.$row2->countryCode.'" '.$sel.'>'.$row2->countryName.'</option>';
										}
									}
								?>
                </select>
					</div>
					<div class="form-group col-sm-6">
						<label>Nationality</label>
						<select class="form-control" id="nationality" name="nationality">
								<?php
									require_once("../conn/mt4-config.php"); 
									$sql="SELECT * FROM `nationality`;";
									$results = $db->get_results($sql);
									if(!empty($results)){
										foreach ( $results as $row3 ) {
											$sel=null;
											if($row3->nationalityid==$row->nationalityid){
												$sel='selected="selected"';
											}
											echo '<option value="'.$row3->nationalityid.'" '.$sel.'>'.$row3->nationality.'</option>';
										}
									}
								?>
             </select>
					</div>
				</div>	
				
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
				<script>
                $('#files').fileupload({
                    add: function (e, data) {
                        var jqXHR = data.submit()
                            .success(function (result, textStatus, jqXHR) {alert('Uploaded!');})
                            .error(function (jqXHR, textStatus, errorThrown) {alert(textStatus);})
                            .complete(function (result, textStatus, jqXHR) {/* ... */});
                    }
                    });
                </script>    
				<br>
				</div>
			<div class="form-group col-sm-6">
				<label>My Uploaded Documents</label><br>
				<div style="border:1px solid #ddd; padding: 10px;">
					<div class="row">
					<?php
            //$dir = dirname(realpath(__FILE__)).'/uploads/'.$_SESSION['account'].'/thumbnail/';
            $dir = './uploads/'.$_SESSION['account'].'/thumbnail/';
            //echo $dir;
						if(is_dir($dir)){
							$handle = opendir($dir);
							while($file = readdir($handle)){
								if($file !== '.' && $file !== '..'){
									echo '<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom:10px;">';
									echo '<a class="id-card" href="./uploads/'.$_SESSION['account'].'/'.$file.'" data-fancybox-group="gallery"><img src="./uploads/'.$_SESSION['account'].'/thumbnail/'.$file.'" /></a>';
									echo '</div>';
								}
							}
						}
					?>
					</div>
				</div>
			</div>
			</div>
				
				<br>
				<h3>Personal Info</h3>
				<hr>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>National ID No./Passport No.</label>
						<input class="form-control" id="idcard" name="idcard" placeholder="National ID No./Passport No." value="<?php echo $row->idcard;?>" required <?php echo $readonly_personal;?>>
					</div>
					<div class="form-group col-sm-6">
						<label>Date of Birth (dd - mm - yyyy)</label>
						<table>
							<tr>
								<td>
									<input type="number" min="1" max="31" step="1" class="form-control" id="dd" name="dd" placeholder="dd" value="<?php echo $dd;?>" pattern="[0-9]{2}" onkeyup = "validateNumber(this);" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter 2 digits number' : '');" <?php echo $readonly_personal;?>>
								</td>
								
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
								
								<td>
									<input type="number" min="1" max="12" step="1" class="form-control" id="mm" name="mm" placeholder="mm" value="<?php echo $mm;?>" pattern="[0-9]{2}" onkeyup = "validateNumber(this);" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter 2 digits number' : '');" <?php echo $readonly_personal;?>>
								</td>
								
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
								
								<td>
								<input type="number" min="<?php echo date("Y")-100;?>" max="<?php echo date("Y")-18;?>" step="1" class="form-control" placeholder="yyyy" value="<?php echo $yyyy;?>" id="yyyy" name="yyyy" pattern="[0-9]{4}" onkeyup = "validateNumber(this); this.setCustomValidity(validity.valueMissing ? 'Please enter year of birth' : '');" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter 4 digits number' : '');" required <?php echo $readonly_personal;?>>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Street Address</label>
						<input class="form-control" id="street" name="street" placeholder="Street" value="<?php echo $row->street;?>" required <?php echo $readonly_personal;?>>
					</div>
					<div class="form-group col-sm-6">
						<label>City</label>
						<input class="form-control" id="city" name="city" placeholder="City" value="<?php echo $row->city;?>" required <?php echo $readonly_personal;?>>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>State</label>
						<input class="form-control" id="state" name="state" placeholder="State" value="<?php echo $row->state;?>" <?php echo $readonly_personal;?>>
					</div>
					<div class="form-group col-sm-6">
						<label>Zip-code</label>
						<input class="form-control" id="zip" name="zip" placeholder="Zip-code" value="<?php echo $row->zip;?>" required <?php echo $readonly_personal;?>>
					</div>
				</div>
				<br>
				<h3>Bank Info</h3>
				<hr>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Bank Name</label>
						<input class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php echo $row->bank_name;?>">
					</div>
					<div class="form-group col-sm-6">
						<label>Bank Country</label>
						<select class="form-control" id="bank_country" name="bank_country">
							<?php
								require_once("../conn/mt4-config.php");  
								$sql="SELECT * FROM `countries`";
								$results = $db->get_results($sql);
								if(!empty($results)){
									foreach ( $results as $row4 ) {
										$sel=null;
										if($row4->countryCode==$row->bank_country){
											$sel='selected="selected"';
										}
										echo '<option value="'.$row4->countryCode.'" '.$sel.'>'.$row4->countryName.'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Bank Address</label>
						<input class="form-control" id="bank_address" name="bank_address" placeholder="Bank Address" value="<?php echo $row->bank_address;?>">
					</div>
					<div class="form-group col-sm-3">
						<label>Swift Code</label>
						<input class="form-control" id="bank_swift" name="bank_swift" placeholder="Swift Code" value="<?php echo $row->bank_swift;?>">
					</div>
					<div class="form-group col-sm-3">
						<label>Account Currency</label>
						<input class="form-control" id="bank_currency" name="bank_currency" placeholder="USD" value="<?php echo $row->bank_currency;?>">
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Account Name (Full Name)</label>
						<input class="form-control" id="bank_account_name" name="bank_account_name" placeholder="Bank Account Name" value="<?php echo $row->bank_account_name;?>">
					</div>
					<div class="form-group col-sm-6">
						<label>Account Number</label>
						<input class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Bank Account Number" value="<?php echo $row->bank_account_no;?>">
					</div>
				</div>
				<hr>
				<input type="hidden" name="id" id="id" value="<?php echo $row->id;?>">
				<input type="hidden" name="submit" id="submit" value="1">	
				<input type="submit" class="btn btn-primary" value="Update">		
			</form>
		</div>
</div>
<!-- /.row -->
<?php }; 
include("./foot.php");?>
<script>document.write("<script type='text/javascript' src='./my-profile.js?v=" + Date.now() + "'><\/script>");</script>
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