<?php
include_once('includes/config.php');
include_once('includes/classes/Constants.php');

class Request
{
    private $con;
    private $currentDateTime;

    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
        $this->currentDateTime = date("Y-m-d H:i:s");
    }

    public function addRequest($reqNo, $adminAddedName, $workOrderNo, $area, $item, $length, $width, $height, $workType, $priority, $executer, $wereHouse, $inspector, $notes)
    {
        $this->validateworkOrderNo($workOrderNo);

        if ($reqNo && $adminAddedName && $workOrderNo && $area && $item && $length && $width && $height && $priority && $workType && $executer && $inspector && $notes) {
            if (empty($this->errorArray)) {
                return $this->insertRequestDetils($reqNo, $adminAddedName, $workOrderNo, $area, $item, $length, $width, $height, $workType, $priority, $executer, $wereHouse, $inspector, $notes);
            }
        } else {
            array_push($this->errorArray, constants::$requestFailed);
        }
        return false;
    }

    public function editRequest($workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $inspector, $notes)
    {
        if ($workOrderNo && $area && $item && $length && $width && $height && $priority && $workType && $inspector && $notes) {
            if (empty($this->errorArray)) {
                return $this->editRequestDetils($workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $inspector, $notes);
            }
        } else {
            array_push($this->errorArray, constants::$requestFailed);
        }
        return false;
    }
    public function executerUpdate($workOrderNo, $itemName, $itemQty, $finishDate)
    {
        if (empty($this->errorArray)) {
            return $this->executerUpdateDetils($workOrderNo, $itemName, $itemQty, $finishDate);
        } else {
            array_push($this->errorArray, constants::$requestFailed);
        }
        return false;
    }
    public function wereHouseUpdate($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment)
    {
        if (empty($this->errorArray)) {
            return $this->updateWereHouseReq($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment);
        } else {
            array_push($this->errorArray, constants::$requestFailed);
        }
        return false;
    }

    public function insertRequestDetils($reqNo, $adminAddedName, $workOrderNo, $area, $item, $length, $width, $height, $workType, $priority, $executer, $wereHouse, $inspector, $notes)
    {
        $query = $this->con->prepare("INSERT INTO request (reqNo, adminAddedName, workOrderNo, area, item, length, width, height, workType, priority, executer, wereHouse, inspector, notes) VALUES (:reqNo, :adminAddedName, :workOrderNo, :area, :item, :length, :width, :height, :workType, :priority, :executer, :wereHouse, :inspector, :notes)");

        $query->bindValue(":reqNo", $reqNo);
        $query->bindValue(":adminAddedName", $adminAddedName);
        $query->bindValue(":workOrderNo", $workOrderNo);
        $query->bindValue(":area", $area);
        $query->bindValue(":item", $item);
        $query->bindValue(":length", $length);
        $query->bindValue(":width", $width);
        $query->bindValue(":height", $height);
        $query->bindValue(":workType", $workType);
        $query->bindValue(":priority", $priority);
        $query->bindValue(":executer", $executer);
        $query->bindValue(":wereHouse", $wereHouse);
        $query->bindValue(":inspector", $inspector);
        $query->bindValue(":notes", $notes);

        return $query->execute();

    }

    public function editRequestDetils($workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $inspector, $notes)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET area = :area, item = :item, length = :length, width = :width, height = :height, priority = :priority, workType = :workType, inspector = :inspector, notes = :notes
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":area", $area);
            $query->bindValue(":item", $item);
            $query->bindValue(":length", $length);
            $query->bindValue(":width", $width);
            $query->bindValue(":height", $height);
            $query->bindValue(":priority", $priority);
            $query->bindValue(":workType", $workType);
            $query->bindValue(":inspector", $inspector);
            $query->bindValue(":notes", $notes);

            return $query->execute();
        }

        return false;
    }
    public function deleteRequest($workOrderNo)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("DELETE FROM request WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":workOrderNo", $workOrderNo);

            return $query->execute();
        }

        return false;
    }

    public function executerUpdateDetils($workOrderNo, $itemName, $itemQty, $finishDate)
    {
        $query = $this->con->prepare("INSERT INTO requestitemdes (workOrderNo, itemName, itemQty) VALUES (:workOrderNo, :itemName, :itemQty)");

        for ($i = 0; $i < count($itemName); $i++) {
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":itemName", $itemName[$i]);
            $query->bindValue(":itemQty", $itemQty[$i]);
            $query->execute();
        }

        $this->updateExecuterReq($finishDate, $workOrderNo);

        return true;
    }

    public function updateExecuterReq($finishDate, $workOrderNo)
    {

        $query = $this->con->prepare("UPDATE request SET finishDate = :finishDate, new = 'no', executerNew = 'no', executerDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

        $query->bindValue(":finishDate", $finishDate);
        $query->bindValue(":workOrderNo", $workOrderNo);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        return $query->execute();
    }
    public function updateWereHouseReq($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment)
    {

        $query = $this->con->prepare("UPDATE request SET issued = 'yes', executerNew = 'yes', wereHouseDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

        $query->bindValue(":workOrderNo", $workOrderNo);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        $this->updateItemsWereHouse($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment);
        return $query->execute();
    }
    public function updateItemsWereHouse($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment)
    {
        $query = $this->con->prepare("UPDATE requestitemdes SET wereHouseQty = :wereHouseQty, wereHouseComment = :wereHouseComment WHERE workOrderNo = :workOrderNo AND itemName = :itemName");

        for ($i = 0; $i < count($itemName); $i++) {
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":itemName", $itemName[$i]);
            $query->bindValue(":wereHouseQty", $wereHouseQty[$i]);
            $query->bindValue(":wereHouseComment", $wereHouseComment[$i]);
            $query->execute();
        }

        return true;
    }

    public function executerAccept($workOrderNo)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET executerAccept = 'yes', executerNew = 'no', executerAcceptDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
        }

        return false;
    }

    public function updateInspectorReq($status, $rejectReason, $workOrderNo, $rejectsNum = 0)
    {
        if (empty($this->errorArray)) {
            $sql = "UPDATE request SET status = :status, rejectReason = :rejectReason, inspectorDate = :currentDateTime ";

            if ($status == 'rejected') {
                $sql .= ", rejectsNum = :rejectsNum , executerNew = 'yes' ";
            }

            $sql .= "WHERE workOrderNo = :workOrderNo ";

            $query = $this->con->prepare($sql);

            $query->bindValue(":status", $status);
            $query->bindValue(":rejectReason", $rejectReason);
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            if ($status == 'rejected') {
                $query->bindValue(":rejectsNum", $rejectsNum);
            }

            return $query->execute();
        }

        return false;
    }

    public function updateRejectExecuter($workOrderNo, $itemName, $itemQty, $rejectsNum)
    {
        $query = $this->con->prepare("INSERT INTO rejectitemdes (workOrderNo, itemName, itemQty, rejectsNum) VALUES (:workOrderNo, :itemName, :itemQty, :rejectsNum)");

        for ($i = 0; $i < count($itemName); $i++) {
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":rejectsNum", $rejectsNum);
            $query->bindValue(":itemName", $itemName[$i]);
            $query->bindValue(":itemQty", $itemQty[$i]);
            $query->execute();
        }

        $query2 = $this->con->prepare("UPDATE request SET status = 'resent', executerNew = 'no', executerDate = :currentDateTime WHERE workOrderNo = :workOrderNo");
        $query2->bindValue(":workOrderNo", $workOrderNo);
        $query2->bindValue(":currentDateTime", $this->currentDateTime);
        $query2->execute();

        return true;
    }
    public function updateRejectWerehouse($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment, $rejectsNum)
    {
        $query = $this->con->prepare("UPDATE rejectitemdes SET wereHouseQty = :wereHouseQty, wereHouseComment = :wereHouseComment WHERE workOrderNo = :workOrderNo AND itemName = :itemName AND rejectsNum = :rejectsNum");

        for ($i = 0; $i < count($itemName); $i++) {
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":rejectsNum", $rejectsNum[$i]);
            $query->bindValue(":itemName", $itemName[$i]);
            $query->bindValue(":wereHouseQty", $wereHouseQty[$i]);
            $query->bindValue(":wereHouseComment", $wereHouseComment[$i]);

            $query->execute();
        }

        $query2 = $this->con->prepare("UPDATE request SET status = 'backExecuter', executerNew = 'yes', wereHouseDate = :currentDateTime WHERE workOrderNo = :workOrderNo");
        $query2->bindValue(":workOrderNo", $workOrderNo);
        $query2->bindValue(":currentDateTime", $this->currentDateTime);
        $query2->execute();

        return true;
    }

    public function resendToInspector($workOrderNo)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET status = 'resentInspector', executerNew = 'no', resentDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
        }

        return false;
    }
    public function transfer($newUser , $type, $workOrderNo)
    {
        if (empty($this->errorArray)) {
            $sql = "UPDATE request SET ";

            if($type == 'executer'){
                $sql .= "executer = :newUser ";
            }
            if($type == 'wereHouse'){
                $sql .= "wereHouse = :newUser ";
            }

            $sql .= "WHERE workOrderNo = :workOrderNo";

            $query = $this->con->prepare($sql);

            $query->bindValue(":newUser", $newUser);
            $query->bindValue(":workOrderNo", $workOrderNo);

            return $query->execute();
        }

        return false;
    }
    public function dismantling($qtyBackStatus, $workOrderNo, $rejectsNum = null, $itemName = null, $qtyBack = null, $qtyBackType = null)
{
    if (empty($this->errorArray)) {
        try {
            $this->con->beginTransaction(); // Start transaction

            $sql = "UPDATE request SET qtyBackStatus = :qtyBackStatus , qtyBackDate = :currentDateTime";

            // Add executerNew condition based on qtyBackStatus
            if ($qtyBackStatus === 'executer') {
                $sql .= ", executerNew = 'yes'";
            } elseif ($qtyBackStatus === 'wereHouse') {
                $sql .= ", executerNew = 'no'";
            }

            $sql .= " WHERE workOrderNo = :workOrderNo";

            $query = $this->con->prepare($sql);
            $query->bindValue(":qtyBackStatus", $qtyBackStatus);
            $query->bindValue(":currentDateTime", $this->currentDateTime);
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->execute();

            if ($qtyBackStatus == 'done') {
                $sql2 = "UPDATE $qtyBackType SET qtyBack = :qtyBack WHERE workOrderNo = :workOrderNo AND itemName = :itemName ";
                if ($qtyBackType == 'rejectitemdes') {
                    $sql2 .= "AND rejectsNum = :rejectsNum";
                }
                $query2 = $this->con->prepare("$sql2");

                for ($i = 0; $i < count($itemName); $i++) {
                    $query2->bindValue(":workOrderNo", $workOrderNo);
                    if ($qtyBackType == 'rejectitemdes') {
                        $query2->bindValue(":rejectsNum", $rejectsNum[$i]);
                    }
                    $query2->bindValue(":itemName", $itemName[$i]);
                    $query2->bindValue(":qtyBack", $qtyBack[$i]);
                    $query2->execute();
                }
            }

            $this->con->commit(); // Commit the transaction

            return true;
        } catch (PDOException $e) {
            $this->con->rollBack(); // Rollback the transaction if an error occurs
            // Handle the error here or log it
            return false;
        }
    }
    return false;
}



    public function validateworkOrderNo($workOrderNo)
    {
        $query = $this->con->prepare('SELECT * FROM request WHERE workOrderNo = :workOrderNo');
        $query->bindValue(':workOrderNo', $workOrderNo);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$workOrderNoTaken);
        }
    }

    public function getRequestDetails($workOrderNo = null)
    {
        $sql = "SELECT * FROM request ";

        if ($workOrderNo) {
            $sql .= "WHERE workOrderNo=:workOrderNo";
        }

        $query = $this->con->prepare($sql);

        if ($workOrderNo) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }

        $query->execute();

        $array = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $array = $row;
        }

        return $array;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }
}
?>