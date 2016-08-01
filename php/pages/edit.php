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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="./favicon.ico">

<title>TimeSheet</title>

<!-- Bootstrap core CSS -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-theme.min.css" rel="stylesheet">

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="../../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../../css/index.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="../../js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">TimeSheet</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">

		<div class="starter-template">
			<h1>Timesheet #<?= $ts->get_id() ?></h1>
			<!-- <p class="lead">timesheet description</p> -->
		</div>
		
		<form action="../actions/edit.action.php" method="post">
			<input type="hidden" name="id" id="id" value="<?= $ts->get_id() ?>" />
			<div class="row"> <div class="col-md-2"><label for="start">start :</label></div>		<input type="datetime" name="start" id="start" value="<?= $ts->get_start() ?>" /> </div>
			<div class="row"> <div class="col-md-2"><label for="stop">stop :</label></div> 			<input type="datetime" name="stop" id="stop" value="<?= $ts->get_stop() ?>" /> </div>
			<div class="row"> <div class="col-md-2"><label for="comment">comment :</label></div> 	<input type="text" name="comment" id="comment" value="<?= $ts->get_comment() ?>" /> </div>
			<button class="btn btn-lg btn-primary" type="submit">Save</button>
		</form>
		
		
		<div class="row">&nbsp;</div>

	</div>
	<!-- /.container -->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
	<script src="js/bootstrap.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>

