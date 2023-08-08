<?php
include_once('../includes/config.php');
include_once('../includes/classes/constants.php');

class Inspectors
{
    public static function Inspectors($con, $area)
    {
        $sql = "SELECT * FROM users WHERE area=:area";

        $query = $con->prepare($sql);
        $query->bindValue(":area", $area);

        $query->execute();

        $html = "<option disabled selected value=''>select inspector</option>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $email = $row["email"];
            $name = $row["username"];
            $html .= "<option value='$email'>$name</option>";
        }

        return $html;
    }
}
?>