<?php

class MongoHelper
{

    public static $connection = array();

    public static function getWeekMatches($weekId)
    {
        $connection = self::connection('weeks');
        $res = $connection->findOne(array('week_id' => $weekId));
        return $res;
    }

    public static function getEvent($eventId)
    {
        $connection = self::connection('events');
        $res = $connection->findOne(array('event_id' => $eventId));
        return $res;
    }

    public static function saveEvent(Event $event)
    {
        $connection = self::connection('events');
        $connection->save($event->getData());
    }

    public static function loadTeamById($teamId)
    {
        $conneciton = self::connection('teams');
        $data = $conneciton->findOne(array('team_id' => $teamId));
        if (!empty($data)) {
            return new Team($data);
        } else {
            return false;
        }
    }

    /**
     * @param $dbName
     * @return MongoCollection
     */
    public static function connection($dbName)
    {
        if (isset(self::$connection[$dbName])) {
            return self::$connection[$dbName];
        }
        $connection = new MongoClient(Config::get('mongo_connection'));
        $connection = $connection->fantasy;
        self::$connection[$dbName] = $connection->$dbName;
        return self::$connection[$dbName];
    }

}
