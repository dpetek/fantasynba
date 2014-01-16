<div class="row clearfix">
        <div class="col-md-12 column">
<div class="row clearfix">
	<div class="col-md-12 column">
		<div class="page-header">
			<h1>
				<?php echo Helpers::getWeekString($weekId); ?>
				<?php if($weekId == WeeklyStats::currentWeekId()): ?>
					<small> (Current week) </small>
				<?php endif ?>
			</h1>
		</div>
	</div>
</div>

        <div class="row clearfix">
    <div class="col-md-12 column">
        <div class="btn-group btn-group-lg">
            <button class="btn btn-default <?php echo !Helpers::getPreviousWeek($weekId) ? 'disabled' : ''; ?>" type="button"
        onclick="location.href='<?php echo Helpers::getPreviousWeek($weekId) ? Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => Helpers::getPreviousWeek($weekId))) : '#'; ?>';">
                <em class="glyphicon glyphicon-arrow-left"></em> Prev
            </button>
            <button class="btn btn-success <?php echo $weekId == WeeklyStats::currentWeekId() ? 'disabled' : ''; ?>" type="button"
        onclick="location.href='<?php echo Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => WeeklyStats::currentWeekId())); ?>';">
        <em class="glyphicon glyphicon-screenshot"></em>
                This week
            </button>
            <button class="btn btn-default <?php echo !Helpers::getNextWeek($weekId) ? 'disabled' : ''; ?>" type="button"
        onclick="location.href='<?php echo Helpers::getNextWeek($weekId) ? Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => Helpers::getNextWeek($weekId))) : '#'; ?>';">
                Next <em class="glyphicon glyphicon-arrow-right"></em>
            </button>
        </div>
    </div>
</div>
<br />
            <div class="row clearfix">
                <div class="col-md-3 column">
<ul class="nav nav-stacked nav-pills">
    <li class="<?php echo $activeSubpage =='scores' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'scores', array('weekId' => $weekId)); ?>">Scores</a></li>
    <li class="<?php echo $activeSubpage =='teams' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'teams', array('weekId' => $weekId)); ?>">Teams</a></li>
    <li class="<?php echo $activeSubpage =='fantasy_scores' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'fantasy_stats', array('weekId' => $weekId)); ?>">Fantasy stats</a></li>
    <li class="<?php echo $activeSubpage =='fantasy_matches' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'fantasy_matches', array('weekId' => $weekId)); ?>">Fantasy matches</a></li>
</ul>
</div>
<div class='col-md-9 column'>
<?php include $subpage; ?>
    </div> <!-- 8 columns -->
</div> <!-- clearfix -->
</div>
</div>

