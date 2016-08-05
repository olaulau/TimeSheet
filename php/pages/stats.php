<?php
require_once __DIR__ . '/../ALL.inc.php';

use Herrera\DateInterval\DateInterval;


/*  get all time sheets by day with stats  */
$dbh = DB::get();
$sql = '
	SELECT DATE(start) AS day, SEC_TO_TIME(SUM(TIME_TO_SEC( TIMEDIFF(stop, start) ))) AS duration
	FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . '
	GROUP BY day
	ORDER BY day DESC';
//echo "<pre> $sql </pre>";
$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
$tab = $st->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($tab);
// echo "</pre>";
// die;
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
				<th>day</th>
				<th>duration</th>
				<th>additional hour</th>
			</tr>
		  	<?php
		  	$total_additional_hours = new DateTime('@0');
			foreach ( $tab as $row ) {
				$diff = calculate_interval($row['duration'], $conf['daily_work_time']);
				$total_additional_hours->add($diff);
				
				?>
			<tr>
				<td><?= format_date($row['day']) ?></td>
				<td><?= format_time($row['duration']) ?></td>
				<td><?= format_interval($diff) ?></td>
			</tr>
				<?php
			}
			$zero = new DateTime('@0');
			$total_additional_hours = $zero->diff($total_additional_hours);
			?>
			<tr> <th> TOTAL </th> <th> </th> <th><?= format_interval($total_additional_hours) ?></th> </tr>
		</table>

	</div>
	<!-- /.container -->

<?php
require_once '../includes/footer.inc.php';
?>

<?php
require_once '../includes/foot.inc.php';
?>
