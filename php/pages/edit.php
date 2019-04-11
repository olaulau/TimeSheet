<?php
require_once __DIR__ . '/../ALL.inc.php';


/* parameters handling */
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	die('no id parameter provided');
}

/* timesheet getting */
$id = intval($id);
$ts = TimeSheet::get_from_id($id);
if(!isset($ts)) {
	die('cannot find timesheet #' . $id);
}
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
			<h1>Timesheet #<?= $ts->get_id() ?></h1>
			<!-- <p class="lead">timesheet description</p> -->
		</div>
		
		<form action="../actions/edit.action.php" method="post">
			<input type="hidden" name="id" id="id" value="<?= $ts->get_id() ?>" />
			<div class="row"> <div class="col-md-2"><label for="start">start :</label></div>		<input type="datetime" name="start" id="start" value="<?= format_datetime($ts->get_start()) ?>" /> </div>
			<div class="row"> <div class="col-md-2"><label for="stop">stop :</label></div> 			<input type="datetime" name="stop" id="stop" value="<?= format_datetime($ts->get_stop()) ?>" /> </div>
			<div class="row"> <div class="col-md-2"><label for="comment">comment :</label></div> 	<input type="text" name="comment" id="comment" value="<?= $ts->get_comment() ?>" /> </div>
			<button class="btn btn-lg btn-primary" type="submit">Save</button>
		</form>
		
		
		<div class="row">&nbsp;</div>

	</div>
	<!-- /.container -->
	
<script type="text/javascript">
	$( document ).ready(function() {

		$('#start').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeInput: true,
			timeFormat: "HH:mm"
		});
		$('#start').datetimepicker('option', $.timepicker.regional['fr']);
		$('#start').datetimepicker('option', {
			dateFormat: 'yy-mm-dd',
			timeInput: true,
			timeFormat: "HH:mm"
		});

		$('#stop').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeInput: true,
			timeFormat: "HH:mm"
		});
		$('#stop').datetimepicker('option', $.timepicker.regional['fr']);
		$('#stop').datetimepicker('option', {
			dateFormat: 'yy-mm-dd',
			timeInput: true,
			timeFormat: "HH:mm"
		});

	});
</script>

<?php
require_once __DIR__ . '/../includes/footer.inc.php';
?>

<?php
require_once __DIR__ . '/../includes/foot.inc.php';
?>
