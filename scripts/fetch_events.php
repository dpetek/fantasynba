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



$thisWeek = WeeklyStats::loadThisWeek();
$api = new XMLStatsAPI(Config::get('access_token'), Config::get('timezone'));
foreach($thisWeek->scoresPerDay() as $day)
{
    $time = DateTime::createFromFormat(DateTime::ISO8601, $day['events_date']);
    $now = new DateTime();
    if ($time > $now) {
        break;
    }
	preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $day['events_date'], $match);
	$y = $match[1];$m=$match[2];$d=$match[3];
    $day = $api->getDataForDay($d, $m, $y);
    sleep(11);
    foreach($day['event'] as $event) {
        if ($event['event_status'] !== 'completed') {
            continue;
        }

        $fromDb = MongoHelper::getEvent($event['event_id']);
        if (!$fromDb || !isset($fromDb['away_totals'])) {
	        MongoHelper::deleteEventsById($event['event_id']);
            $info = $api->getEventInfo($event['event_id']);
    	    if (!$info) continue;
            $eventObject = new Event($info);
            $eventObject->setEventId($event['event_id']);
            MongoHelper::saveEvent($eventObject);
	    	sleep(11);
        }
    }
}
