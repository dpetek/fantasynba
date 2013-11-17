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

$weeks = $db->weeks->find();

foreach($weeks as $week)
{
    foreach($week['events'] as $events) {
        foreach($events['event'] as $day) {
            $homeTeam = $day['home_team'];
            $awayTeam = $day['away_team'];
            $homeTeam['backplane_player'] = $reverseDrawHash[$homeTeam['team_id']];
            $awayTeam['backplane_player'] = $reverseDrawHash[$awayTeam['team_id']];

            $htID = $homeTeam['team_id'];
            $atID = $awayTeam['team_id'];

            if (!MongoHelper::loadTeamById($htID)) {
                $db->teams->save($homeTeam);
            }
            if (!MongoHelper::loadTeamById($atID)) {
                $db->teams->save($awayTeam);
            }

        }
    }
}


 