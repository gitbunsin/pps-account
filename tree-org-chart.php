<link rel="stylesheet" href="./components/multi-level-accordion-menu-master/css/reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="./components/multi-level-accordion-menu-master/css/style.css"> <!-- Resource style -->
<script src="./components/multi-level-accordion-menu-master/js/modernizr.js"></script> <!-- Modernizr -->
<!-- Flot Charts -->
		<ul class="cd-accordion-menu animated" style="width:100%!important;">
			<li class="has-children">
			<?php
				require_once("./conn/mt4-config.php");
				$sql="SELECT ib.name, ib.ibcode,
							(SELECT COUNT(*) FROM `broker` WHERE ibcode = ib.ibcode) AS team,
							(SELECT COUNT(*) FROM `account` WHERE upline = ib.ibcode) AS account,
							(SELECT position FROM `position` WHERE positionid = ib.positionid) AS position
							FROM `broker` AS ib 
							WHERE ib.positionid IN(1)
							ORDER BY ib.positionid ASC;";
				$mt4 = $ib->get_results($sql);
				if(!empty($mt4)){
					foreach ( $mt4 as $ib ) {
						echo '<input type="checkbox" name ="'.$ib->name.'" id="'.$ib->ibcode.'" checked>
									<label for="'.$ib->ibcode.'">'.$ib->name.'</label>';
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
				<ul>
					<li class="has-children">
						<input type="checkbox" name ="sub-group-1" id="sub-group-1">
						<label for="sub-group-1">Sub Group 1</label>
				<ul>
					<li><a href="#0">Image</a></li>
					<li><a href="#0">Image</a></li>
					<li><a href="#0">Image</a></li>
				</ul>
			</li>
		</ul> <!-- cd-accordion-menu -->

	<script src="./components/multi-level-accordion-menu-master/js/main.js"></script> <!-- Resource jQuery -->

	<?php
	function getLower($ibcode){
		include("./conn/mt4-config.php");
		$sql="SELECT ib.name, ib.ibcode,
		(SELECT position FROM `position` WHERE positionid = ib.positionid) AS position
		FROM `broker` AS ib WHERE ib.upline IN('".$ibcode."');";
		$results = $ib->get_results($sql);
		$subib = '<table style="width:100%;">';
		if(!empty($results)){
			foreach ( $results as $ib ) {
					$subib.= '
					<ul>
						<li class="has-children">
							<input type="checkbox" name ="'.$ib->name.'" id="'.$ib->ibcode.'">
							<label for="'.$ib->ibcode.'">'.$ib->name.'</label>
					<ul>';
			}

		}
		return($subib.'</table>');
	}

	?>