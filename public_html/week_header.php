<div class="row clearfix">
    <div class="col-md-12 column">
        <div class="page-header">
            <h3>
                <?php echo Helpers::getWeekString($weekId); ?>
                <?php if($weekId == WeeklyStats::currentWeekId()): ?>
                    <small> (Current week) </small>
                <?php endif ?>
            </h3>
        </div>
    </div>
</div>