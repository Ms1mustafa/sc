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
    public function executerUpdate($workOrderNo, $itemName, $itemQty, $finishDate)
    {
        if (empty($this->errorArray)) {
            return $this->executerUpdateDetils($workOrderNo, $itemName, $itemQty, $finishDate);
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


    public function validateworkOrderNo($workOrderNo)
    {
        $query = $this->con->prepare('SELECT * FROM request WHERE workOrderNo = :workOrderNo');
        $query->bindValue(':workOrderNo', $workOrderNo);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$workOrderNoTaken);
        }
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }
}
?>