<?php $weekScores = WeeklyStats::loadByWeekID($weekId)->scoresPerDay(); ?>
<?php $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId)); ?>
<?php include "week_header.php"; ?>
<div class="row clearfix">
    <div class="col-md-12 column">
        <div class="col-md-6 column">
            <div class="page-header">
                <h4>
                    Weekly scores
                </h4>
            </div>
            <table class="table table-hover">
                <?php foreach($weekScores as $day): ?>
                    <tr>
                        <td colspan="4" style="background-color: #dedede;">Events on <?php echo Helpers::formatDateString($day['events_date']); ?></td>
                    </tr>
                    <?php foreach($day['event'] as $event): ?>
                        <tr>
                            <td class="<?php echo (isset($event['info']) && $event['info'] instanceof Event && $event['info']->getHomeScore() > $event['info']->getAwayScore()) ? 'success' : ''; ?>">
                                
                                 <div class="media">
                                    <span class="pull-left">
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($event['home_team']->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px;'/>
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/teams/' . strtolower($event['home_team']->getTeamId()) . '.gif'; ?>" class="img-circle" style='width:48px;height:48px;margin-left: -25px;'/>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="<?php echo Helpers::buildTeamStatsLink($event['home_team']->getTeamId()); ?>" >
                                                <?php echo Helpers::teamString($event['home_team']); ?>
                                            </a>

                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td class="<?php echo (isset($event['info']) && $event['info'] instanceof Event && $event['info']->getAwayScore() > $event['info']->getHomeScore()) ? 'success' : ''; ?>">
                                                             <div class="media">
                                    <span class="pull-left">
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($event['away_team']->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/teams/' . strtolower($event['away_team']->getTeamId()) . '.gif'; ?>" class="img-circle" style='width:48px;height:48px;margin-left: -25px'/>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="<?php echo Helpers::buildTeamStatsLink($event['away_team']->getTeamId()); ?>" >
                                                <?php echo Helpers::teamString($event['away_team']); ?>
                                            </a>

                                        </h4>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <?php if (isset($event['info']) && $event['info'] instanceof Event): ?>
                                    <?php echo $event['info']->getHomeScore(); ?>
                                    -
                                    <?php echo $event['info']->getAwayScore(); ?>
                                <?php endif ?>

                            </td>

                        </tr>
                    <?php endforeach ?>
                <?php endforeach ?>
            </table>
        </div>

        <div class="col-md-6 column">
            <div class="page-header">
                <h4>
                    Weekly stats
                </h4>
            </div>
            <table class="table table-hover">
                <thead>
                <tr style='background-color: #dedede;'>
                    <th>Team name</th>
                    <th>Wins</th>
                    <th>Loses</th>
                    <th>Win percentage</th>
                </tr>
                </thead>
                <?php foreach($fantasyStats->getTeams() as $team): ?>
                    <tr>
                        <td>

                                <div class="media">
                                    <span class="pull-left">
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($team->getTeamInfo()->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px;'/>
                                        <img alt="140x140" src="<?php echo $__HOST . '/img/teams/' . strtolower($team->getTeamId()) . '.gif'; ?>" class="img-circle" style='width:48px;height:48px;margin-left: -25px;'/>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="<?php echo Helpers::buildTeamStatsLink($team->getTeamInfo()->getTeamId()); ?>" >
                                                <?php echo Helpers::teamString($team->getTeamInfo()); ?>
                                            </a>

                                        </h4>
                                    </div>
                                </div>
                        </td>
                        <td><?php echo $team->getWins(); ?></td>
                        <td><?php echo $team->getLoses(); ?></td>
                        <td><?php echo $team->getRatio(); ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>



 
