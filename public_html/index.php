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

// do routing



switch($route) {
    case '':
    case 'weeklyFantasy':
        $page = 'fantasy_matches.php';
        $activePage = 'weeklyFantasy';
        break;
    case 'weeklyScores':
        $page = 'weekly_scores.php';
        $activePage = 'weeklyScores';
        break;
    case 'fantasyOverall';
        $page = 'fantasy_overall.php';
        $activePage = 'fantasyOverall';
        break;
    case 'teamStats':
        $page = 'team_stats.php';
        $activePage = 'teamStats';
        break;
    case 'playerStats':
        $page = 'player_stats.php';
        $activePage = 'playerStats';
        break;
    case 'payoutStats':
        $page = 'improvement_stats.php';
        $activePage = 'stats';
        break;
    case 'ratioStats':
        $page = 'ratio_stats.php';
        $activePage = 'stats';
        break;
    default:
        $page = 'fantasy_matches.php';
        $activePage = 'weeklyFantasy';
        break;
}

//$page = 'weekly.php';

require_once 'body.php';

