<?php $team = MongoHelper::loadTeamById($_GET['team_id']); ?>
<?php $stats = $team->getStats(); ?>

<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <h3>
                <?php echo $team->getFullName(); ?>
            </h3>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6 column">
            <h4>
                NBA info
            </h4>
            <table class="table table-hover">
                <tr>
                    <td>Wins</td>
                    <td><?php echo $stats['won']; ?></td>
                </tr>
                <tr>
                    <td>Loses</td>
                    <td><?php echo $stats['lost']; ?></td>
                </tr>
                <tr>
                    <td>Total points</td>
                    <td><?php echo $stats['stats']['points']; ?></td>
                </tr>
                <tr>
                    <td>Field goal percentage</td>
                    <td><?php echo $stats['stats']['field_goal_percentage_string']; ?>%</td>
                </tr>
                <tr>
                    <td>Free throw percentage</td>
                    <td><?php echo $stats['stats']['free_throw_percentage_string']; ?>%</td>
                </tr>
                <tr>
                    <td>Three point percentage</td>
                    <td><?php echo $stats['stats']['three_point_field_goal_percentage_string']; ?>%</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 column">
            <h4>
                Fantasy info
            </h4>
            <table class="table table-hover">
                <tr>
                    <td>Backplane player</td>
                    <td>
                        <div class="media">
                        <span class="pull-left">
                            <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($team->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                        </span>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $team->getBackplanePlayer(); ?></h4>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Cost</td>
                    <td>$<?php echo $team->getCost(); ?></td>
                </tr>
                <tr>
                    <td>Improvement:</td>
                    <td><?php echo $team->getPayout(); ?>%</td>
                </tr>
            </table>
        </div>
    </div>
</div>
