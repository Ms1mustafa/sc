<?php
class FormSanitizer
{

    public static function sanitizeFormString($inputText)
    {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText)
    {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function formatDate($inputDate)
    {
        $currentTime = time(); // Current Unix timestamp
        $inputTime = strtotime($inputDate); // Convert input date to Unix timestamp

        $timeDiff = $currentTime - $inputTime;
        $minute = 60;
        $hour = 60 * $minute;
        $day = 24 * $hour;

        if ($inputDate === null)
            return $inputDate;

        if ($timeDiff < $minute) {
            return "Just now";
        } elseif ($timeDiff < $hour) {
            $minutesAgo = floor($timeDiff / $minute);
            return $minutesAgo . " min ago";
        } elseif ($timeDiff < 2 * $hour) {
            return "An hour ago";
        } elseif ($timeDiff < $day) {
            $hoursAgo = floor($timeDiff / $hour);
            return $hoursAgo . " hours ago";
        } elseif ($timeDiff < 2 * $day) {
            return "Yesterday";
        } else {
            return date("d M Y", $inputTime); // Format as 'day month year' (e.g., 22 Jul 2023)
        }
    }

    public static function formatMonthYear($inputDate)
    {
        $inputTime = strtotime($inputDate); // Convert input date to Unix timestamp

        if ($inputDate === null) {
            return $inputDate;
        }

        return date("M Y", $inputTime); // Format as 'month year' (e.g., Jan 2023)
    }

    public static function formatTimeDifference($startDate, $endDate)
    {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        if ($startTimestamp === false || $endTimestamp === false) {
            return "Invalid date format";
        }

        $timeDiff = $endTimestamp - $startTimestamp;
        $minute = 60;
        $hour = 60 * $minute;
        $day = 24 * $hour;

        if ($timeDiff < $minute) {
            return "Just now";
        } elseif ($timeDiff < $hour) {
            $minutesAgo = floor($timeDiff / $minute);
            return $minutesAgo . " min";
        } elseif ($timeDiff < 2 * $hour) {
            return "An hour";
        } elseif ($timeDiff < $day) {
            $hoursAgo = floor($timeDiff / $hour);
            return $hoursAgo . " hours";
        } elseif ($timeDiff < 2 * $day) {
            return "24 hours";
        } else {
            $daysAgo = floor($timeDiff / $day);
            return $daysAgo . " day" . ($daysAgo > 1 ? 's' : '');
        }
    }


}
?>