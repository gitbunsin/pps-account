<!--
<style>
#_chart-container {
  position: relative;
  display: inline-block;
  top: 10px;
  left: 10px;
  height: 420px;
  width: calc(100% - 24px);
  border: 2px dashed #aaa;
  border-radius: 5px;
  overflow: auto;
  text-align: center;
}
</style>
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Organization Chart</title>
  <link rel="stylesheet" href="components/OrgChart-master/demo/css/font-awesome.min.css">
  <link rel="stylesheet" href="components/OrgChart-master/demo/css/jquery.orgchart.css">
  <link rel="stylesheet" href="components/OrgChart-master/demo/css/_style.css">
  <style type="text/css">
    .orgchart { background: #fff; }
    .orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
    .orgchart td>.down { background-color: #aaa; }
    .orgchart .pps .title { background-color: #009933; }
    .orgchart .pps .content { border-color: #009933; }
    .orgchart .bm .title { background-color: #006699; }
    .orgchart .bm .content { border-color: #006699; }
    .orgchart .sim .title { background-color: #993366; }
    .orgchart .sim .content { border-color: #993366; }
    .orgchart .im .title { background-color: #996633; }
    .orgchart .im .content { border-color: #996633; }
    .orgchart .ib .title { background-color: #cc0066; }
    .orgchart .ib .content { border-color: #cc0066; }
		
		.orgchart .second-menu-icon {
      transition: opacity .5s;
      opacity: 0;
      right: -5px;
      top: -5px;
      z-index: 2;
      color: rgba(68, 157, 68, 0.5);
      font-size: 18px;
      position: absolute;
    }
    .orgchart .second-menu-icon:hover { color: #449d44; }
    .orgchart .node:hover .second-menu-icon { opacity: 1; }
    .orgchart .node .second-menu {
      display: none;
      position: absolute;
      top: 0;
      right: -70px;
      border-radius: 35px;
      box-shadow: 0 0 10px 1px #999;
      background-color: #fff;
      z-index: 1;
    }
    .orgchart .node .second-menu .avatar {
      width: 60px;
      height: 60px;
      border-radius: 30px;
      float: left;
      margin: 5px;
    }
  </style>
</head>
<body>  
<?php
include_once("./conn/mt4-config.php");
$from = date('Y-m-01 00:00:00');
$to = date('Y-m-d 00:00:00');
	
function getDownline($Upline_IBCode,$from,$to){
	//include("./conn/mt4-config.php");
	global $db;
	$sql="SELECT u.*,
				(SELECT COUNT(*) FROM `user` WHERE upline IN(u.ibcode)) AS downline,
				(SELECT position FROM `position` WHERE positionid = u.positionid) AS position,
				(SELECT COUNT(*) FROM `account-relation` WHERE upline = u.ibcode) AS account,
				(SELECT GROUP_CONCAT(login ORDER BY login SEPARATOR ',') FROM `account-relation` WHERE upline=u.ibcode) AS login,
				(SELECT FORMAT(sum(volume),2) FROM `report` WHERE login IN(SELECT login FROM `account-relation` WHERE upline=u.ibcode) AND type IN('buy','sell') AND (close_time BETWEEN '".$from."' AND now())) AS lot
				FROM `user` AS u 
				WHERE u.upline IN('".$Upline_IBCode."') AND u.status='on';";
	$results = $db->get_results($sql);
	$user = null;
	if(!empty($results)){
		foreach ( $results as $ib ) {
			$override = 0;
			if($ib->account>0){
				$override = getOverriding($ib->ibcode,$ib->login,$from,$to);
			}
			$user.= "{";
			$user.="'name': '".$ib->name."', 
							'title': '".strtoupper($ib->position)."',
							'ibcode': '".$ib->ibcode."',
							'commission': '".getCommission($ib->ibcode,$from,$to)."',
							'override': '".$override."',
							'content': 'A/C: <strong>".$ib->account."</strong> | Lot: <strong>".$ib->lot."</strong>',
							'className': '".$ib->position."', ";
			if($ib->downline>0){
				//$user = substr($subib, 0, -2);
				$user.= "'children': [ ";
				$user.= getDownline($ib->ibcode,$from,$to);
				$user.= "]";
			}
			$user.= "}, ";
		}
	}
	return $user = substr($user, 0, -2);//Remove last comma (,)
}

//PPS	
$total_lot = $db->get_var("SELECT FORMAT(sum(volume),2) FROM `report` WHERE type IN('buy','sell') AND (close_time BETWEEN '".$from."' AND now());");
$rebate = $db->get_var("SELECT DISTINCT rebate FROM `commission` WHERE positionid IN(1) AND groupid IN(3,4);");
$total_account = $db->get_var("SELECT COUNT(*) FROM `account`");
$total_comission =  0.0;//number_format($total_lot*$rebate,2);
	
function getCommission($upline,$from,$to){
	//include("./conn/mt4-config.php");	
	global $db;
	$sql="SELECT a.login, a.name, a.phone, a.email, a.group,
				(SELECT balance FROM `history` WHERE login=a.login ORDER BY time DESC LIMIT 1) AS balance,
				(SELECT equity FROM `history` WHERE login=a.login ORDER BY time DESC LIMIT 1) AS equity,
				(SELECT FORMAT(sum(volume),2) AS lot FROM `report` WHERE type IN('buy','sell') AND login=a.login AND (close_time BETWEEN '".$from."' AND now())) AS lot,
				(SELECT rebate FROM `commission` WHERE positionid IN(SELECT positionid FROM `user` WHERE ibcode='".$upline."') 
				AND groupid IN(SELECT groupid FROM `group` WHERE groupname=a.group)
				) AS rebate,
				FORMAT(SUM((SELECT sum(volume) FROM `report` WHERE type IN('buy','sell') AND login=a.login AND (close_time BETWEEN '".$from."' AND now()))*(SELECT rebate FROM `commission` WHERE positionid IN(SELECT positionid FROM `user` WHERE ibcode='".$upline."') 
				AND groupid IN(SELECT groupid FROM `group` WHERE groupname=a.group)
				)),2) AS commission
				FROM `account` AS a
				WHERE a.login IN(SELECT login FROM `account-relation` WHERE upline IN('".$upline."'));";
	
	//$mt4 = $db->get_results($sql);
	if(!empty($mt4)){
		foreach ( $mt4 as $row ) {
			//return $row->commission;
		}
	}
	return 0;
}

function getOverriding($upline,$login,$from,$to){
	//include("./conn/mt4-config.php");	
	global $db;
	$override=0; $lot=0; $commission=0;
	$login_array = explode (",", $login);
	foreach ($login_array as $key => $value){
		//$lot = $db->get_var("SELECT FORMAT(SUM(volume),2) FROM `report` WHERE login IN(".$value.") AND type IN('buy','sell');");
		
		//$override = $db->get_var("SELECT override FROM `commission` WHERE positionid IN(SELECT positionid FROM `user` WHERE ibcode='".$upline."') AND groupid IN(SELECT groupid FROM `group` WHERE groupname=(SELECT `group` FROM `account` WHERE login=".$value."));");
		
		$commission += $lot * $override; 
	}
	
	//return($commission);
	return 0;
}
//echo getOveriding('PP00020','71111168,74537220,74633891');	
//echo getCommission('PP00021');	
//$filter = 'u.ibcode = "PP00007"';
$sql="SELECT u.*,
			(SELECT COUNT(*) FROM `user` WHERE upline IN(u.ibcode)) AS downline,
			(SELECT COUNT(*) FROM `user` WHERE ibcode = u.ibcode) AS team,
			(SELECT COUNT(*) FROM `account-relation` WHERE upline = u.ibcode) AS account,
			(SELECT GROUP_CONCAT(login ORDER BY login SEPARATOR ',') FROM `account-relation` WHERE upline=u.ibcode) AS login,
			(SELECT position FROM `position` WHERE positionid = u.positionid) AS position,
			(SELECT FORMAT(sum(volume),2) FROM `report` WHERE login IN(SELECT login FROM `account-relation` WHERE upline = u.ibcode) AND type IN('buy','sell') AND (close_time BETWEEN '".$from."' AND now())) AS lot
			FROM `user` AS u 
			WHERE u.positionid IN(".$_SESSION['positionid'].") AND u.ibcode IN('".$_SESSION['ibcode']."') AND u.status='on'
			ORDER BY u.positionid ASC;";
//echo $sql;
$mt4 = $db->get_results($sql);
if(!empty($mt4)){
	$user = null;
	foreach ( $mt4 as $ib ) {
		$account = $ib->account;
		$lot = $ib->lot;
		$comission = getCommission($ib->ibcode,$from,$to);
		$override =0;
		if($ib->account>0){
			$override = getOverriding($ib->ibcode,$ib->login,$from,$to);
		}
		if($ib->positionid==1){
			$account = $total_account;
			$lot = $total_lot;
			$comission = $total_comission;
		}
		$user.="'name': '".$ib->name."', 
						'title': '".strtoupper($ib->position)."',
						'ibcode': '".$ib->ibcode."',
						'commission': '".$comission."',
						'override': '".$override."',
						'content': 'A/C: <strong>".$account."</strong> | Lot: <strong>".$lot."</strong>',
						'className': '".$ib->position."'";
		if($ib->downline>0){
			$user.= PHP_EOL . ", 'children': [ ";
			$user.= PHP_EOL . "".getDownline($ib->ibcode,$from,$to);
			$user.= PHP_EOL . "]";
		}
	}
	//echo $user;
}
$verticalLevel = 5;
$visibleLevel = 5;

$deposit = $db->get_var("SELECT SUM(profit) FROM `report` WHERE LOCATE('Dep',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`);");
$withdraw	= $db->get_var("SELECT SUM(profit) FROM `report` WHERE LOCATE('With',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`);");
$profit_loss = $db->get_var("SELECT SUM(profit) FROM `report` WHERE type IN('buy','sell') AND close_time<>'' AND login IN(SELECT login FROM `account-relation`);");
	
$last_balance = $db->get_var("SELECT FORMAT(SUM(r.profit),2) AS Last_Balance 
FROM `report` AS r INNER JOIN `account-relation` AS a ON a.login = r.login
WHERE r.type IN('balance') AND r.login IN(SELECT login FROM `account-relation`);");
	
$monthly_deposit = $db->get_var("SELECT SUM(profit) AS Monthly_Deposit
FROM `report`
WHERE LOCATE('Dep',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`) AND (open_time BETWEEN '".$from."' AND NOW());");
	
$monthly_widthdraw = $db->get_var("SELECT SUM(profit) AS Monthly_Withdraw
FROM `report`
WHERE LOCATE('Width',symbol) AND type IN('balance') AND login IN(SELECT login FROM `account-relation`) AND (open_time BETWEEN '".$from."' AND NOW());");
$net_deposit = ($monthly_deposit - $monthly_widthdraw);

$monthly_pl = $db->get_var("SELECT FORMAT(SUM(profit),2) FROM `report` WHERE type IN('buy','sell') AND (close_time BETWEEN '".$from."' AND NOW()) AND login IN(SELECT login FROM `account-relation`);");	

$equity = ($deposit + $profit_loss);

$account = $db->get_var("SELECT COUNT(DISTINCT login) AS Monthly_Open
FROM `report` 
WHERE login IN(SELECT login FROM `account-relation`) AND type='balance' AND open_time BETWEEN '".$from."' AND NOW();
");
?>
 <table class="table">
 	<tr>
 		<th>Type</th>
 		<th>Monthly Lot</th>
 		<th>Last Equity</th>
 		<th>Unrealized P/L</th>
 		<th>Last Balance</th>
 		<th>Daily Net Deposit</th>
 		<th>Net Deposit</th>
 		<th>Monthly P/L</th>
 		<th>Total Accounts</th>
 	</tr>
 	<tr>
 		<tbody>
 			<td><strong>Normal</strong></td>
 			<td><?php echo $total_lot;?></td>
 			<td><?php echo number_format($equity,2);?></td>
 			<td><?php echo number_format($profit_loss,2);?></td>
 			<td><?php echo ($last_balance);?></td>
 			<td><?php echo number_format(($monthly_deposit/24),2);?></td>
 			<td><?php echo number_format($net_deposit,2);?></td>
 			<td><?php echo $monthly_pl;?></td>
 			<td><?php echo $account;?></td>
 		</tbody>
 	</tr>
 	 	<tr>
 		<tbody>
 			<td><strong>Dynasty</strong></td>
 			<td>0.00</td>
 			<td>0.00</td>
 			<td>0.00</td>
 			<td>0.00</td>
 			<td>0.00</td>
 			<td>0.00</td>
 			<td>0.00</td>
 		</tbody>
 	</tr>
 </table>
  <div id="chart-container"></div>
     
  <script type="text/javascript" src="./components/OrgChart-master/demo/js/jquery.min.js"></script>
  <script type="text/javascript" src="./components/OrgChart-master/demo/js/jquery.orgchart.js"></script>
  <script type="text/javascript">
		
    $(function() {
			
		var datasource = {<?php echo $user;?>}
    var nodeTemplate = function(data) {
      return `
        <div class="id" style="padding-bottom:3px;"><span class="label label-primary">${data.title}</span>: <span style="font-size:12px;">${data.ibcode}</span></div>
        <div class="title">${data.name}</div>
        <div class="content" style="font-size:12px;">${data.content}</div>
				<div style="padding-top:3px;"><span class="badge"><span style="font-weight:normal;">$</span>${data.commission} | <span style="font-weight:normal;">$</span>${data.override}</span></div>
      `;
    };

    var oc = $('#chart-container').orgchart({
		//$('#chart-container').orgchart({
      'data' : datasource,
			'nodeContent': 'content',
			'nodeID': 'ibcode',
			'parentNodeSymbol':'fa-sitemap',
			'nodeTemplate': nodeTemplate,
			'verticalLevel': <?php echo $verticalLevel;?>,
      'visibleLevel': <?php echo $visibleLevel;?>,
			'toggleSiblingsResp': true,
			//'pan':true,
			//'zoom':true,
			//'exportButton': true,
    	//'exportFilename': 'MyOrgChart',
			
			'createNode': function($node, data) {
				//$node.on('click', function() {
					//alert('hi'+data.ibcode);
					//window.open('./account.php?ibcode='+data.ibcode);
				//});
        var secondMenuIcon = $('<i>', {
          'class': 'fa fa-info-circle second-menu-icon',
          click: function() {
            //$(this).siblings('.second-menu').toggle();
						window.open('./account.php?ibcode='+data.ibcode);
          }
        });
        var secondMenu = '<div class="second-menu"><img class="avatar" src="img/avatar/' + data.ibcode + '.jpg"></div>';
        $node.append(secondMenuIcon).append(secondMenu);
      },
    });
  });

  </script>
    </body>
</html>