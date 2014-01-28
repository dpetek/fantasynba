<?php

class Helpers
{
    public static $weeks = array(
        "week_10_28_2013",
        "week_11_04_2013",
        "week_11_11_2013",
        "week_11_18_2013",
        "week_11_25_2013",
        "week_12_02_2013",
        "week_12_09_2013",
        "week_12_16_2013",
        "week_12_23_2013",
        "week_12_30_2013",

        "week_01_06_2014",
        "week_01_13_2014",
        "week_01_20_2014",
        "week_01_27_2014",

        "week_02_03_2014",
        "week_02_10_2014",
        "week_02_17_2014",
        "week_02_24_2014",

        "week_03_03_2014",
        "week_03_10_2014",
        "week_03_17_2014",
        "week_03_24_2014",
        "week_03_31_2014",

        "week_04_07_2014",
        "week_04_14_2014",
        "week_04_21_2014",
        "week_04_28_2014"
    );

    public static function buildUrl($page, array $params = array())
    {
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
        if ($page) {
            $baseUrl = trim($baseUrl, '/') . '/' . $page;
        }

        $query = http_build_query($params);

        return $baseUrl . '?' . $query;
    }

    public static function buildTeamStatsLink($teamId)
    {
        return self::buildUrl('teamStats', array('team_id' => $teamId));
    }

    public static function buildPlayerStatsLink($linkName)
    {
        return self::buildUrl('playerStats', array('player' => $linkName));
    }

    public static function getRoute($url)
    {
        $parts = parse_url($url);
        $path = trim($parts['path'], '/');
        return $path;
    }

    public static function getPreviousWeek($weekId)
    {
        $pos = array_search($weekId, self::$weeks);
        if ($pos===false || $pos <= 0) {
            return false;
        }
        return self::$weeks[$pos - 1];
    }

    public static function getNextWeek($weekId)
    {
        $pos = array_search($weekId, self::$weeks);
        if ($pos===false || $pos + 1 == count(self::$weeks)) {
            return false;
        }
        return self::$weeks[$pos + 1];
    }

    public static function formatDateString($dateString)
    {
        $pos = strpos($dateString, 'T');
        $dateString = substr($dateString, 0, $pos);
        $date = DateTime::createFromFormat('Y-m-d', $dateString);
        return $date->format('l, m/d/Y');
    }

    public static function getWeekString($weekId)
    {
        $date = substr($weekId,5);
        $time = DateTime::createFromFormat('m_d_Y',$date);
        $end = DateTime::createFromFormat('m_d_Y',$date);
        $end->add(new DateInterval('P6D'));
        return "<span>Week:
                    <span class='badge'>{$time->format('m')}</span>
                    <span class='badge'>{$time->format('d')}</span>
                    <span class='badge'>{$time->format('Y')}</span>
                    -
                    <span class='badge'>{$end->format('m')}</span>
                    <span class='badge'>{$end->format('d')}</span>
                    <span class='badge'>{$end->format('Y')}</span>
                </span>";

        return '<span class="">' . $time->format('l, m/d/Y') . '</span> - <span class="">' . $end->format('l, m/d/Y') . '</span>';
    }
    public static function getPlayers()
    {
        $draw = Config::get('draw');
        return array_keys($draw);
    }

    public static function getOverallFantasyStats()
    {

        $playerMatches = array();
        $playerWins = array();
        $playerLoses = array();
        $playerDraws = array();
        foreach(self::getPlayers() as $player) {
            $playerWins[$player] = 0;
            $playerLoses[$player] = 0;
            $playerDraws[$player] = 0;
            foreach(self::getPlayers() as $player2) {
                if ($player == $player2) continue;
                if ($player < $player2) {
                    $p1 = $player;
                    $p2 = $player2;
                } else {
                    $p1 = $player2;
                    $p2 = $player;
                }
                $playerMatches[$p1][$p2] = array(
                    'wins' => 0,
                    'loses' => 0,
                    'draws' => 0
                );
            }
        }

        foreach(self::$weeks as $weekId) {
            if ($weekId == WeeklyStats::currentWeekId()) {
                break;
            }
            $fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId));
            $weekMatches = MongoHelper::getWeekFantasyMatches($weekId);

            foreach($weekMatches->getMatches() as $match) {
                $player1Stats = $fantasyStats->getForPlayer($match['player1']);
                $player2Stats = $fantasyStats->getForPlayer($match['player2']);

                if (abs($player1Stats->getRatio() - $player2Stats->getRatio()) < 0.000000001) {
                    $playerDraws[$player1Stats->getPlayerName()] += 1;
                    $playerDraws[$player2Stats->getPlayerName()] += 1;
                    if ($player1Stats->getPlayerName() < $player2Stats->getPlayerName()) {
                        $playerMatches[$player1Stats->getPlayerName()][$player2Stats->getPlayerName()]['draws'] += 1;
                    } else {
                        $playerMatches[$player2Stats->getPlayerName()][$player1Stats->getPlayerName()]['draws'] += 1;
                    }
                } elseif ((abs($player1Stats->getRatio() - $player2Stats->getRatio()) < 0.000000001 && $player1Stats->getWins() > $player2Stats->getWins()) ||
                     $player1Stats->getRatio() > $player2Stats->getRatio()) {
                    $playerWins[$player1Stats->getPlayerName()] += 1;
                    $playerLoses[$player2Stats->getPlayerName()] += 1;
                    if ($player1Stats->getPlayerName() < $player2Stats->getPlayerName()) {
                        $playerMatches[$player1Stats->getPlayerName()][$player2Stats->getPlayerName()]['wins'] += 1;
                    } else {
                        $playerMatches[$player2Stats->getPlayerName()][$player1Stats->getPlayerName()]['loses'] += 1;
                    }
                } else {
                    $playerWins[$player2Stats->getPlayerName()] += 1;
                    $playerLoses[$player1Stats->getPlayerName()] += 1;
                    if ($player1Stats->getPlayerName() < $player2Stats->getPlayerName()) {
                        $playerMatches[$player1Stats->getPlayerName()][$player2Stats->getPlayerName()]['loses'] += 1;
                    } else {
                        $playerMatches[$player2Stats->getPlayerName()][$player1Stats->getPlayerName()]['wins'] += 1;
                    }
                }
            }
        }
        $players = self::getPlayers();
        return new FantasyOverall($players, $playerWins, $playerLoses, $playerDraws, $playerMatches);
    }
    public static function teamString(Team $team)
    {
        $stats = $team->getStats();
        return '<ul class="list-unstyled">' .
                  '<li>' . $team->getFullName() . '</li>' . 
                  '<li>' . ' <span class="badge" style="background-color: #088A85">$' . $team->getCost() . '</span><span class="badge" style="background-color: #088A85">' .$stats['won'] . '-' . $stats['lost'] . '</span>' . '</li>' .
                '</ul>'; 
        return $team->getFullName() . ' <span class="badge">$' . $team->getCost() . '</span><span class="badge">' .$stats['won'] . '-' . $stats['lost'] . '</span>';
    }

    public static function sortTeamsByPayout($teams)
    {
        $filter = array();
        foreach($teams as $team) {
            if ($team instanceof Team) $filter[] = $team;
        }
        usort($filter, function($t1, $t2) {
                return ($t1->getPayout() > $t2->getPayout()) ? -1 : 1;
            }
        );
        return $filter;
    }

    public static function sortTeamsByRatio($teams)
    {
        $filter = array();
        foreach($teams as $team) {
            if ($team instanceof Team) $filter[] = $team;
        }
        usort($filter, function($t1, $t2) {
                $s1 = $t1->getStats();
                $s2 = $t2->getStats();
                $r1 = 1.0 * intval($s1['won']) / (intval($s1['won'] + intval($s1['lost'])));
                $r2 = 1.0 * intval($s2['won']) / (intval($s2['won'] + intval($s2['lost'])));
                return ($r1 > $r2) ? -1 : 1;
            }
        );
        return $filter;
    }

}

