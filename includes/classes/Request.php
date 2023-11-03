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
    public function executerUpdate($workOrderNo, $itemName, $itemQty, $rejectsNum, $finishDate)
    {
        if (empty($this->errorArray)) {
            return $this->executerUpdateDetils($workOrderNo, $itemName, $itemQty, $rejectsNum, $finishDate);
        } else {
            array_push($this->errorArray, constants::$requestFailed);
        }
        return false;
    }
    public function executerReject($workOrderNo, $rejectReason)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET status = 'rejected', rejectReason = :rejectReason, executerDate = :currentDateTime, new = 'no', executerNew = 'no'
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":rejectReason", $rejectReason);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
        }

        return false;
    }
    public function wereHouseUpdate($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment)
    {
        if (empty($this->errorArray)) {
            return $this->updateWereHouseReq($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment);
        } else {
            array_push($this->errorArray, constants::$requestFailed);
        }
        return false;
    }

    public function insertRequestDetils($reqNo, $adminAddedName, $workOrderNo, $area, $item, $length, $width, $height, $workType, $priority, $executer, $wereHouse, $inspector, $notes)
    {
        $query = $this->con->prepare("INSERT INTO request (reqNo, adminAddedName, workOrderNo, area, item, length, width, height, workType, priority, executer, wereHouse, inspector, notes, reqDate) VALUES (:reqNo, :adminAddedName, :workOrderNo, :area, :item, :length, :width, :height, :workType, :priority, :executer, :wereHouse, :inspector, :notes, :currentDateTime)");

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
        $query->bindValue(":currentDateTime", $this->currentDateTime);

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

    public function executerUpdateDetils($workOrderNo, $itemName, $itemQty, $rejectsNum, $finishDate)
    {
        $query = $this->con->prepare("INSERT INTO rejectitemdes (workOrderNo, itemName, itemQty, rejectsNum) VALUES (:workOrderNo, :itemName, :itemQty, :rejectsNum)");

        if (!$itemName)
            return;
        for ($i = 0; $i < count($itemName); $i++) {
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":rejectsNum", $rejectsNum);
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
    public function updateWereHouseReq($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment)
    {

        $query = $this->con->prepare("UPDATE request SET issued = 'yes', executerNew = 'yes', wereHouseDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

        $query->bindValue(":workOrderNo", $workOrderNo);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        $this->updateItemsWereHouse($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment);
        return $query->execute();
    }
    public function updateItemsWereHouse($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment)
    {
        $query = $this->con->prepare("UPDATE rejectitemdes SET wereHouseQty = :wereHouseQty, wereHouseComment = :wereHouseComment WHERE workOrderNo = :workOrderNo AND itemName = :itemName AND rejectsNum = :rejectsNum");

        for ($i = 0; $i < count($itemName); $i++) {
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":itemName", $itemName[$i]);
            $query->bindValue(":wereHouseQty", $wereHouseQty[$i]);
            $query->bindValue(":wereHouseComment", $wereHouseComment[$i]);
            $query->bindValue(":rejectsNum", $rejectsNum[$i]);
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
    public function transfer($newUser, $type, $workOrderNo)
    {
        if (empty($this->errorArray)) {
            $sql = "UPDATE request SET ";

            if ($type == 'executer') {
                $sql .= "executer = :newUser ";
            }
            if ($type == 'wereHouse') {
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
    public function dismantling($qtyBackStatus, $workOrderNo, $rejectsNum = null, $itemName = null, $qtyBack = null, $qtyBackType = null, $wereHouseItemName = null, $wereHouseComment = null, $wereHouseItemQty = null)
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
                } elseif ($qtyBackStatus === 'done') {
                    $sql .= ", executerNew = 'yes'";
                }

                $sql .= " WHERE workOrderNo = :workOrderNo";

                $query = $this->con->prepare($sql);
                $query->bindValue(":qtyBackStatus", $qtyBackStatus);
                $query->bindValue(":currentDateTime", $this->currentDateTime);
                $query->bindValue(":workOrderNo", $workOrderNo);
                $query->execute();

                if ($qtyBackStatus == 'done') {
                    $sql2 = "INSERT INTO werehouseback (workOrderNo, itemName, wereHouseComment, qtyBack) VALUES (:workOrderNo, :itemName, :wereHouseComment, :qtyBack)";

                    $query2 = $this->con->prepare($sql2);

                    for ($i = 0; $i < count($itemName); $i++) {
                        $query2->bindValue(":workOrderNo", $workOrderNo);
                        $query2->bindValue(":itemName", $wereHouseItemName[$i]);
                        $query2->bindValue(":wereHouseComment", $wereHouseComment[$i]);
                        $query2->bindValue(":qtyBack", $wereHouseItemQty[$i]);
                        $query2->execute();
                    }

                    $sql3 = "UPDATE rejectitemdes SET qtyBack = :qtyBack WHERE workOrderNo = :workOrderNo AND itemName = :itemName";
                    $query3 = $this->con->prepare($sql3);

                    for ($i = 0; $i < count($itemName); $i++) {
                        $query3->bindValue(":workOrderNo", $workOrderNo);
                        // $query3->bindValue(":rejectsNum", $rejectsNum[$i]);
                        $query3->bindValue(":itemName", $itemName[$i]);
                        $query3->bindValue(":qtyBack", $qtyBack[$i]);
                        $query3->execute();
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

    public function requesterDone($workOrderNo, $qtyBackStatus, $rejected = null)
    {
        $sql = "UPDATE request SET qtyBackStatus = :qtyBackStatus WHERE workOrderNo = :workOrderNo";
        if ($rejected)
            $sql = "UPDATE request SET qtyBackStatus = 'done' WHERE workOrderNo = :workOrderNo";
        $query = $this->con->prepare($sql);

        $query->bindValue(":workOrderNo", $workOrderNo);
        if (!$rejected)
            $query->bindValue(":qtyBackStatus", $qtyBackStatus);

        return $query->execute();
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

    public function getRequestDetails($workOrderNo = null, $byRequester = null)
    {
        $sql = "SELECT * FROM request ";

        if ($workOrderNo) {
            $sql .= "WHERE workOrderNo=:workOrderNo";
        }
        if ($byRequester)
            $sql .= "WHERE adminAddedName=:byRequester";

        $query = $this->con->prepare($sql);

        if ($workOrderNo) {
            $query->bindValue(":workOrderNo", $workOrderNo);
        }
        if ($byRequester) {
            $query->bindValue(":byRequester", $byRequester);
        }

        $query->execute();

        $array = array();

        if (!$workOrderNo) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
        } else {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $array = $row;
            }
        }

        return $array;
    }

    public function getAllRequests($status = false)
    {

        $sql = "SELECT * FROM request ";

        if ($status === 'accepted' || $status === 'rejected') {
            $sql .= "WHERE status = :status ";
        } elseif ($status === 'done') {
            $sql .= "WHERE qtyBackStatus = :status ";
        } elseif ($status === true) {
            $sql .= "WHERE status = 'accepted' AND qtyBackStatus != 'done' AND qtyBackStatus != 'no' ";
        }



        $query = $this->con->prepare($sql);

        if ($status && $status !== true) {
            $query->bindValue(":status", $status);
        }

        $query->execute();

        $rows = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function getReqNum()
    {
        $sql = "SELECT reqNo FROM request ORDER BY reqNo DESC LIMIT 1;";

        $query = $this->con->prepare($sql);

        $query->execute();

        $reqNo = $query->fetchColumn();

        return $reqNo;

    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }
}
?>