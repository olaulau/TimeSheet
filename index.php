<?php
require_once __DIR__ . '/php/ALL.inc.php';


/*  get all time sheets from the most recent  */
$dbh = DB::get();
$sql = '
	SELECT id, start, stop, comment
	FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . '
	ORDER BY start DESC';
//echo "<pre> $sql </pre>";
$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
$st->setFetchMode(PDO::FETCH_CLASS, 'TimeSheet');
$tss = $st->fetchAll(PDO::FETCH_CLASS, 'TimeSheet');

$last_timesheet = TimeSheet::get_last();
?>

<?php
require_once 'php/includes/head.inc.php';
?>

<?php
require_once 'php/includes/header.inc.php';
?>

	<div class="container">

		<div class="starter-template">
			<h1>Timesheet</h1>
			<p class="lead">timesheet description</p>
		</div>
		
		<form action="php/actions/start-stop.action.php" method="post">
			<div class="row">
				<div class="container col-md-6">
					<button type="submit" class="btn btn-lg btn-success col-md-12 <?= TimeSheet::can_start() ? '' : 'disabled' ?> ">
						<h1>Démarrer</h1>
					</button>
				</div>
				<div class="container col-md-6">
					<button type="submit"  class="btn btn-lg btn-danger  col-md-12 <?= TimeSheet::can_stop()  ? '' : 'disabled' ?> ">
						<h1>Arrêter</h1>
					</button>
				</div>
			</div>
			
			<div class="row">
				<input type="hidden" name="action" id="action" value="<?= TimeSheet::can_start() ? 'start' : 'stop' ?>" />
				<div class="col-md-4"></div><div class="col-md-4"><label for="comment">comment :</label> <input type="text" name="comment" id="comment" value="<?= $last_timesheet->get_comment() ?>" /></div><div class="col-md-4"></div>
			</div>
		</form>
		
		
		<div class="row">&nbsp;</div>

		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th>id</th>
				<th>start</th>
				<th>stop</th>
				<th>comment</th>
				<th>&nbsp;</th>
			</tr>
		  	<?php
			foreach ( $tss as $ts ) {
				?>
			<tr>
				<td><?= $ts->get_id() ?></td>
				<td><?= $ts->get_start() ?></td>
				<td><?= $ts->get_stop() ?></td>
				<td><?= $ts->get_comment() ?></td>
				<td>
					<a href="php/pages/edit.php?id=<?= $ts->get_id() ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					<a href="php/actions/delete.action.php?id=<?= $ts->get_id() ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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
require_once 'php/includes/footer.inc.php';
?>

<?php
require_once 'php/includes/foot.inc.php';
?>

