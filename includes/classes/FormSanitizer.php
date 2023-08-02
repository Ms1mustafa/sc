<?php
class FormSanitizer{

    public static function sanitizeFormString($inputText){
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function formatDate($inputDate) {
        $currentTime = time(); // Current Unix timestamp
        $inputTime = strtotime($inputDate); // Convert input date to Unix timestamp
    
        $timeDiff = $currentTime - $inputTime;
        $minute = 60;
        $hour = 60 * $minute;
        $day = 24 * $hour;
    
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
}
?>