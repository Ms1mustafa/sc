<?php

class Notification
{
    private $errorArray = array();

    public function getAdminNotification($data)
    {
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $inspector = $data["inspector"];
        $qtyBackStatus	 = $data["qtyBackStatus"] == 'done' ? '&status=done' : '';
        $status = ucfirst($data["status"]);
        $inspectorDate = FormSanitizer::formatDate($data["inspectorDate"]);

        if (empty($this->errorArray)) {
            $html = "
            <a class='notification' href='adminQty.php?workOrderNo=" . $workOrderNo . "$qtyBackStatus'>
            <p>$status, $inspector</p>
            <p>$priority</p>
            <p>Inspector accepted : $inspectorDate</p>
            </a>
            <br>
            <hr class='reqhr'>
            <br>
            ";
            return $html;
        }

        return false;
    }

    public function getReqActionNotification($data)
    {
        $reqNo = $data["reqNo"];
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $adminAddedName = $data["adminAddedName"];
        $reqDate = FormSanitizer::formatDate($data["reqDate"]);

        if (empty($this->errorArray)) {
            $html = "
            <a  class='notification' href='requestAction.php?workOrderNo=" . $workOrderNo . "'>
            <p>$reqNo, Request, $adminAddedName</p>
            <p>$priority</p>
            <p>request added : $reqDate</p>
            </a>
            <br>
            <hr class='hrQty'>
            <br>
            ";
            return $html;
        }

        return false;
    }

    private function getNotiFrom($issued, $werehouseName, $inspectorDate, $inspector, $adminAddedName, $qtyBackStatus)
    {
        if ($qtyBackStatus == 'executer') {
            return $adminAddedName;
        } elseif ($inspectorDate) {
            return $inspector;
        } elseif ($issued) {
            return $werehouseName;
        }


        return $adminAddedName;
    }
    private function getNotiDate($wereHouseDate, $inspectorDate, $reqDate, $qtyBackDate)
    {
        if ($qtyBackDate) {
            return 'Dismantling date : ' . FormSanitizer::formatDate($qtyBackDate);
        } elseif ($inspectorDate) {
            return 'Ispector date : ' . FormSanitizer::formatDate($inspectorDate);
        } elseif ($wereHouseDate) {
            return 'WereHouse date : ' . FormSanitizer::formatDate($wereHouseDate);
        }


        return 'request added : ' . $reqDate;
    }
    private function getNotiType($issued, $werehouseName, $inspectorDate, $qtyBackDate)
    {
        if ($qtyBackDate) {
            return "Dismantling";
        } elseif ($inspectorDate) {
            return "Reject";
        } elseif ($issued) {
            return "Werehouse";
        } else {
            return "Request";
        }

    }
    public function getExecuterNotification($data)
    {
        $issued = $data["issued"] == 'yes' ? true : false;
        $reqNo =  !$issued ? $data["reqNo"] . ', ' : '';
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $adminAddedName = $data["adminAddedName"];
        $status = $data["status"];
        $qtyBackStatus = $data["qtyBackStatus"];
        $qtyBackDate = $data["qtyBackDate"];
        $inspector = $data["inspector"];
        $inspectorDate = $data["inspectorDate"];
        $werehouseName = $data["wereHouse"] ?? false;
        $wereHouseDate = $data["wereHouseDate"] ?? false;
        $type = $this->getNotiType($issued, $werehouseName, $inspectorDate, $qtyBackDate);
        $sender = $this->getNotiFrom($issued, $werehouseName, $inspectorDate, $inspector, $adminAddedName, $qtyBackStatus);
        $reject = $status == 'rejected' ? '&reject=yes' : '';
        $new = $data["new"] == "yes" ? '&new=yes' : '';
        $reqDate = FormSanitizer::formatDate($data["reqDate"]);

        if (empty($this->errorArray)) {
            $html = "
            <a  class='notification'  href='qty.php?qtyNo=" . $workOrderNo . $new . " $reject'>
            <p>$reqNo" . $type . ", " . $sender . "</p>
            <p>$priority</p>
            <p>" . $this->getNotiDate($wereHouseDate, $inspectorDate, $reqDate, $qtyBackDate) . "</p>
            </a>
            <br>
            <hr class='hrQty'>
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
        $status = $data["status"];
        // $notiType = $data["qtyBackStatus"] == 'wereHouse' ? 'Dismantling' : 'Request';
        $qtyBackDate = $data["qtyBackDate"];
        $executerDate = FormSanitizer::formatDate($data["executerDate"]);
        $date = $qtyBackDate ? FormSanitizer::formatDate($qtyBackDate) : $executerDate;
        $resent = $status == 'resent' ? '&resent=yes' : '&resent=no';
        if ($data["qtyBackStatus"] == 'wereHouse') {
            $resent = '&dismantling=yes';
        }

        if (empty($this->errorArray)) {
            $html = "
            
                <a class='notification' href='wereHouseQty.php?qtyNo=" . $workOrderNo . $resent . "'>
                <p>Executer: $executer</p>
                <br>
                <p>$priority</p>
                <br>
                <p>Executer sent: $date</p>
                </a>
                <br>
                <hr class='hrQty'>
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
        $status = $data["status"];
        $executerAcceptDate = $data["executerAcceptDate"] ? FormSanitizer::formatDate($data["executerAcceptDate"]) : null;
        $resentDate = $data["resentDate"] ? FormSanitizer::formatDate($data["resentDate"]) : null;

        if (empty($this->errorArray)) {
            $html = "
                <a   class='notification' href='inspectorQty.php?qtyNo=" . $workOrderNo . "'>
                <p>Executer : $executer</p>
                <p>$priority</span></p>
            ";
            if ($status == 'resentInspector') {
                $html .= "<p>resent : $resentDate</p>";
            }
            $html .= "
                <p>Executer accept : $executerAcceptDate</p>
                </a>
                <br>
                <hr class='hrQty'>
                <br>
            ";

            return $html;
        }

        return false;
    }


}
?>