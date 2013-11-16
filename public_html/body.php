<html>
	<head>
		<title>Backplane NBA Fantasy</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>

        <style>
            body { padding-top: 70px; }
        </style>

	</head>

	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Backplane Fantasy NBA</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Weekly stats</a></li>
					<li><a href="#">Overall stats</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>

        <?php include $page; ?>

	</body>
</html>