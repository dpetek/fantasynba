<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
<?php $weekMatches = MongoHelper::getWeekFantasyMatches($weekId); ?>

<?php include "week_header.php"; ?>
<?php if ($weekMatches): ?>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="col-md-6 column">
                <div class="page-header">
                    <h4>
                        Weekly fantasy scores
                    </h4>
                </div>
                <table class="table table-hover">
                    <?php foreach($weekMatches->getMatches() as $match): ?>
                        <?php $player1Stats = $fantasyStats->getForPlayer($match['player1']); ?>
                        <?php $player2Stats = $fantasyStats->getForPlayer($match['player2']); ?>
                        <tr>
                            <td style="text-align: center" class="<?php echo $player1Stats->getRatio() > $player2Stats->getRatio() ? 'success' : ''; ?>">
                                <div class="media">
                                    <span class="pull-left">
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($match['player1']) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $match['player1']; ?></h4>
                                    </div>
                                </div>
                                <ul class='list-unstyled'>
                                    <li><span class='label label-info'><?php echo round($player1Stats->getRatio() * 100.0, 1); ?>% wins (<?php echo $player1Stats->getWins(); ?>/<?php echo $player1Stats->getWins() + $player1Stats->getLoses(); ?>)</span></li>
                                </ul>
                            </td>
                            <td style="text-align: center" class="success">vs</td>
                            <td style="text-align: center" class="<?php echo $player2Stats->getRatio() > $player1Stats->getRatio() ? 'success' : ''; ?>">
                                <div class="media">
                                    <span class="pull-left">
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($match['player2']) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $match['player2']; ?></h4>
                                    </div>
                                </div>
                                <span class='label label-info'><?php echo round($player2Stats->getRatio() * 100.0, 1); ?>% wins (<?php echo $player2Stats->getWins(); ?>/<?php echo $player2Stats->getWins() + $player2Stats->getLoses(); ?>)</span>
                            </td>
                            <?php if (isset($_COOKIE['spacemonkey'])): ?>
                                <td>
                                    <form role='form' method='post'>
                                        <input type='hidden' name='post-action' value='delete-match'>
                                        <input type='hidden' name='player1-name' value='<?php echo strtolower($match['player1']); ?>' />
                                        <input type='hidden' name='player2-name' value='<?php echo strtolower($match['player2']); ?>' />
                                        <input type='hidden' name='remove-from-week-id' value='<?php echo $weekId; ?>' />
                                        <input type='submit' value='X' />
                                    </form>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div class="col-md-6 column">
                <div class="page-header">
                    <h4>
                        Weekly fantasy stats
                    </h4>
                </div>
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
                                <div class="media">
                                    <span class="pull-left">
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($player->getPlayerName()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $player->getPlayerName(); ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $player->getWins(); ?></td>
                            <td><?php echo $player->getLoses(); ?></td>
                            <td><?php echo $player->getRatio(); ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>


<?php endif ?>

<?php if (isset($_COOKIE['spacemonkey'])): ?>
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
<?php endif ?>
