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

    public static function buildUrl($page, $subpage, array $params = array())
    {
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
        if ($page) {
            $baseUrl = trim($baseUrl, '/') . '/' . $page;
        }
        if ($subpage) {
            $baseUrl = $baseUrl . '/' . $subpage;
        }

        $query = http_build_query($params);

        return $baseUrl . '?' . $query;
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

        return '<span class="label label-info">' . $time->format('l, m/d/Y') . '</span> - <span class="label label-info">' . $end->format('l, m/d/Y') . '</span>';
    }
}

