<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
<br />
<table class="table table-hover">
    <thead>
        <tr style='background-color: #333;color:#fff;'>
            <th>Player name</th>
            <th>Wins this week</th>
            <th>Loses this week</th>
            <th>Win percentage</th>
        </tr>
    </thead>
    <?php foreach($fantasyStats->getPlayers() as $player): ?>
        <tr>
            <td>
		<img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($player->getPlayerName()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
		<?php echo $player->getPlayerName(); ?></td>
            <td><?php echo $player->getWins(); ?></td>
            <td><?php echo $player->getLoses(); ?></td>
            <td><?php echo $player->getRatio(); ?></td>
        </tr>
    <?php endforeach ?>
</table>

