<?php

class Event
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setEventId($eventId)
    {
        $this->data['event_id'] = $eventId;
    }

    public function getHomeScore()
    {
        if (!isset($this->data['home_totals'])) return 0;
        return $this->data['home_totals']['points'];
    }
    public function getAwayScore()
    {
        if (!isset($this->data['away_totals'])) return 0;
        return $this->data['away_totals']['points'];
    }

    public function getData()
    {
        return $this->data;
    }
}

 