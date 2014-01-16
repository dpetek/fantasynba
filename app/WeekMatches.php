<?php

class WeekMatches
{
    private $data = array();

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function addMatch($player1, $player2)
    {
        $this->data['matches'][] = array(
            'player1' => $player1,
            'player2' => $player2
        );
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMatches()
    {
        return $this->data['matches'];
    }
    
    public function setMatches(array $matches) 
    {
        $this->data['matches'] = $matches;    
    }
}

 
