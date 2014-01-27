<?php

class Team
{
    private $data = array();
    private $draw = array();

    public function __construct(array $data)
    {
        $this->data = $data;
        $drawReverse = Config::get('draw');

        foreach($drawReverse as $player => $teams) {
            foreach($teams as $team) {
                $this->draw[$team] = $player;
            }
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTeamId()
    {
        return $this->data['team_id'];
    }

    public function getFullName()
    {
        return $this->data['full_name'];
    }

    public function getBackplanePlayer()
    {
        return $this->data['backplane_player'];
    }

    public function setCost($cost)
    {
        $this->data['cost'] = $cost;
        return $this;
    }

    public function getCost()
    {
        return isset($this->data['cost']) ? $this->data['cost'] : 0;
    }

    public function getPayout()
    {
        return round(1.0 * $this->getCost() * (intval($this->data['stats']['won']) / (intval($this->data['stats']['won']) + intval($this->data['stats']['lost']))), 2);
    }

    public function getStats()
    {
        return $this->data['stats'];
    }

    public function setStats($stats)
    {
        $this->data['stats'] = $stats;
        return $this;
    }
}
