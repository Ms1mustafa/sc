<?php
include_once('../includes/config.php');
include_once('../includes/classes/constants.php');

class Requests
{
    public static function getRequest($con, $isNotification = null, $isQty = null, $workOrderNo = null, $store = null, $admin = null, $inspector = null, $name = null, $executer = null)
{
    $sql = "SELECT * FROM request ";

    $whereClause = [];

    if ($isQty) {
        $whereClause[] = "workOrderNo = :workOrderNo ";
    }

    if ($store) {
        $whereClause[] = "finishDate != '0000:00:00' AND issued != 'yes' ";
    }

    if ($admin) {
        $whereClause[] = "executerAccept = 'yes' AND name = :name ";
    }

    if ($inspector) {
        $whereClause[] = "executerAccept = 'yes' AND inspector = :inspector AND status != 'accepted' AND status != 'rejected' ";
    }
    
    if($executer){
        $whereClause[] = "executerAccept != 'yes' OR status = 'rejected' ";
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
        $sql .= " ORDER BY GREATEST(COALESCE(reqDate, '0000-00-00'), COALESCE(wereHouseDate, '0000-00-00'), COALESCE(inspectorDate, '0000-00-00')) DESC";
        }

    $query = $con->prepare($sql);

    if ($isQty) {
        $query->bindValue(":workOrderNo", $workOrderNo);
    }

    if ($admin) {
        $query->bindValue(":name", $name);
    }
    if ($inspector) {
        $query->bindValue(":inspector", $inspector);
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