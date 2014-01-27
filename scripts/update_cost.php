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


$cost = array(
    'philadelphia-76ers' => 1,
        'phoenix-suns' => 2,
'brooklyn-nets' => 17,
'toronto-raptors' => 2,
'oklahoma-city-thunder' => 15,
'atlanta-hawks' => 5,
'chicago-bulls' => 26,
'minnesota-timberwolves' => 8,
'milwaukee-bucks' => 3,
'los-angeles-clippers' => 21,
'utah-jazz' => 1,
'sacramento-kings' => 4,
'cleveland-cavaliers' => 9,
'new-orleans-pelicans' => 5,
'detroit-pistons' => 4,
'orlando-magic' => 1,
'new-york-knicks' => 19,
'boston-celtics' => 3,
'houston-rockets' => 20,
'san-antonio-spurs' => 20,
'portland-trail-blazers' => 5,
'memphis-grizzlies' => 13,
'golden-state-warriors' => 17,
'washington-wizards' => 9,
'los-angeles-lakers' => 7,
'indiana-pacers' => 20,
'miami-heat' => 26,
'dallas-mavericks' => 6,
'denver-nuggets' => 10,
'charlotte-bobcats' => 2
);
$teams = MongoHelper::loadTeams();
foreach($teams as $team) {
    if ($team instanceof Team) {
        $team->setCost($cost[$team->getTeamId()]);
        MongoHelper::saveTeam($team);
    }
}