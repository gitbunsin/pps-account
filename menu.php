<?php	
function setActive($menu=null){
	$page_name = strtolower(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']));
	if(substr($page_name,0,-4)==strtolower($menu) || ($menu==null && $page_name=='admin')){
		return 'class="active"';
	}else{
		return null;
	}
}
$status = 'Not Verified';
if($db->get_var("SELECT status FROM `account-request` WHERE id=".$_SESSION['account'])=='verify'){
	$status = 'Verified';
}
?>
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li <?php echo setActive();?>>
            <a href="./"><i class="fa fa-fw fa-dashboard"></i> Dashboard </a>
        </li>
        <li <?php echo setActive('my-profile');?>>
            <a href="./my-profile.php"><i class="fa fa-fw fa-user"></i> My Profile <span class="badge badge-light"><?php echo $status;?></span></a>
        </li>
        <li <?php echo setActive('security');?>>
            <a href="./security.php"><i class="fa fa-fw fa-lock"></i> Account Security</a>
        </li>
        <li <?php echo setActive('my-account');?>>
        	<a href="./my-account.php"><img src="./images/icons/mt4.png" /> My Accounts <span class="badge badge-primary"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-detail` WHERE id=".$_SESSION['account']);?></span></a>
          </li>
	        <li>
	        <a href="#" data-toggle="collapse" data-target="#open-account">
	        <i class="fa fa-users"></i> Open Account <i class="fa fa-fw fa-caret-down"></i>
          </a>
          <ul id="open-account" class="collapse" style="background-color: #333;">
						<li style="border-bottom: 1px solid #666;">
							<a href="https://www.pps-forex.com/open-account?ib=<?php echo $acc_ibcode;?>" target="_blank">Forex Account</a>
						</li>
						<li style="border-bottom: 1px solid #666;">
							<a href="https://www.pps-forex.com/open-account?type=ib&ib=<?php echo $acc_ibcode;?>" target="_blank">IB Account</a>
						</li>
						<li style="border-bottom: 1px solid #666;">
							<a href="#">Local Stock</a>
						</li>
						<li style="border-bottom: 1px solid #666;">
              <a href="#">Global Stock</a>
						</li>
					</ul>
	</li>
<?php
$hide_deposit = null;
$hide_withdraw = null;
$hide_transfer = null;
$hide_commission = 'display:none;';	
$hide_organization = 'display:none;';	
	if($acc_type=='ib'){
		$hide_commission = null;
		$hide_organization = null;
	}
?>			
<li <?php echo setActive('payment');?>>
        	<a href="#" data-toggle="collapse" data-target="#payment"><i class="fa fa-fw fa-dollar"></i> My Payment <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="payment" class="collapse" style="background-color: #333;">
						<li style="border-bottom: 1px solid #666; <?php echo $hide_commission;?>">
							<a href="#">Commission</a>
						</li>
						<li style="border-bottom: 1px solid #666; <?php echo $hide_deposit;?>">
							<a href="./payment-report.php?type=deposit">Deposit <span class="badge badge-primary"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-payment` WHERE type IN('deposit') AND request_by=".$_SESSION['account']);?></span></a>
						</li>
						<li style="border-bottom: 1px solid #666; <?php echo $hide_withdraw;?>">
							<a href="./payment-report.php?type=withdraw">Withdraw <span class="badge badge-primary"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-payment` WHERE type IN('withdraw') AND request_by=".$_SESSION['account']);?></span></a>
						</li>
						<li style="border-bottom: 1px solid #666; <?php echo $hide_transfer;?>">
							<a href="./payment-report.php?type=transfer">Transfer <span class="badge badge-primary"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-payment` WHERE type IN('transfer') AND request_by=".$_SESSION['account']);?></span></a>
						</li>
					</ul>
        </li>
        
        <li <?php echo setActive('organization');?> style="<?php echo $hide_organization;?>">
        	<a href="./organization.php" data-toggle="collapse" data-target="#organization"><i class="fa fa-fw fa-sitemap"></i> Organization <span class="badge badge-primary" title="Pending Aprroval"><?php echo $db->get_var("SELECT COUNT(*) FROM `account-request` WHERE status ='not verify' AND upline='".$acc_ibcode."';");?></span></a>
        </li>
				
        <li <?php echo setActive('invite');?>>
            <a href="invite.php"><i class="fa fa-fw fa-users"></i> Invite People</a>
        </li>
    </ul>
</div>
