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

if (isset($_POST['post-action'])) {
    if ($_POST['post-action'] == 'add-match') {

        $player1 = $_POST['add-player1'];
        $player2 = $_POST['add-player2'];
        $week = $_POST['add-week'];

        MongoHelper::addFantasyMatch($week, $player1, $player2);

        header("Location: ". $_SERVER['REQUEST_URI']);
        exit;
    }
}


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

