<?php

class TeamStats
{
    private $teamId = '';
    private $wins = 0;
    private $loses = 0;

    public function __construct($teamId)
    {
        $this->teamId = $teamId;
    }


    public function updateStats($event)
    {
        if (!isset($event['info']) || !($event['info'] instanceof Event)) {
            return;
        }

        $info = $event['info'];

        /** @var Team $homeTeam */
        $homeTeam = $event['home_team'];
        /** @var Team $awayTeam */
        $awayTeam = $event['away_team'];

        if ($homeTeam->getTeamId() == $this->teamId) {
            if ($info->getHomeScore() > $info->getAwayScore()) {
                $this->wins ++;
            } else {
                $this->loses ++;
            }
        }
        if ($awayTeam->getTeamId() == $this->teamId) {
            if ($info->getAwayScore() > $info->getHomeScore()) {
                $this->wins ++;
            } else {
                $this->loses ++;
            }
        }
    }

    public function getTeamId()
    {
        return $this->teamId;
    }

    public function getWins()
    {
        return $this->wins;
    }

    public function getLoses()
    {
        return $this->loses;
    }

    public function getRatio()
    {
        if ($this->wins + $this->loses === 0) {
            return 0;
        }
        return 1.0 * $this->wins / ($this->wins + $this->loses);
    }

    public function getTeamInfo()
    {
        return MongoHelper::loadTeamById($this->teamId);
    }
    public function getTeam()
    {
        return MongoHelper::loadTeamById($this->getTeamId());
    }
}

 