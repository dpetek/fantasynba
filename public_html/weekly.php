<ul class="pager">

    <li class="previous <?php echo (!Helpers::getPreviousWeek($weekId)) ? 'disabled' : ''; ?>">
        <a href="<?php echo Helpers::getPreviousWeek($weekId) ? Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => Helpers::getPreviousWeek($weekId))) : '#'; ?>">
            &larr; Previous week
        </a>
    </li>

    <li class="next <?php echo (!Helpers::getNextWeek($weekId)) ? 'disabled' : ''; ?>">
        <a href="<?php echo Helpers::getNextWeek($weekId) ? Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => Helpers::getNextWeek($weekId))) : '#'; ?>">
            Next week &rarr;
        </a>
    </li>
</ul>
<?php if ($weekId != WeeklyStats::currentWeekId()): ?>
    <span class="span4">
    <a href="<?php echo Helpers::buildUrl('weekly', $activeSubpage, array('weekId' => WeeklyStats::currentWeekId())); ?>">
        <button type="button" class="btn btn-success">Go To Current Week</button>
    </a>
</span>
<?php endif ?>

<hr />
<h1 class="well">
    <?php echo Helpers::getWeekString($weekId); ?>
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
 
