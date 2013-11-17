<?php if ($weekId != WeeklyStats::currentWeekId()): ?>
<span class="span4">
    <a href="<?php echo Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => WeeklyStats::currentWeekId())); ?>">
        <button type="button" class="btn btn-success">Current week</button>
    </a>
</span>
<?php endif ?>

<?php if (Helpers::getPreviousWeek($weekId)): ?>
    <span class="span4">
        <a href="<?php echo Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => Helpers::getPreviousWeek($weekId))); ?>">
            <button type="button" class="btn btn-warning">Previous week</button>
        </a>
    </span>
<?php endif ?>

<?php if (Helpers::getNextWeek($weekId)): ?>
    <span class="span4">
        <a href="<?php echo Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => Helpers::getNextWeek($weekId))); ?>">
            <button type="button" class="btn btn-info">Next week</button>
        </a>
    </span>
<?php endif ?>

<hr />
<h1 class="well">
    Week: <?php echo Helpers::getWeekString($weekId); ?>
</h1>
<h4>
    <?php if ($weekId == WeeklyStats::currentWeekId()): ?>
        <span class="label label-success">Active week! Good luck!</span>
    <?php endif ?>
</h4>
<hr />

<ul class="nav nav-tabs">
    <li class="<?php echo $activeSubpage =='scores' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'scores', array('weekId' => $weekId)); ?>">Scores</a></li>
    <li class="<?php echo $activeSubpage =='teams' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'teams', array('weekId' => $weekId)); ?>">Teams</a></li>
    <li class="<?php echo $activeSubpage =='fantasy_scores' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'fantasy_stats', array('weekId' => $weekId)); ?>">Fantasy stats</a></li>
    <li class="<?php echo $activeSubpage =='fantasy_matches' ? 'active' : ''; ?>"><a href="<?php echo Helpers::buildUrl('weekly', 'fantasy_matches', array('weekId' => $weekId)); ?>">Fantasy matches</a></li>
</ul>

<?php include $subpage; ?>
 