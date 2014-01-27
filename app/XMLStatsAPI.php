<?php

class XMLStatsAPI{
        // Replace with your bot name and email/website to contact if there is a problem
        // e.g., "mybot/0.1 (http://erikberg.com/)"
        const USER_AGENT = 'nba-fantasy/0.0.1 (dpetek1@gmail.com)';

        // PHP complains if time zone is not set
        private $host = '';
        private $sport = '';
        private $method = '';
        private $format = '';

        private $accessToken = '';
        private $timeZone = '';

        public function __construct($accessToken, $timeZone)
        {
            // Set the API sport, method, id, format, and any parameters
            $this->host   = 'erikberg.com';
            $this->sport = 'nba';
            $this->method = 'events';
            $this->format = 'json';
            $this->accessToken = $accessToken;
            $this->timeZone = $timeZone;
        }

        public function getThisWeek()
        {
            $now = new DateTime();
            $now->setTimezone(new DateTimeZone($this->timeZone));

            $dayOfTheWeek = $now->format('N');
            $year = $now->format('Y');
            $month = $now->format('n');
            $day = $now->format('j');

            $aggregate = array();
            $monday = intval($day) - intval($dayOfTheWeek) + 1;
            for($i=intval($monday);$i<intval($monday)+7;$i++) {
                $day = $this->getDataForDay(intval($i), $month, $year);
                $aggregate[] = $day;
            }
            return $aggregate;
        }

        public function getForWeek($weekId)
        {
            $parts = explode('_', $weekId);
            $month = $parts[1];
            $day = $parts[2];
            $year = $parts[3];

            $current = DateTime::createFromFormat("Y-m-d", $year . '-' . $month . '-' . $day);
            $current->setTimezone(new DateTimeZone(Config::get('timezone')));

            $aggregate = array();
            $aggregate[] = $this->getDataForDay($day, $month, $year);

            for($i=0;$i<6;$i++) {
                $current->add(new DateInterval("P1D"));
                $day = $current->format('d');
                $month = $current->format('m');
                $year = $current->format('Y');
                $aggregate[] = $this->getDataForDay($day, $month, $year);
            }

            return $aggregate;
        }

        public function getDataForDay($day, $month, $year)
        {
            $dayStr = (string)$day;
            if (count($dayStr) ==1) $dayStr = '0' . $dayStr;
            $parameters = array(
                'sport' => $this->sport,
                'date'  => (string)$year . (string)$month . (string)$dayStr
            );

            // Pass method, format, and parameters to build request url
            $url = $this->buildURL($this->host, $this->sport, $this->method, '', $this->format, $parameters);

            // Set the User Agent, Authorization header and allow gzip
            $default_opts = array(
                'http' => array(
                    'user_agent' => self::USER_AGENT,
                    'header'     => array(
                        'Accept-Encoding: gzip',
                        'Authorization: Bearer ' . $this->accessToken
                    )
                )
            );
            stream_context_get_default($default_opts);
            $file = 'compress.zlib://' . $url;
            $fh = fopen($file, 'rb') or exit(1);
            if ($fh) {
                $content = stream_get_contents($fh);
                return json_decode($content, true);
            } else {
                // handle error
            }
            return array();
        }

        // See https://erikberg.com/api/methods Request URL Convention for
        // an explanation
        private function buildURL($host, $sport, $method, $id, $format, $parameters)
        {
            $ary = array($method, $id);
            $path = join('/', preg_grep('/^$/', $ary, PREG_GREP_INVERT));
            $url = 'https://' . $host . '/' . $path . '.' . $format;
            $paramstring = '';
            // Check for parameters and create parameter string
            if (!empty($parameters)) {
                $paramlist = array();
                foreach ($parameters as $key => $value) {
                    array_push($paramlist, rawurlencode($key) . '=' . rawurlencode($value));
                }
                $paramstring .= join('&', $paramlist);
                if (!empty($paramlist)) { $url .= "?" . $paramstring; }
            }
            return $url;
        }

        public function getEventInfo($eventId)
        {
            // Pass method, format, and parameters to build request url
            $url = 'https://' . $this->host . '/nba/boxscore/' . $eventId . '.json';
            // Set the User Agent, Authorization header and allow gzip
            $default_opts = array(
                'http' => array(
                    'user_agent' => self::USER_AGENT,
                    'header'     => array(
                        'Accept-Encoding: gzip',
                        'Authorization: Bearer ' . $this->accessToken
                    )
                )
            );
            stream_context_get_default($default_opts);
            $file = 'compress.zlib://' . $url;
            try {
                $fh = @fopen($file, 'rb');
            } catch (Exception $e) {
                return array();
            }
            if (!$fh) return array();

            $content = stream_get_contents($fh);
            return json_decode($content, true);
        }

        public function getTeamInfo($teamId)
        {
            // Pass method, format, and parameters to build request url
            $url = 'https://' . $this->host . '/nba/team-stats.json?team_id=' . $teamId;
            // Set the User Agent, Authorization header and allow gzip
            $default_opts = array(
                'http' => array(
                    'user_agent' => self::USER_AGENT,
                    'header'     => array(
                        'Accept-Encoding: gzip',
                        'Authorization: Bearer ' . $this->accessToken
                    )
                )
            );
            stream_context_get_default($default_opts);
            $file = 'compress.zlib://' . $url;
            try {
                $fh = @fopen($file, 'rb');
            } catch (Exception $e) {
                return array();
            }
            if (!$fh) return array();

            $content = stream_get_contents($fh);
            return json_decode($content, true);
        }
}
