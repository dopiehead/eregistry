<?php
    function timeAgo($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;

    if ($seconds <= 60) {
        return "Just now";
    } elseif ($seconds <= 3600) {
        return floor($seconds / 60) . " minutes ago";
    } elseif ($seconds <= 86400) {
        return floor($seconds / 3600) . " hour(s) ago";
    } elseif ($seconds <= 604800) {
        return floor($seconds / 86400) . " days ago";
    } elseif ($seconds <= 2419200) {
        return floor($seconds / 604800) . " weeks ago";
    } elseif ($seconds <= 29030400) {
        return floor($seconds / 2419200) . " months ago";
    } else {
        return floor($seconds / 29030400) . " years ago";
    }
}
