<?php $playerName = strtolower($_GET['player']); ?>
<?php $draw = Config::get('draw'); ?>
<h3>
    <?php echo ucfirst($playerName); ?>
</h3>
<hr />

<h4>Teams</h4>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Team name</th>
            <th>Cost</th>
            <th>Won</th>
            <th>Lost</th>
            <th>Improvement</th>
        </tr>
    </thead>
    <?php foreach($draw[ucfirst($playerName)] as $teamId): ?>
        <?php $team = MongoHelper::loadTeamById($teamId); ?>
        <?php $stats = $team->getStats(); ?>
            <tr>
                <td>
                    <div class="media">
                    <span class="pull-left">
                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($team->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px;'/>
                        <img alt="140x140" src="<?php echo $__HOST . '/img/teams/' . strtolower($team->getTeamId()) . '.gif'; ?>" class="img-circle" style='width:48px;height:48px;margin-left: -25px;'/>
                    </span>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?php echo Helpers::buildTeamStatsLink($team->getTeamId()); ?>" >
                                    <?php echo Helpers::teamString($team); ?>
                                </a>

                            </h4>
                        </div>
                    </div>
                </td>
                <td>$<?php echo $team->getCost(); ?></td>
                <td><?php echo $stats['won']; ?></td>
                <td><?php echo $stats['lost']; ?></td>
                <td><?php echo $team->getPayout(); ?></td>
            </tr>
    <?php endforeach ?>
</table>

<h4>Matches</h4>
<?php
$overallObject = Helpers::getOverallFantasyStats();
$overall = $overallObject->getSorted();
$overallMatches = $overallObject->getMatces();
?>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Player name</th>
        <th>Player name</th>
        <th>W-L-D</th>
    </tr>
    </thead>
    <?php foreach($overallMatches as $name=>$against): ?>
        <?php foreach($against as $againstName => $scores): ?>
            <?php if ($name === ucfirst($playerName) || $againstName === ucfirst($playerName)): ?>
            <tr>
                <td class="<?php echo $scores['wins'] > $scores['loses'] ? 'success' : ''; ?>">
                    <div class="media">
                                <span class="pull-left">
                                    <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($name) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                </span>
                        <div class="media-body">
                            <a href="<?php echo Helpers::buildPlayerStatsLink($name); ?>">
                                <h4 class="media-heading"><?php echo $name; ?></h4>
                            </a>
                        </div>
                    </div>
                </td>
                <td class="<?php echo $scores['loses'] > $scores['wins'] ? 'success' : ''; ?>">
                    <div class="media">
                                <span class="pull-left">
                                    <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($againstName) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                </span>
                        <div class="media-body">
                            <a href="<?php echo Helpers::buildPlayerStatsLink($againstName); ?>">
                               <h4 class="media-heading"><?php echo $againstName; ?></h4>
                            </a>
                        </div>
                    </div>
                </td>
                <td><?php echo $scores['wins'] . '-' . $scores['loses'] . '-' . $scores['draws']; ?></td>
            </tr>
           <?php endif ?>
        <?php endforeach ?>
    <?php endforeach ?>
</table>
