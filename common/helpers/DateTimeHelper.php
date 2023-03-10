<?php

namespace common\helpers;

class DateTimeHelper
{

    public static function getDateString($datetime)
    {
        $posted_at = strtotime($datetime);
        $date = date('Y-m-d', $posted_at);
        return $date;
    }

    public static function getTimeString($datetime)
    {
        $posted_at = strtotime($datetime);
        $time = date('H:m', $posted_at);
        return $time;
    }

    public static function getDateTimeString($datetime)
    {
        $posted_at = strtotime($datetime);
        $date = date('Y-m-d', $posted_at);
        $time = date('H:m', $posted_at);
        return "$date $time";
    }
}
