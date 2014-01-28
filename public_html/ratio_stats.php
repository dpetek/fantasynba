<?php $teams = Helpers::sortTeamsByRatio(MongoHelper::loadTeams()); ?>
<h2>Teams by ratio (wins/total)</h2><hr/>
<table class="table table-hover">
    <?php foreach ($teams as $team): ?>
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
        </tr>
    <?php endforeach ?>
</table>