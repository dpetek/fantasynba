<?php
$overallObject = Helpers::getOverallFantasyStats();
$overall = $overallObject->getSorted();
$overallMatches = $overallObject->getMatces();
?>

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
                        <tr>
                            <td class="<?php echo $scores['wins'] > $scores['loses'] ? 'success' : ''; ?>">
                                <div class="media">
                                            <span class="pull-left">
                                                <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($name) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                            </span>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $name; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td class="<?php echo $scores['loses'] > $scores['wins'] ? 'success' : ''; ?>">
                                <div class="media">
                                            <span class="pull-left">
                                                <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($againstName) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                            </span>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $againstName; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $scores['wins'] . '-' . $scores['loses'] . '-' . $scores['draws']; ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endforeach ?>
            </table>
        </div>
</div>