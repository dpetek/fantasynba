<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Team name</th>
        <th>Wins this week</th>
        <th>Loses this week</th>
        <th>Win percentage</th>
    </tr>
    </thead>
    <?php foreach($fantasyStats->getTeams() as $team): ?>
        <tr>
            <td>
                <span class='label label-info' style="min-width: 120px; display:inline-block"><?php echo $team->getTeamInfo()->getBackplanePlayer(); ?></span>
                <?php echo $team->getTeamInfo()->getFullName(); ?>
            </td>
            <td><?php echo $team->getWins(); ?></td>
            <td><?php echo $team->getLoses(); ?></td>
            <td><?php echo $team->getRatio(); ?></td>
        </tr>
    <?php endforeach ?>
</table>

