<?php
require_once __DIR__ . '/../ALL.inc.php';


/*  get all time sheets by day with stats  */
$dbh = DB::get();
$sql = '
	SELECT
		YEAR(start) AS year,
		MONTH(start) AS month,
		WEEK(start) AS week,
		DATE(start) AS date,
		SEC_TO_TIME( SUM( TIME_TO_SEC( TIMEDIFF( stop, start ) ) ) ) AS duration
	FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . '
	WHERE	stop IS NOT NULL
	GROUP BY year DESC, month DESC, week DESC, date DESC WITH ROLLUP';
//echo "<pre> $sql </pre>";
$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
$data = $st->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($data);
// echo "</pre>";
// die;

// display_raw_SQL_data($data); die;

// compute additional time
foreach ( $data as &$row ) {
	if(!empty($row['date'])) { // day
		$row ['additional_time'] = /* /// */format_interval ( calculate_interval ( $row['duration'], $conf['daily_work_time'] ) );
	}
}
// display_raw_SQL_data($data); die;


// make year - month - week - day groups
$data = make_array_groups ( $data, ['year', 'month', 'week', 'date'] );
// var_dump($data); die;
?>

<?php
require_once __DIR__ . '/../includes/head.inc.php';
?>

<?php
require_once __DIR__ . '/../includes/header.inc.php';
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
				<th>year</th>
				<th>month</th>
				<th>week</th>
				<th>date</th>
				<th>duration</th>
				<th>additional hour</th>
			</tr>
		  	<?php
			foreach ( $data as $year => $months ) {
				if(!empty($year)) {
					?>
					<tr>
						<td colspan="6"><?= $year ?></td>
					</tr>
					<?php
				}
				foreach ( $months as $month => $weeks ) {
					if(!empty($month)) {
						?>
						<tr>
							<td> &nbsp; </td>
							<td colspan="5"><?= $month ?></td>
						</tr>
						<?php
					}
					foreach ( $weeks as $week => $dates ) {
						if(!empty($week)) {
							?>
							<tr>
								<td> &nbsp; </td>
								<td> &nbsp; </td>
								<td colspan="4"><?= $week ?></td>
							</tr>
							<?php
						}
						foreach ( $dates as $date => $timesheet ) {
							if (!empty($date)) {
								?>
								<tr>
									<td> &nbsp; </td>
									<td> &nbsp; </td>
									<td> &nbsp; </td>
									<td><?= format_date($date) ?></td>
									<td><?= format_interval(create_DateInterval_from_time_string($timesheet['duration'])) ?></td>
									<td> &nbsp; </td>
								</tr>
								<?php
							}
							else {
								?>
								<tr>
									<td><?= $year ?></td>
									<td><?= $month ?></td>
									<td><?= $week ?></td>
									<td><?= format_date($date) ?></td>
									<td><?= format_interval(create_DateInterval_from_time_string($timesheet['duration'])) ?></td>
									<td> &nbsp; </td>
								</tr>
								<?php
							}
						}
					}
				}
			}
			?>
		</table>

	</div>
	<!-- /.container -->

<?php
require_once __DIR__ . '/../includes/footer.inc.php';
?>

<?php
require_once __DIR__ . '/../includes/foot.inc.php';
?>
