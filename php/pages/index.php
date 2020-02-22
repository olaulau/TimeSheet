<?php
require_once __DIR__ . '/../ALL.inc.php';


/*  get all time sheets from the most recent  */
$dbh = DB::get();
$sql = '
	SELECT id, start, stop, comment, ( TIMEDIFF(stop, start) ) AS duration
	FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . '
	ORDER BY start DESC, id DESC';
//echo "<pre> $sql </pre>";
$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
$st->setFetchMode(PDO::FETCH_CLASS, 'TimeSheet');
$tss = $st->fetchAll(PDO::FETCH_CLASS, 'TimeSheet');

$last_timesheet = TimeSheet::get_last();
?>

<?php
require_once __DIR__ . '/../includes/head.inc.php';
?>

<?php
require_once __DIR__ . '/../includes/header.inc.php';
?>
<script type="text/javascript">
	$( document ).ready(function() {
		$("#home-tab").addClass("active");
	});
</script>

	<div class="container">

		<div class="starter-template">
			<h1>Timesheet</h1>
			<p class="lead">timesheet description</p>
		</div>
		
		<form action="../actions/start-stop.action.php" method="post">
			<div class="row">
				<div class="container col-md-6 col-xs-12">
					<button type="submit" class="btn btn-lg btn-success col-md-12 col-xs-12 <?= TimeSheet::can_start() ? '' : 'disabled' ?> ">
						<h1>Start</h1>
					</button>
				</div>
				<div class="container col-md-6 col-xs-12">
					<button type="submit" class="btn btn-lg btn-danger col-md-12 col-xs-12 <?= TimeSheet::can_stop()  ? '' : 'disabled' ?> ">
						<h1>Stop</h1>
					</button>
				</div>
			</div>
			
			<div class="row">
				<input type="hidden" name="action" id="action" value="<?= TimeSheet::can_start() ? 'start' : 'stop' ?>" />
				<br/>
				<div class="col-md-4"></div><div class="col-md-4"><label for="comment">comment :</label> <input type="text" name="comment" id="comment" value="<?= isset($last_timesheet) ? $last_timesheet->get_comment() : '' ?>" /></div><div class="col-md-4"></div>
			</div>
		</form>
		
		
		<div class="row">&nbsp;</div>

		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th>id</th>
				<th>start</th>
				<th>stop</th>
				<th>comment</th>
				<th>duration</th>
				<th>&nbsp;</th>
			</tr>
		  	<?php
			foreach ( $tss as $ts ) {
				?>
			<tr>
				<td><?= $ts->get_id() ?></td>
				<td><?= format_datetime($ts->get_start()) ?></td>
				<td><?= format_datetime($ts->get_stop()) ?></td>
				<td><?= $ts->get_comment() ?></td>
				<td><?= format_time($ts->duration) ?></td>
				<td>
					<a href="../pages/edit.php?id=<?= $ts->get_id() ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					<a href="../actions/delete.action.php?id=<?= $ts->get_id() ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
				</td>
			</tr>
				<?php
			}
			?>
			<!-- <tr> <th></th> <th></th> <th></th> <th></th> <th></th> </tr> -->
		</table>

	</div>
	<!-- /.container -->

<?php
require_once __DIR__ . '/../includes/footer.inc.php';
?>

<?php
require_once __DIR__ . '/../includes/foot.inc.php';
?>
