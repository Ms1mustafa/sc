<?php
include_once('../includes/config.php');
include_once('../includes/classes/constants.php');

class Requests
{
    public static function getRequest($con, $isNotification = null, $isQty = null, $workOrderNo = null, $store = null, $admin = null, $inspector = null)
{
    $sql = "SELECT * FROM request ";

    $whereClause = [];

    if ($isQty) {
        $whereClause[] = "workOrderNo = :workOrderNo";
    }

    if ($store) {
        $whereClause[] = "finishDate != '0000:00:00' ";
    }

    if ($admin) {
        $whereClause[] = "issued = 'no'";
    }

    if ($inspector) {
        $whereClause[] = "executerAccept = 'yes'";
    }

    if (!empty($whereClause)) {
        $sql .= "WHERE " . implode(" AND ", $whereClause);

        if ($store) {
            $sql .= " ORDER BY COALESCE(executerDate, '0000-00-00') DESC";

        }
        else if ($inspector) {
            $sql .= " ORDER BY 
            CASE WHEN status = 'resent' THEN 0 ELSE 1 END, 
            GREATEST(COALESCE(wereHouseDate, '0000-00-00'), COALESCE(resentDate, '0000-00-00')) DESC";

        } 
    }else {
            $sql .= " ORDER BY CASE WHEN status = 'rejected' THEN 0 ELSE 1 END, GREATEST(COALESCE(reqDate, '0000-00-00'), COALESCE(wereHouseDate, '0000-00-00')) DESC";
        }

    $query = $con->prepare($sql);

    if ($isQty) {
        $query->bindValue(":workOrderNo", $workOrderNo);
    }

    $query->execute();

    $array = array();

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        if ($isNotification == true) {
            $array[] = $row;
        }
        if ($isQty == true) {
            $array = $row;
        }
    }

    return $array;
}

}
?>