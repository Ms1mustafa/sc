<?php
include_once('includes/config.php');
include_once('includes/classes/Constants.php');

class ItemDes
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function addWT($itemdesId, $itemdesName)
    {

        if (empty($this->errorArray)) {
            return $this->insertItemDesDetils($itemdesId, $itemdesName);
        }

        return false;
    }

    public function insertItemDesDetils($itemdesId, $itemdesName)
    {

        $query = $this->con->prepare("INSERT INTO itemdes (number,name) VALUES (:itemdesId, :itemdesName)");

        $query->bindValue(":itemdesId", $itemdesId);
        $query->bindValue(":itemdesName", $itemdesName);

        return $query->execute();
    }

    public function getItemDes(){
        $query = $this->con->prepare("SELECT * FROM itemdes ");
        
        $query->execute();

        $html = "<div>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $itemdesId = $row["number"];
            $itemdesName = $row["name"];
            $html .= "<option value='$itemdesId'>$itemdesId - $itemdesName</option>";
        }

        return $html . "</div>";
    }
    public function getItemDesName($itemdesId){
        $query = $this->con->prepare("SELECT * FROM itemdes Where number =:itemdesId");
        $query->bindValue(":itemdesId", $itemdesId);
        $query->execute();

        $html = "";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $itemdesName = $row["name"];
            $html = $itemdesName;
        }

        return $html;
    }

    public function getIdNum(){
        $query = $this->con->prepare("SELECT * FROM itemdes");
        $query->execute();
        return $query->rowCount() + 1;
    }

}
?>