<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
<br />
<table class="table table-hover">
    <thead>
    <tr style='background-color: #333;color:#fff;'>
        <th>Team name</th>
        <th>Wins this week</th>
        <th>Loses this week</th>
        <th>Win percentage</th>
    </tr>
    </thead>
    <?php foreach($fantasyStats->getTeams() as $team): ?>
        <tr>
            <td>
                <span class='' style="min-width: 120px; display:inline-block">
		<img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($team->getTeamInfo()->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/></span>
                <?php echo $team->getTeamInfo()->getFullName(); ?>
            </td>
            <td><?php echo $team->getWins(); ?></td>
            <td><?php echo $team->getLoses(); ?></td>
            <td><?php echo $team->getRatio(); ?></td>
        </tr>
    <?php endforeach ?>
</table>

