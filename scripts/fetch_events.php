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

    foreach($day['event'] as $event) {
        $fromDb = MongoHelper::getEvent($event['event_id']);

        if (!$fromDb) {
            $info = $api->getEventInfo($event['event_id']);
            if (!$info ) exit(1);
            $eventObject = new Event($info);
            $eventObject->setEventId($event['event_id']);
            MongoHelper::saveEvent($eventObject);

            usleep(400000);
        }
    }
}
