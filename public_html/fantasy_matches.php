<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
<?php $weekMatches = MongoHelper::getWeekFantasyMatches($weekId); ?>

<h2 class="well">Matches: </h2>

<?php if ($weekMatches): ?>
    <table class="table table-hover">
        <?php foreach($weekMatches->getMatches() as $match): ?>
            <?php $player1Stats = $fantasyStats->getForPlayer($match['player1']); ?>
            <?php $player2Stats = $fantasyStats->getForPlayer($match['player2']); ?>
            <tr>

                <td style="text-align: center" class="<?php echo $player1Stats->getRatio() > $player2Stats->getRatio() ? 'success' : ''; ?>">
		<img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($match['player1']) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                    <?php echo $match['player1']; ?>
                    <ul>
                        <li><span class='label label-info'>Win percentage: <?php echo $player1Stats->getRatio(); ?></span></li>
                        <li><span class='label label-success'>Wins: <?php echo $player1Stats->getWins(); ?></span></li>
                        <li><span class='label label-danger'>Lost: <?php echo $player1Stats->getLoses(); ?></span></li>
                    </ul>
                </td>
                <td style="text-align: center">vs</td>
                <td style="text-align: center" class="<?php echo $player2Stats->getRatio() > $player1Stats->getRatio() ? 'success' : ''; ?>">
			<img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($match['player2']) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>

                    <?php echo $match['player2']; ?>
                    <ul class="list-unstyled">
                        <li><span class='label label-info'>Win percentage: <?php echo $player2Stats->getRatio(); ?></span></li>
                        <li><span class='label label-success'>Wins: <?php echo $player2Stats->getWins(); ?></span></li>
                        <li><span class='label label-danger'>Lost: <?php echo $player2Stats->getLoses(); ?></span></li>
                    </ul>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>

<hr />
<form class="form-horizontal" role="form" method="post">
    <input type="hidden" name="post-action" value="add-match" />
    <input type="hidden" name="add-week" value="<?php echo $weekId; ?>"/>
    <div class="form-group">
        <label for="inputPassword" class="col-sm-2 control-label">First player</label>
        <div class="col-sm-10">
            <select class="form-control" name="add-player1">
                <?php foreach (Helpers::getPlayers() as $player): ?>
                    <option value="<?php echo $player;?>"><?php echo $player; ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword" class="col-sm-2 control-label">First player</label>
        <div class="col-sm-10">
            <select class="form-control" name="add-player2">
                <?php foreach (Helpers::getPlayers() as $player): ?>
                    <option value="<?php echo $player;?>"><?php echo $player; ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Add match</button>
        </div>
    </div>
</form>
