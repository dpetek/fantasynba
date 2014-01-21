<?php

class FantasyOverall
{
    private $stats = array();
    private $matches = array();
    public function __construct($players, $playersWins, $playersLoses, $playersDraws, $playerMatches)
    {
        foreach($players as $player)
        {
            $this->stats[] = array(
                "name" => $player,
                "wins" => $playersWins[$player],
                "loses" => $playersLoses[$player],
                "draws" => $playersDraws[$player],
                "ratio" => 1.0 * $playersWins[$player] / ($playersWins[$player] + $playersLoses[$player] + $playersDraws[$player])
            );
        }
        $this->matches = $playerMatches;
    }

    public function getSorted()
    {
        usort($this->stats, function($p1, $p2) {
                if (abs($p1['ratio'] - $p2['ratio']) < 0.0000000001) {
                    return ($p1['ratio'] > $p2['ratio']) ? -1 : 1;
                }
                return ($p1['ratio'] > $p2['ratio']) ? -1 : 1;
            }
        );
        return $this->stats;
    }

    public function getMatces()
    {
        return $this->matches;
    }
}