<?php
require_once __DIR__ . '/php/ALL.inc.php';

$tss = TimeSheet::get_all ();

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
<link rel="icon" href="../../favicon.ico">

<title>TimeSheet</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/index.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="js/ie-emulation-modes-warning.js"></script>

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
			<h1>Timesheet</h1>
			<p class="lead">timesheet description</p>
		</div>
		
		<form action="start-stop.action.php" method="post">
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
				<div class="col-md-12"><label for="comment">comment :</label><input type="text" name="comment" id="comment" value="<?= TimeSheet::get_last()->get_comment() ?>" /></div>
			</div>
		</form>
		
		
		<div class="row">&nbsp;</div>

		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th>id</th>
				<th>start</th>
				<th>stop</th>
				<th>comment</th>
			</tr>
		  	<?php
					foreach ( $tss as $ts ) {
						echo '<tr> <td>' . $ts->get_id () . '</td> <td>' . $ts->get_start () . '</td> <td>' . $ts->get_stop () . '</td> <td>' . $ts->get_comment () . '</td> </tr>';
					}
					?>
			<!-- <tr> <th></th> <th></th> <th></th> <th></th> </tr> -->
		</table>

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

