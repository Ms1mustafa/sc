<?php

class Notification
{
    private $errorArray = array();

    public function getAdminNotification($data)
    {
        $workOrderNo = $data["workOrderNo"];
        $priority = $data["priority"];
        $executer = $data["executer"];
        $inspector = $data["inspector"];
        $wereHouse = $data["wereHouse"];
        $sender = $data["qtyBackStatus"] == 'done' ? $wereHouse : $inspector;
        $sender = $data["qtyBackStatus"] == 'wereHouse&requester' ? $executer : $sender;
        $qtyBackStatus = $data["qtyBackStatus"] == 'done' ? '&status=done' : '';
        $qtyBackStatus = $data["qtyBackStatus"] == 'wereHouse&requester' ? '&status=wereHouse&requester' : $qtyBackStatus;
        $status = $data["qtyBackStatus"] == 'done' ? 'Done' : ucfirst($data["status"]);
        $status = $data["qtyBackStatus"] == 'wereHouse&requester' ? 'dismantling' : $status;
        $inspectorDate = FormSanitizer::formatDate($data["inspectorDate"]);
        $notiDateFrom = 'Inspector accepted';

        if (!$data["inspectorDate"]) {
            $sender = $executer;
            $inspectorDate = FormSanitizer::formatDate($data["executerDate"]);
            $qtyBackStatus = '&status=rejected';
        }
        $inspectorDate = $data["qtyBackStatus"] == 'wereHouse&requester' ? FormSanitizer::formatDate($data["qtyBackDate"]) : $inspectorDate;
        $notiDateFrom = $data["qtyBackStatus"] == 'wereHouse&requester' ? 'Executer sent' : $notiDateFrom;

        if (empty($this->errorArray)) {
            $html = "
            <a class='' href='adminQty.php?workOrderNo=" . $workOrderNo . "$qtyBackStatus'>
            <p>$status, <span class='sender'>$sender</span></p>
            <p>$priority</p>
            <p>$notiDateFrom : $inspectorDate</p>
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
        $reqNo = !$issued ? $data["reqNo"] . ', ' : '';
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
        $reject = $status === 'rejected' ? '&reject=yes' : '';
        $new = $data["new"] == "yes" ? '&new=yes' : '';
        $reqDate = FormSanitizer::formatDate($data["reqDate"]);
        $sender = $status === 'backExecuter' ? $werehouseName : $sender;

        if (empty($this->errorArray)) {
            $html = "
            <a  class='notification'  href='qty.php?qtyNo=" . $workOrderNo . $new . " $reject'>
            <p class='senderDetils'>$reqNo" . $type . ", <span class='sender'>" . $sender . "</span></p>
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
        $qtyBackStatus = $data["qtyBackStatus"];
        $qtyBackDate = $data["qtyBackDate"];
        $executerDate = FormSanitizer::formatDate($data["executerDate"]);
        $date = $qtyBackDate ? FormSanitizer::formatDate($qtyBackDate) : $executerDate;
        $resent = $status == 'resent' ? '&resent=yes' : '&resent=no';
        $sender = 'Executer';
        if ($qtyBackStatus === 'wereHouse' || $qtyBackStatus === 'wereHouse&requester') {
            $resent = '&dismantling=yes';
        }
        $sender = $status === 'reject' ? 'Reject' : $sender;
        if ($qtyBackStatus === 'wereHouse&requester' || $qtyBackStatus === 'wereHouse') {
            $sender = 'dismantling';
        }

        if (empty($this->errorArray)) {
            $html = "
            
                <a class='notification' href='wereHouseQty.php?qtyNo=" . $workOrderNo . $resent . "'>
                <p>$sender: <span class='sender'>$executer</span></p>
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
                <p>Executer : <span class='sender'>$executer</span></p>
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