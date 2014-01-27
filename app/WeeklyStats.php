<?php

class WeeklyStats
{
    private $scoresPerDay = array();

    public function __construct($scoresPerDay)
    {

        $updated = array();
        foreach($scoresPerDay as $day)
        {
            $updatedDay = array();

            foreach($day['event'] as $event) {
                $tmp = $event;
                $homeTeam = MongoHelper::loadTeamById($event['home_team']['team_id']);
                $awayTeam = MongoHelper::loadTeamById($event['away_team']['team_id']);
                $tmp['home_team'] = $homeTeam;
                $tmp['away_team'] = $awayTeam;
                $eventInfo = MongoHelper::getEvent($event['event_id']);

                if ($eventInfo) {
                    $tmp['info'] = new Event($eventInfo);
                }

                $updatedDay[] = $tmp;
            }
            $new = $day;
            $new['event'] = $updatedDay;

            $updated[] = $new;
        }

        $this->scoresPerDay = $updated;

    }

    public static function loadThisWeek()
    {
        $weekId = self::currentWeekId();
        return self::loadByWeekID($weekId);
    }

    public static function loadByWeekID($weekId)
    {
        $dbData = MongoHelper::getWeekMatches($weekId);

        if (!empty($dbData)) {
            return new self($dbData['events']);
        }

        $api = new XMLStatsAPI(Config::get('access_token'), Config::get('timezone'));
        $matches = $api->getForWeek($weekId);

        return new self($matches);
    }

    public static function currentWeekId()
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone(Config::get('timezone')));

        $days = intval($now->format('N')) - 1;
        $now->sub(new DateInterval('P' . (string)$days . 'D'));

        return "week_" . $now->format('m_d_Y');
    }

    public function scoresPerDay()
    {
        return $this->scoresPerDay;
    }

}

 