<?php
include_once('includes/config.php');
include_once('includes/classes/Constants.php');

class Area
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function addArea($ai, $an)
    {

        if (empty($this->errorArray)) {
            return $this->insertAreaDetils($ai, $an);
        }

        return false;
    }

    public function addItem($id, $ai, $nm)
    {

        if (empty($this->errorArray)) {
            return $this->insertItemDetils($id, $ai, $nm);
        }

        return false;
    }
    public function insertAreaDetils($ai, $an)
    {

        $query = $this->con->prepare("INSERT INTO area (number,name) VALUES (:ai, :an)");

        $query->bindValue(":ai", $ai);
        $query->bindValue(":an", $an);

        return $query->execute();
    }

    public function deleteArea($ids)
    {
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $query = $this->con->prepare("DELETE FROM area WHERE number=:number");
                $query->bindValue(":number", $id);
                $result = $query->execute();

                if (!$result) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function insertItemDetils($id, $ai, $nm)
    {

        $query = $this->con->prepare("INSERT INTO areaitems (number, areaId, name) VALUES (:id, :ai, :nm)");

        $query->bindValue(":id", $id);
        $query->bindValue(":ai", $ai);
        $query->bindValue(":nm", $nm);

        return $query->execute();
    }

    public function getIdNum()
    {
        $query = $this->con->prepare("SELECT * FROM area");
        $query->execute();
        return $query->rowCount() + 1;
    }

    public function getItemIdNum()
    {
        $query = $this->con->prepare("SELECT * FROM areaitems");
        $query->execute();
        return $query->rowCount() + 1;
    }

    public function getArea($all = null)
    {
        $query = $this->con->prepare("SELECT * FROM area ");

        $query->execute();

        $html = "";
        $rows = array();

        if ($all) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $areaId = $row["number"];
                $areaName = $row["name"];
                $html .= "<option value='$areaId'>$areaId - $areaName</option>";
            }
            return $html;
        }

    }

    public function getLocation()
    {
        $query = $this->con->prepare("SELECT * FROM areaitems ");

        $query->execute();

        $rows = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;

    }

    public function deleteLocation($ids)
    {
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $query = $this->con->prepare("DELETE FROM areaitems WHERE number=:number");
                $query->bindValue(":number", $id);
                $result = $query->execute();

                if (!$result) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }
    public function getAreaName($ai)
    {
        $query = $this->con->prepare("SELECT * FROM area Where number =:ai");
        $query->bindValue(":ai", $ai);
        $query->execute();

        $html = "";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $areaName = $row["name"];
            $html = $areaName;
        }

        return $html;
    }
}
?>