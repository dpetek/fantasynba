<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('__APP_PATH', realpath(__DIR__ . '/../app/'));
define('__CONFIG_PATH', realpath(__DIR__ . '/../config/'));
define('__HOST', '//' . $_SERVER['HTTP_HOST']);
$__HOST = '//' . $_SERVER['HTTP_HOST'];
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
    if ($_POST['post-action'] == 'delete-match') {
        $weekId = $_POST['remove-from-week-id'];
        $player1 = $_POST['player1-name'];
        $player2 = $_POST['player2-name'];
        MongoHelper::removeFantasyMatch($weekId, $player1, $player2);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit(1);
    }

}


$route = Helpers::getRoute($_SERVER['REQUEST_URI']);

$weekId = isset($_GET['weekId']) ? $_GET['weekId'] : WeeklyStats::currentWeekId();

if (!in_array($weekId, Helpers::$weeks)) {
    $weekId = WeeklyStats::currentWeekId();
}

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
    case 'overall':
    case 'overall/fantasy':
	$page = 'weekly.php';
	$subpage = 'fantasy_overall.php';
	$activePage = 'overall';
	$activeSubpage = 'overal_fantasy';
	break;
}

$page = 'weekly.php';

require_once 'body.php';

