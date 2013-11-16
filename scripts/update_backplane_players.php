<?php

define('__APP_PATH', realpath('../app/'));
define('__CONFIG_PATH', realpath('../config/'));

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


$draw = Config::get('draw');
$reverseDrawHash = array();

foreach($draw as $player => $teams) {
    foreach($teams as $team) {
        $reverseDrawHash[$team] = $player;
    }
}


$mongo = new MongoClient(Config::get('mongo_connection'));
$db = $mongo->fantasy;

$cursor = $db->weeks->find();

foreach($cursor as $week) {
    $events = $week['events'];
    foreach($events as $event) {
        $home = $reverseDrawHash[$event['event']['home_team']['team_id']];
        $away = $reverseDrawHash[$event['event']['away_team']['team_id']];

        $event['event']['home_team']['backplane_fantasy_player'] = $home;
        $event['event']['away_team']['backplane_fantasy_player'] = $away;
    }
    $week['events'] = $events;
    $db->weeks->save($week);
}

