<?php

class FantasyStats
{
    private $players = array();
    private $teams = array();

    public static function createForWeek(WeeklyStats $stats)
    {
        $instance = new self();
        $draw = Config::get('draw');

        $players = array();
        $teams = array();
        foreach($draw as $name => $playerTeams) {
            $players[] = new PlayerStats($name, $playerTeams);

            foreach($playerTeams as $team) {
                $teams[] = new TeamStats($team);
            }

        }
        $perDay = $stats->scoresPerDay();

        foreach($perDay as $day) {
            foreach($day['event'] as $event) {
                /** @var $player PlayerStats */
                foreach($players as $player) {
                    $player->updateStats($event);
                }
                /** @var $team TeamStats */
                foreach($teams as $team) {
                    $team->updateStats($event);
                }
            }
        }
        $instance->setPlayers($players);
        $instance->setTeams($teams);
        return $instance;

    }

    public function setPlayers(array $players)
    {
        $this->players = $players;
    }

    public function setTeams(array $teams) {
        $this->teams = $teams;
    }

    public function getPlayers($sort = true)
    {
        if ($sort) {
            usort($this->players, function($p1, $p2) {
                    if (abs($p1->getRatio() - $p2->getRatio()) < 0.0000000001) {
                        return ($p1->getWins() > $p2->getWins()) ? -1 : 1;
                    }
                    return ($p1->getRatio() > $p2->getRatio()) ? -1 : 1;
                }
            );
        }
        return $this->players;
    }

    public function getTeams($sort = true) {
        if ($sort) {
            usort($this->teams, function($p1, $p2) {
                    if (abs($p1->getRatio() - $p2->getRatio()) < 0.0000000001) {
                        return ($p1->getWins() > $p2->getWins()) ? -1 : 1;
                    }
                    return ($p1->getRatio() > $p2->getRatio()) ? -1 : 1;
                }
            );
        }
        return $this->teams;
    }

    public function getForPlayer($playerName)
    {
        /** @var PlayerStats $player */
        foreach($this->players as $player)
        {
            if ($player->getPlayerName() == $playerName) {
                return $player;
            }
        }
        return null;
    }

}

 