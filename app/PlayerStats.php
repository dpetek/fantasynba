<?php

class PlayerStats
{
    private $name = '';
    private $teamIds = array();
    private $wins = 0;
    private $loses = 0;
    private $teamStats = array();

    public function __construct($playerName, $playerTeams)
    {
        $this->name = $playerName;
        $this->teamIds = $playerTeams;
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

        if (in_array($homeTeam->getTeamId(), $this->teamIds)) {
            if ($info->getHomeScore() > $info->getAwayScore()) {
                $this->wins ++;
            } else {
                $this->loses ++;
            }
        }

        if (in_array($awayTeam->getTeamId(), $this->teamIds)) {
            if ($info->getAwayScore() > $info->getHomeScore()) {
                $this->wins ++;
            } else {
                $this->loses ++;
            }
        }
    }

    public function getPlayerName()
    {
        return $this->name;
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

}

 