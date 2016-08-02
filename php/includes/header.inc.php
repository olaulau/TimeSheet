<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?= app_base_path() ?>/">TimeSheet</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li id="home-tab"><a href="<?= app_base_path() ?>/">Home</a></li> <!-- class="active" -->
					<li id="stats-tab"><a href="<?= app_base_path() ?>/php/pages/stats.php">Stats</a></li>
<!-- 					<li><a href="#about">About</a></li> -->
<!-- 					<li><a href="#contact">Contact</a></li> -->
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>
