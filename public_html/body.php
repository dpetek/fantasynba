<html>
	<head>
		<title>Backplane NBA Fantasy</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $__HOST . '/style.css'; ?>" rel="stylesheet">
        <script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-42965204-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  		})();

	</script>

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
                    <li class="<?php echo $activePage=="weeklyFantasy" ? "active" : "";?>"><a href="<?php echo Helpers::buildUrl('weeklyFantasy', array('weekId' => $weekId)); ?>">Fantasy this week</a></li>
					<li class="<?php echo $activePage=="weeklyScores" ? "active" : ""; ?>"><a href="<?php echo Helpers::buildUrl('weeklyScores', array('weekId' => $weekId)); ?>">Weekly scores</a></li>
                    <li class="<?php echo $activePage=="fantasyOverall" ? "active" : ""; ?>"><a href="<?php echo Helpers::buildUrl('fantasyOverall', array('weekId' => $weekId)); ?>">Fantasy overall</a></li>
<!--                    <li class=""><a href="Scores overall">Scoress overall</a></li>-->
				</ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo Helpers::getNextWeek($weekId) ? Helpers::buildUrl($activePage, array('weekId' => Helpers::getPreviousWeek($weekId))) : '#'; ?>">
                            <em class="glyphicon glyphicon-arrow-left"></em> Prev
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Helpers::getNextWeek($weekId) ? Helpers::buildUrl($activePage, array('weekId' => WeeklyStats::currentWeekId())) : '#'; ?>">
                            <em class="glyphicon glyphicon-screenshot"></em>This week
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Helpers::getNextWeek($weekId) ? Helpers::buildUrl($activePage, array('weekId' => Helpers::getNextWeek($weekId))) : '#'; ?>">
                            Next <em class="glyphicon glyphicon-arrow-right"></em>
                        </a>
                    </li>
                </ul>
			</div><!-- /.navbar-collapse -->
		</nav>
        <?php include $page; ?>

	</body>
</html>
