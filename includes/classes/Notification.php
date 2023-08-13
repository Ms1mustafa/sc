<?php

class Notification
{
    private $errorArray = array();

    public function getAdminNotification($data)
    {
        $reqNo = $data["reqNo"];
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $adminAddedName = $data["name"];
        $new = $data["new"] == "yes" ? true : false;
        $reqDate = FormSanitizer::formatDate($data["reqDate"]);

        if (empty($this->errorArray)) {
            $html = "
            <a href='requestAction.php?workOrderNo=" . $workOrderNo . "'>
            <p>$reqNo, Request, $adminAddedName</p>
            <p>$priority</p>
            <p>request added : $reqDate</p>
            </a>
            <br>
            <hr>
            <br>
            ";
            return $html;
        }

        return false;
    }

    private function getNotiFrom($werehouseName, $inspectorDate, $inspector, $adminAddedName)
    {
        if ($inspectorDate) {
            return $inspector;
        } elseif ($werehouseName) {
            return $werehouseName;
        }

        return $adminAddedName;
    }
    private function getNotiDate($wereHouseDate, $inspectorDate, $reqDate)
    {
        if ($inspectorDate) {
            return 'Ispector date : ' . FormSanitizer::formatDate($inspectorDate);
        } elseif ($wereHouseDate) {
            return 'WereHouse date : ' . FormSanitizer::formatDate($wereHouseDate);
        }

        return 'request added : ' . $reqDate;
    }
    private function getNotiType($werehouseName, $inspectorDate)
    {
        if ($inspectorDate) {
            return "Inspector";
        } elseif ($werehouseName) {
            return "Werehouse";
        } else {
            return "Request";
        }
    }
    public function getExecuterNotification($data)
    {
        $reqNo = $data["reqNo"];
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $adminAddedName = $data["adminAddedName"];
        $status = $data["status"];
        $inspector = $data["inspector"];
        $inspectorDate = $data["inspectorDate"];
        $werehouseName = $data["werehouseName"] ?? false;
        $wereHouseDate = $data["wereHouseDate"] ?? false;
        $type = $this->getNotiType($werehouseName, $inspectorDate);
        $sender = $this->getNotiFrom($werehouseName, $inspectorDate, $inspector, $adminAddedName);

        $new = $data["new"] == "yes" ? true : false;
        $reqDate = FormSanitizer::formatDate($data["reqDate"]);

        if (empty($this->errorArray)) {
            $html = "
            <a href='qty.php?qtyNo=" . $workOrderNo . "&new=" . $new . "'>
            <p>$reqNo, " . $type . ", " . $sender . "</p>
            <p>$priority</p>
            <p>".$this->getNotiDate($wereHouseDate, $inspectorDate, $reqDate)."</p>
            </a>
            <br>
            <hr>
            <br>
            ";
            return $html;
        }

        return false;
    }
    public function getWereHouseNotification($data)
    {
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $executer = $data["executer"];
        $executerDate = FormSanitizer::formatDate($data["executerDate"]);
        $inspectorDate = $data["inspectorDate"] ? FormSanitizer::formatDate($data["inspectorDate"]) : null;


        if (empty($this->errorArray)) {
            $html = "
                <a href='wereHouseQty.php?qtyNo=" . $workOrderNo . "'>
                <p>Executer: $executer</p>
                <p>$priority</p>
            ";

            if ($inspectorDate) {
                $html .= "<p>Inspector reject: $inspectorDate</p>";
            }

            $html .= "
                <p>Executer sent: $executerDate</p>
                </a>
                <br>
                <hr>
                <br>
            ";

            return $html;
        }

        return false;
    }
    public function getInspectorNotification($data)
    {
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $executer = $data["executer"];
        $wereHouseDate = $data["wereHouseDate"] ? FormSanitizer::formatDate($data["wereHouseDate"]) : null;
        $resentDate = $data["resentDate"] ? FormSanitizer::formatDate($data["resentDate"]) : null;

        if (empty($this->errorArray)) {
            $html = "
                <a href='inspectorQty.php?qtyNo=" . $workOrderNo . "'>
                <p>Executer : $executer</p>
                <p>$priority</span></p>
            ";
            if ($resentDate) {
                $html .= "<p>resent : $resentDate</p>";
            }
            $html .= "
                <p>wereHouse sent : $wereHouseDate</p>
                </a>
                <br>
                <hr>
                <br>
            ";

            return $html;
        }

        return false;
    }


}
?>