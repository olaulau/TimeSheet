<?php
require_once __DIR__ . '/../ALL.inc.php';


/*  get all time sheets by day with stats  */
$dbh = DB::get();
$sql = '
	SELECT WEEK(start) AS week, DATE(start) AS day, SEC_TO_TIME(SUM(TIME_TO_SEC( TIMEDIFF(stop, start) ))) AS duration
	FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . '
	GROUP BY week, day DESC WITH ROLLUP
	-- ORDER BY day DESC';
//echo "<pre> $sql </pre>";
$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
$tab = $st->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($tab);
// echo "</pre>";
// die;

// display_raw_SQL_data($tab);
?>

<?php
require_once '../includes/head.inc.php';
?>

<?php
require_once '../includes/header.inc.php';
?>
<script type="text/javascript">
	$( document ).ready(function() {
		$("#stats-tab").addClass("active");
	});
</script>

	<div class="container">
	
		<div class="row">&nbsp;</div>

		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th>week</th>
				<th>day</th>
				<th>duration</th>
				<th>additional hour</th>
			</tr>
		  	<?php
		  	$total_additional_hours = new DateTime('@0');
			foreach ( $tab as $row ) {
				if(isset($row['day'])) { // complete row
					$diff = calculate_interval($row['duration'], $conf['daily_work_time']);
					$total_additional_hours->add($diff);
					?>
					<tr>
						<td><?= $row['week'] ?></td>
						<td><?= format_date($row['day']) ?></td>
						<td><?= format_interval(create_DateInterval_from_time_string($row['duration'])) ?></td>
						<td><?= format_interval($diff) ?></td>
					</tr>
					<?php
				}
				else {
					if(isset($row['week'])) { // week total
						$zero = new DateTime('@0');
						$total_additional_hours = $zero->diff($total_additional_hours);
					}
					else { // whole total
						$total_additional_hours = NULL;
					}
					
					?>
					<tr>
						<th><?= $row['week'] ?></th>
						<th> TOTAL </th>
						<th><?= format_interval(create_DateInterval_from_time_string($row['duration'])) ?></th>
						<th><?= format_interval($total_additional_hours) ?></th>
					</tr>
					<?php
					$total_additional_hours = new DateTime('@0'); //TODO : total only by week for now
				}
			}
			?>
		</table>

	</div>
	<!-- /.container -->

<?php
require_once '../includes/footer.inc.php';
?>

<?php
require_once '../includes/foot.inc.php';
?>
