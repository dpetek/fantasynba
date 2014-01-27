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

date_default_timezone_set(Config::get('timezone'));

$now = new DateTime();
$now->setTimezone(new DateTimeZone(Config::get('timezone')));

$teams = MongoHelper::loadTeams();
$api = new XMLStatsAPI(Config::get('access_token'), Config::get('timezone'));
foreach($teams as $team)
{
    if(!($team instanceof Team)) continue;
    $stats = $api->getTeamInfo($team->getTeamId());
    $stats = $stats['team_stats'][0];
    $team->setStats($stats);

    MongoHelper::saveTeam($team);
    echo "Updated: " . $team->getTeamId() . PHP_EOL;
    sleep(11);
}