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
        return $this->draw[$this->getTeamId()];
    }
}