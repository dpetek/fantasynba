<?php

define('__APP_PATH', realpath(__DIR__ . '/../app/'));
define('__CONFIG_PATH', realpath(__DIR__ . '/../config/'));


//init autoloader

spl_autoload_register(
    function($className) {
        $file = __APP_PATH . '/' . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
);

Config::init(__CONFIG_PATH . '/Config.json');

$lastDay = 14;
$lastMonth = 4;
$lastYear = 2014;

$draw = Config::get('draw');
$reverseDrawHash = array();

foreach($draw as $player => $teams) {
    foreach($teams as $team) {
        $reverseDrawHash[$team] = $player;
    }
}

$mongo = new MongoClient(Config::get('mongo_connection'));
$db = $mongo->fantasy;

$current = DateTime::createFromFormat('m-d-Y', '10-28-2013');
$current->setTimezone(new DateTimeZone(Config::get('timezone')));

while(true) {
    if (intval($current->format('Y')) == 2014 && intval($current->format('m')) > 4) {
        break;
    }
    $weekId = "week_" . $current->format('m_d_Y');

    $stats = WeeklyStats::loadByWeekID($weekId);
    $perDay = $stats->scoresPerDay();

    $perDayUpdated = array();
    foreach($perDay as $events) {
        $updated = array();
        foreach($events['event'] as $event) {
            $home = $reverseDrawHash[$event['home_team']['team_id']];
            $away = $reverseDrawHash[$event['away_team']['team_id']];

            $event['home_team']['backplane_fantasy_player'] = $home;
            $event['away_team']['backplane_fantasy_player'] = $away;
            $updated[] = $event;
        }
        $events['event'] = $updated;
    }
    $db->weeks->save(
        array(
            'week_id' => $weekId,
            'events' => $perDay
        )
    );

    foreach($perDay as $day)
    {
        $date = DateTime::createFromFormat(DateTime::ISO8601, $day['events_date']);
        $date->setTimezone(new DateTimeZone(Config::get('timezone')));
        $id = 'day_' . $date->format('m_d_Y');

        $db->days->save(
            array(
                'day_id' => $id,
                'events' => $day['event']
            )
        );

    }

    $current->add(new DateInterval('P7D'));
}