<?php
include_once('includes/config.php');
include_once('includes/classes/constants.php');

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

    public function addRequest($reqNo, $name, $workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $executer, $inspector, $notes, $status)
    {
        if ($reqNo && $name && $workOrderNo && $area && $item && $length && $width && $height && $priority && $workType && $executer && $inspector && $notes && $status) {
            if (empty($this->errorArray)) {
                return $this->insertRequestDetils($reqNo, $name, $workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $executer, $inspector, $notes, $status);
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

    public function insertRequestDetils($reqNo, $name, $workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $executer, $inspector, $notes, $status)
    {

        $query = $this->con->prepare("INSERT INTO request (reqNo, name, workOrderNo, area, item, length, width, height, priority, workType, executer, inspector, notes, status) VALUES (:reqNo, :name, :workOrderNo, :area, :item, :length, :width, :height, :priority, :workType, :executer, :inspector, :notes, :status)");

        $query->bindValue(":reqNo", $reqNo);
        $query->bindValue(":name", $name);
        $query->bindValue(":workOrderNo", $workOrderNo);
        $query->bindValue(":area", $area);
        $query->bindValue(":item", $item);
        $query->bindValue(":length", $length);
        $query->bindValue(":width", $width);
        $query->bindValue(":height", $height);
        $query->bindValue(":priority", $priority);
        $query->bindValue(":workType", $workType);
        $query->bindValue(":executer", $executer);
        $query->bindValue(":inspector", $inspector);
        $query->bindValue(":notes", $notes);
        $query->bindValue(":status", $status);

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

    public function updateExecuterReq($pipeQty, $clampQty, $woodQty, $finishDate, $workOrderNo)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET pipeQty = :pipeQty, clampQty =:clampQty, woodQty =:woodQty, finishDate = :finishDate, new = 'no', executerDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":pipeQty", $pipeQty);
            $query->bindValue(":clampQty", $clampQty);
            $query->bindValue(":woodQty", $woodQty);
            $query->bindValue(":finishDate", $finishDate);
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
        }

        return false;
    }

    public function updateIssuedReq($pipeQty, $clampQty, $woodQty, $pipeQtyStore, $pipeQtyStoreComment, $clampQtyStore, $clampQtyStoreComment, $woodQtyStore, $woodQtyStoreComment, $workOrderNo)
    {
        if (empty($this->errorArray)) {
            $sql = "UPDATE request SET pipeQtyStore = :pipeQtyStore, pipeQtyStoreComment =:pipeQtyStoreComment, clampQtyStore =:clampQtyStore, clampQtyStoreComment = :clampQtyStoreComment, woodQtyStore = :woodQtyStore, woodQtyStoreComment = :woodQtyStoreComment, issued = 'yes', wereHouseDate = :currentDateTime ";

            $sql .= "WHERE workOrderNo = :workOrderNo";
            $query = $this->con->prepare("$sql");

            $query->bindValue(":pipeQtyStore", $pipeQtyStore);
            $query->bindValue(":pipeQtyStoreComment", $pipeQtyStoreComment);
            $query->bindValue(":clampQtyStore", $clampQtyStore);
            $query->bindValue(":clampQtyStoreComment", $clampQtyStoreComment);
            $query->bindValue(":woodQtyStore", $woodQtyStore);
            $query->bindValue(":woodQtyStoreComment", $woodQtyStoreComment);
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

    public function resendToInspector($pipeQty, $clampQty, $woodQty, $workOrderNo)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE request SET status = 'resent', pipeQty = :pipeQty, clampQty =:clampQty, woodQty =:woodQty, resentDate = :currentDateTime
                                        WHERE workOrderNo = :workOrderNo");

            $query->bindValue(":pipeQty", $pipeQty);
            $query->bindValue(":clampQty", $clampQty);
            $query->bindValue(":woodQty", $woodQty);
            $query->bindValue(":workOrderNo", $workOrderNo);
            $query->bindValue(":currentDateTime", $this->currentDateTime);

            return $query->execute();
        }

        return false;
    }

    public function getRequestNumber($name)
    {
        $sql = "SELECT * FROM request ";

        if ($name) {
            $sql .= "WHERE name=:name";
        }

        $query = $this->con->prepare($sql);
        if ($name) {
            $query->bindValue(":name", $name);
        }

        $query->execute();

        return $query->rowCount();
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