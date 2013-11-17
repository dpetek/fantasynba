<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Player name</th>
            <th>Wins this week</th>
            <th>Loses this week</th>
            <th>Win percentage</th>
        </tr>
    </thead>
    <?php foreach($fantasyStats->getPlayers() as $player): ?>
        <tr>
            <td><?php echo $player->getPlayerName(); ?></td>
            <td><?php echo $player->getWins(); ?></td>
            <td><?php echo $player->getLoses(); ?></td>
            <td><?php echo $player->getRatio(); ?></td>
        </tr>
    <?php endforeach ?>
</table>

