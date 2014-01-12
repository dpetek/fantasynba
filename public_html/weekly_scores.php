<?php $weekScores = WeeklyStats::loadByWeekID($weekId)->scoresPerDay(); ?>

<table class="table table-hover">
    <?php foreach($weekScores as $day): ?>
    <tr>
        <td colspan="4" style="background-color: #434343;color: white">Events on <?php echo Helpers::formatDateString($day['events_date']); ?></td>
    </tr>
    <?php foreach($day['event'] as $event): ?>
        <tr>
            <td class="<?php echo (isset($event['info']) && $event['info'] instanceof Event && $event['info']->getHomeScore() > $event['info']->getAwayScore()) ? 'success' : ''; ?>">
                <span class='' style="min-width: 120px; display:inline-block">
			<img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($event['home_team']->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px;'/>
		</span>
                <?php echo $event['home_team']->getFullName(); ?>
            </td>
            <td class="<?php echo (isset($event['info']) && $event['info'] instanceof Event && $event['info']->getAwayScore() > $event['info']->getHomeScore()) ? 'success' : ''; ?>">
                <span class='' style="min-width: 120px; display:inline-block">
			<img alt="140x140" src="<?php echo $__HOST . '/img/' . strtolower($event['away_team']->getBackplanePlayer()) . '.jpg'; ?>" class="img-circle" style='width:48px;height:48px'/>
		</span>
                <?php echo $event['away_team']->getFullName(); ?>
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

 
