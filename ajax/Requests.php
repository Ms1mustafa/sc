<?php
include_once('../includes/config.php');
include_once('../includes/classes/Constants.php');

class Requests
{
    public static function getAdminRequests($con, $isNoti = null, $admin, $workOrderNo = null)
    {
        $sql = "SELECT * FROM request ";

        $whereClause = [];
        if (!$isNoti) {
            $whereClause[] = "workOrderNo = :workOrderNo ";
        }

        $whereClause[] = "status = 'accepted' AND adminAddedName = :admin AND (qtyBackStatus = 'no' OR qtyBackStatus = 'done') OR (status = 'rejected' AND inspectorDate IS NULL AND qtyBackStatus = 'no') ";
        //hh

        if (!empty($whereClause)) {
            $sql .= "WHERE " . implode(" AND ", $whereClause);

            // $sql .= " ORDER BY inspectorDate DESC";
            $sql .= "ORDER BY GREATEST(COALESCE(inspectorDate, '0000-00-00'), COALESCE(executerDate, '0000-00-00')) DESC";
        }

        $query = $con->prepare($sql);

        $query->bindValue(":admin", $admin);

        if (!$isNoti) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($isNoti) {
                $array[] = $row;
            } else {
                $array = $row;
            }
        }

        return $array;
    }


    public static function getRequestsAction($con, $isNoti = null, $admin, $workOrderNo = null)
    {
        $sql = "SELECT * FROM request WHERE executerDate IS NULL AND adminAddedName = :adminAddedName ";

        if (!$isNoti) {
            $sql .= "workOrderNo = :workOrderNo ";
        }

        $sql .= "ORDER BY reqDate DESC";

        $query = $con->prepare($sql);

        $query->bindValue(":adminAddedName", $admin);

        if (!$isNoti) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($isNoti) {
                $array[] = $row;
            } else {
                $array = $row;
            }
        }

        return $array;
    }

    public static function getExecuterRequests($con, $isNoti = null, $executer, $workOrderNo = null)
    {
        $sql = "SELECT * FROM request ";

        $whereClause = [];

        $whereClause[] = "(executerAccept != 'yes' OR status = 'rejected' OR status = 'backExecuter' OR qtyBackStatus = 'executer') AND executerNew = 'yes'";
        $whereClause[] = "executer = :executer ";

        if (!$isNoti) {
            $whereClause[] = "workOrderNo = :workOrderNo ";
        }

        if (!empty($whereClause)) {
            $sql .= "WHERE " . implode(" AND ", $whereClause);

            $sql .= "ORDER BY GREATEST(COALESCE(reqDate, '0000-00-00'), COALESCE(wereHouseDate, '0000-00-00'), COALESCE(inspectorDate, '0000-00-00'), COALESCE(qtyBackDate, '0000-00-00')) DESC";
        }
        ;

        $query = $con->prepare($sql);

        $query->bindValue(":executer", $executer);
        if (!$isNoti) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($isNoti) {
                $array[] = $row;
            } else {
                $array = $row;
            }
        }

        return $array;
    }

    public static function getWereHouseRequests($con, $isNoti = null, $wereHouse, $workOrderNo = null)
    {
        $sql = "SELECT * FROM request ";

        $whereClause = [];

        $whereClause[] = "(finishDate != '0000:00:00' AND issued != 'yes' OR status = 'resent' OR qtyBackStatus = 'wereHouse') ";
        $whereClause[] = "wereHouse = :wereHouse ";
        if (!$isNoti) {
            $whereClause[] = "workOrderNo = :workOrderNo ";
        }

        if (!empty($whereClause)) {
            $sql .= "WHERE " . implode(" AND ", $whereClause);

            $sql .= "ORDER BY GREATEST(COALESCE(executerDate, '0000-00-00'), COALESCE(qtyBackDate, '0000-00-00')) DESC";
        }
        ;

        $query = $con->prepare($sql);

        $query->bindValue(":wereHouse", $wereHouse);
        if (!$isNoti) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }


        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($isNoti) {
                $array[] = $row;
            } else {
                $array = $row;
            }
        }

        return $array;
    }

    public static function getInspectorRequests($con, $isNoti = null, $inspector, $workOrderNo = null)
    {
        $sql = "SELECT * FROM request ";

        $whereClause = [];

        $whereClause[] = "executerAccept = 'yes' AND inspector = :inspector AND status != 'accepted' AND status != 'rejected' AND status != 'resent' AND status != 'backExecuter'";
        if (!$isNoti) {
            $whereClause[] = "workOrderNo = :workOrderNo ";
        }
        if (!empty($whereClause)) {
            $sql .= "WHERE " . implode(" AND ", $whereClause);

            $sql .= "ORDER BY 
            CASE WHEN status = 'resent' THEN 0 ELSE 1 END, 
            GREATEST(COALESCE(wereHouseDate, '0000-00-00'), COALESCE(resentDate, '0000-00-00')) DESC";
        }
        ;


        $query = $con->prepare($sql);


        $query->bindValue(":inspector", $inspector);
        if (!$isNoti) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($isNoti) {
                $array[] = $row;
            } else {
                $array = $row;
            }
        }

        return $array;
    }

    public static function getItemsDes($con, $workOrderNo = null)
    {
        $sql = "SELECT * FROM rejectitemdes WHERE workOrderNo = :workOrderNo";

        $query = $con->prepare($sql);

        $query->bindValue(":workOrderNo", $workOrderNo);

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        return $array;
    }

    public static function getWereHouseItems($con, $workOrderNo = null)
    {
        $sql = "SELECT * FROM werehouseback WHERE workOrderNo = :workOrderNo";

        $query = $con->prepare($sql);

        $query->bindValue(":workOrderNo", $workOrderNo);

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        return $array;
    }

    public static function getRejectItemsDes($con, $workOrderNo = null, $last = null)
    {
        $sql = "SELECT * FROM rejectitemdes WHERE workOrderNo = :workOrderNo ";

        if ($last) {
            $sql .= "AND rejectsNum = (SELECT MAX(rejectsNum) FROM rejectitemdes WHERE workOrderNo = :workOrderNo)";
        }

        $query = $con->prepare($sql);

        $query->bindValue(":workOrderNo", $workOrderNo);

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        return $array;
    }

    public static function getRequest($con, $workOrderNo)
    {
        $sql = "SELECT * FROM request WHERE workOrderNo =:workOrderNo";


        $query = $con->prepare($sql);

        $query->bindValue(":workOrderNo", $workOrderNo);

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $array = $row;
        }

        return $array;
    }
}


?>