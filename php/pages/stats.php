<?php
require_once __DIR__ . '/../ALL.inc.php';


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
			foreach ( $tab as $row ) {
				$duration = new DateTime('01-01-01 '. $row['duration']);
				$daily_work_time = new DateTime('01-01-01 '. $conf['daily_work_time']);
				$diff = $daily_work_time->diff($duration);
				$diff = $diff->format('%R %H:%I:%S');
				?>
			<tr>
				<td><?= $row['day'] ?></td>
				<td><?= $row['duration'] ?></td>
				<td><?= $diff ?></td>
			</tr>
				<?php
			}
			?>
			<!-- <tr> <th></th> <th></th> <th></th> <th></th> <th></th> </tr> -->
		</table>

	</div>
	<!-- /.container -->

<?php
require_once '../includes/footer.inc.php';
?>

<?php
require_once '../includes/foot.inc.php';
?>
