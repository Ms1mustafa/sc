<?php
include_once('../includes/config.php');
include_once('../includes/classes/Constants.php');

class Items
{
    public static function items($con, $areaId)
    {
        $sql = "SELECT * FROM areaitems WHERE areaId=:areaId";

        $query = $con->prepare($sql);
        $query->bindValue(":areaId", $areaId);

        $query->execute();

        $html = "<option disabled selected value=''>select location</option>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["number"];
            $name = $row["name"];
            $html .= "<option value='$name'>$name</option>";
        }

        return $html;
    }
}
?>