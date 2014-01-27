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
	
	public static function deleteEventsById($eventId)
	{
		if (!$eventId ) return;
		$connection = self::connection('events');
		$connection->remove(array('event_id' => $eventId), array("justOne" => false));
	
	}

    public static function loadTeams()
    {
        $connection = self::connection('teams');

        $cursor = $connection->find();
        $teams[] = array();
        foreach($cursor as $teamData)
        {
            $teams[] = new Team($teamData);
        }
        return $teams;
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

    public static function getWeekFantasyMatches($weekId)
    {
        $connection = self::connection('matches');
        $data = $connection->findOne(array('week_id' => $weekId));

        if (!empty($data)) {
            return new WeekMatches($data);
        }
        return false;
    }

    public static function addFantasyMatch($week, $player1, $player2)
    {
        $object = self::getWeekFantasyMatches($week);

        if (!$object) {
            $object = new WeekMatches(array(
                'week_id' => $week,
                'matches' => array()
            ));
        }
        $object->addMatch($player1, $player2);
        $connection = self::connection('matches');
        $connection->save($object->getData());
    }

    public static function removeFantasyMatch($week, $player1, $player2) 
    {
        $object = self::getWeekFantasyMatches($week);
        if (!$object) return;

        $matches = $object->getMatches();
        $newMatches = array();

        foreach($matches as $match) {
                if (strtolower($match['player1']) == $player1 &&
                    strtolower($match['player2']) == $player2) {
                        continue;
                    }

                $newMatches[] = $match;
            }

        $object->setMatches($newMatches);
        $connection = self::connection('matches');
        $connection->save($object->getData());
    }

    public static function saveTeam(Team $team)
    {
        $data = $team->getData();
        $connection = self::connection('teams');

        $connection->update(
            array(
                'team_id' => $team->getTeamId()
            ),
            $data
        );
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
