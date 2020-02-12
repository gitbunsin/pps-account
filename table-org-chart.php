<link href="./css/datatables.min.css" rel="stylesheet">
<script src="./js/datatables.min.js"></script>
<!-- Flot Charts -->
<br>
<button id="btn-show-all-children" type="button">Expand All</button>
<button id="btn-hide-all-children" type="button">Collapse All</button>
<hr>
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>IB Code</th>
            <th>Member</th>
            <th>Account</th>
            <th class="none"></th>
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
		function getLower($ibcode){
			include("./conn/mt4-config.php");
			$sql="SELECT ib.name, ib.ibcode,
			(SELECT position FROM `position` WHERE positionid = ib.positionid) AS position
			FROM `user` AS ib WHERE ib.upline IN('".$ibcode."');";
			$results = $ib->get_results($sql);
			$subib = '<table style="width:100%;">';
			if(!empty($results)){
				foreach ( $results as $ib ) {
						$subib.= '
						<tr>
							<td>'.$ib->name.'</td>
							<td>'.strtoupper($ib->position).'</td>
							<td>'.$ib->ibcode.'</td>
						</tr>';
				}
								 
			}
			return($subib.'</table>');
		}
		
		require_once("./conn/mt4-config.php");
		$sql="SELECT ib.name, ib.ibcode,
					(SELECT COUNT(*) FROM `user` WHERE ibcode = ib.ibcode) AS team,
					(SELECT COUNT(*) FROM `account-relation` WHERE upline = ib.ibcode) AS account,
					(SELECT position FROM `position` WHERE positionid = ib.positionid) AS position
					FROM `user` AS ib 
					WHERE ib.positionid IN(1)
					ORDER BY ib.positionid ASC;";
		$mt4 = $ib->get_results($sql);
		if(!empty($mt4)){
			foreach ( $mt4 as $ib ) {
				echo '
				 <tr>
            <td>'.$ib->name.'</td>
            <td>'.strtoupper($ib->position).'</td>
            <td>'.$ib->ibcode.'</td>
						<td>'.$ib->team.'</td>
						<td>'.$ib->account.'</td>
            <td colspan="5">'.getLower($ib->ibcode).'</td>
        </tr>';
			}
		}
		?>
    </tbody>
</table>

<!-- /.row -->
<script>
$(document).ready(function (){
    var table = $('#example').DataTable({
        'responsive': true
    });

    // Handle click on "Expand All" button
    $('#btn-show-all-children').on('click', function(){
        // Expand row details
        table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
    });

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function(){
        // Collapse row details
        table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
    });
});
</script>