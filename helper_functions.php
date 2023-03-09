<?php

    function validate_date ($date) {
        return filter_var($date, FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^\d{4}-\d{2}-\d{2}$/"
            ]
        ]);
    }

    function validate_time ($time) {
        return filter_var($time, FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^\d{2}:\d{2}$/"
            ]
        ]);
    }

    function sanitize_date ($date) {
        $date = strtotime($date);

        if (!$date) return false;

        return date("Y-m-d", $date);
    }

    function sanitize_time ($time) {
        $time = strtotime($time);

        if (!$time) return false;

        return date("H:i", $time);
    }

?>