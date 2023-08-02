<?php
include_once('includes/config.php');
include_once('includes/classes/constants.php');

class workType
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function addWT($wtId, $wtName)
    {

        if (empty($this->errorArray)) {
            return $this->insertWTDetils($wtId, $wtName);
        }

        return false;
    }

    public function insertWTDetils($wtId, $wtName)
    {

        $query = $this->con->prepare("INSERT INTO workType (number,name) VALUES (:wtId, :wtName)");

        $query->bindValue(":wtId", $wtId);
        $query->bindValue(":wtName", $wtName);

        return $query->execute();
    }

    public function getWT(){
        $query = $this->con->prepare("SELECT * FROM workType ");
        
        $query->execute();

        $html = "<div>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $wtId = $row["number"];
            $wtName = $row["name"];
            $html .= "<option value='$wtId - $wtName'>$wtId - $wtName</option>";
        }

        return $html . "</div>";
    }
    public function getWTName($wtId){
        $query = $this->con->prepare("SELECT * FROM workType Where number =:wtId");
        $query->bindValue(":wtId", $wtId);
        $query->execute();

        $html = "";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $wtName = $row["name"];
            $html = $wtName;
        }

        return $html;
    }

    public function getIdNum(){
        $query = $this->con->prepare("SELECT * FROM workType");
        $query->execute();
        return $query->rowCount() + 1;
    }

}
?>