<?php

class ItemDes
{
    public static function ItemDes($con)
    {
        $sql = "SELECT * FROM itemdes";

        $query = $con->prepare($sql);

        $query->execute();

        $html = "";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $name = $row["name"];
            $html .= "<option value='$name'>$name</option>";
        }

        return $html;
    }
}
?>