<?php


/* display helper */
function display_raw_SQL_data($data) {
	?>
	<!-- raw SQL table display -->
	<div class="container">
		<div class="row">&nbsp;</div>
		<table class="table table-bordered table-striped table-hover">
			<tr>
				<?php
				foreach ($data[0] as $key => $value) {
					?>
					<th><?= $key ?></th>
					<?php
				}
				?>
			</tr>
			<?php
			foreach ( $data as $row ) {
				?>
				<tr>
					<?php
					foreach ($row as $value) {
						?>
						<td><?= $value ?></td>
						<?php
					}
					?>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
	<?php
}



/* date functions */
function format_datetime($datetime) {
	if(isset($datetime)) {
		if(!is_object($datetime))
			$datetime = new DateTime($datetime);
		$datetime = $datetime->format('Y-m-d H:i');
	}
	return $datetime;
}

function format_time($datetime) {
	if(isset($datetime)) {
		$datetime = new DateTime($datetime);
		$datetime = $datetime->format('H:i');
	}
	return $datetime;
}

function format_date($datetime) {
	if(!empty($datetime)) {
		$datetime = new DateTime($datetime);
		$datetime = $datetime->format('Y-m-d');
	}
	return $datetime;
}

function format_interval($interval) {
	if(isset($interval)) {
		$interval = $interval->format('%r %H:%I');
	}
	return $interval;
}

function calculate_interval ( $time1, $time2 ) {
	if(isset($time1) && isset($time2)) {
		$time1 = new DateTime('01-01-01 '. $time1);
		$time2 = new DateTime('01-01-01 '. $time2);
		$diff = $time2->diff($time1);
		return $diff;
	}
	else {
		return NULL;
	}
}

function create_DateInterval_from_time_string($time) {
	$time = explode(':', $time);
	$interval = new DateInterval('PT'.$time[0].'H'.$time[1].'M'.$time[2].'S');
	return $interval;
}

function add_intervals($int1, $int2) {
	$d1 = new DateTime();
	$d2 = new DateTime();
	$d2->add(new DateInterval('PT'.$timespan.'S'));
	 
	$iv = $d2->diff($d1);	
}


function make_array_group ( $data, $column ) {
	$res = [];
	foreach ( $data as $row ) {
		$group = $row [ $column ];
		unset ( $row [ $column ] );
		$res [ $group ] [] = $row;
	}
	return $res;
}


function make_array_groups ( $data, $columns ) {
	if ( empty($columns) ) {
		return $data;
	}
	
	$column = array_shift ( $columns );
	$res = [];
	foreach ( $data as $row ) {
		$group = $row [ $column ];
		unset ( $row [ $column ] );
		if (!empty($columns)) {
			$res [ $group ] [] = $row;
		}
		else { // last group uniq, no need of array
			$res [ $group ] = $row;
		}
	}
	
	foreach ($res as &$group) {
		$group = make_array_groups ( $group, $columns );
	}
	return $res;
}


function count_recursive ($array, $limit) {
	$count = 0;
	foreach ($array as $id => $_array) {
		if (is_array ($_array) && $limit > 0) {
			$count += count_recursive ($_array, $limit - 1);
		} else {
			$count += 1;
		}
	}
	return $count;
} 