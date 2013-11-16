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

$route = Helpers::getRoute($_SERVER['REQUEST_URI']);

$weekId = isset($_GET['weekId']) ? $_GET['weekId'] : WeeklyStats::currentWeekId();

switch($route) {
    case '':
    case 'weekly':
    case 'weekly/scores':
        $page = 'weekly.php';
        $subpage = 'weekly_scores.php';
        $activePage = 'weekly';
        $activeSubpage = 'scores';
        break;
    case 'weekly/fantasy_stats':
    case 'weekly/fantasy_scores':
        $page = 'weekly.php';
        $subpage = 'fantasy_scores.php';
        $activePage = 'weekly';
        $activeSubpage = 'fantasy_scores';
        break;
    case 'weekly/fantasy_matches';
        $page = 'weekly.php';
        $subpage = 'fantasy_matches.php';
        $activePage = 'weekly';
        $activeSubpage = 'fantasy_matches';
        break;
    case 'weekly/team_stats':
    case 'weekly/teams':
        $page = 'weekly.php';
        $subpage = 'team_stats.php';
        $activePage = 'weekly';
        $activeSubpage = 'teams';
        break;
}

$page = 'weekly.php';

require_once 'body.php';

