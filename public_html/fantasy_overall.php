<?php $overall = Helpers::getOverallFantasyStats()->getSorted(); ?>

<div class="page-header">
    <h3>
        Fantasy overall
    </h3>
</div>

<div class="row clearfix">
    <div class="col-md-12 column">
        <div class="col-md-6 column">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Wins</th>
                        <th>Loses</th>
                        <th>Draws</th>
                        <th>Ratio</th>
                    </tr>
                </thead>
                <?php foreach($overall as $player): ?>
                    <tr>
                        <td>
                            <div class="media">
                                            <span class="pull-left">
                                                <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($player['name']) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                            </span>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $player['name']; ?></h4>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $player['wins'];?></td>
                        <td><?php echo $player['loses'];?></td>
                        <td><?php echo $player['draws'];?></td>
                        <td><?php echo $player['ratio'];?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
        <div class="col-md-6 column">

            <?php foreach(Helpers::$weeks as $weekId): ?>
                <?php if ($weekId == WeeklyStats::currentWeekId()) break ?>
                <?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
                <?php $weekMatches = MongoHelper::getWeekFantasyMatches($weekId); ?>
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
            <?php endforeach ?>
        </div>
</div>