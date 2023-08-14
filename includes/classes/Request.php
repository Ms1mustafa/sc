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

        $query = $this->con->prepare("UPDATE request SET finishDate = :finishDate, new = 'no', executerDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

        $query->bindValue(":finishDate", $finishDate);
        $query->bindValue(":workOrderNo", $workOrderNo);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        return $query->execute();
    }
    public function updateWereHouseReq($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment)
    {

        $query = $this->con->prepare("UPDATE request SET issued = 'yes', wereHouseDate = :currentDateTime
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
            $query = $this->con->prepare("UPDATE request SET executerAccept = 'yes', executerAcceptDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
        }

        return false;
    }

    public function updateInspectorReq($status, $rejectReason, $workOrderNo)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET status = :status, rejectReason = :rejectReason, inspectorDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":status", $status);
            $query->bindValue(":rejectReason", $rejectReason);
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
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