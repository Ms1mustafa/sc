<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$isQty = $_GET['isQty'];
$workOrderNo = $_GET['workOrderNo'];
if ($isNotification != null) {

    $requests = Requests::getRequest($con, $isNotification, false);
    foreach ($requests as $request) {
        
        $notification = new Notification();

        echo $notification->getExecuterNotification($request);
    }
}

if ($isQty != null) {

    $requests = Requests::getRequest($con, $isNotification, false);
    foreach ($requests as $request) {
        $workOrderNo = $request["workOrderNo"];
        $requester = $request["name"];
        $new = $request["new"] == "yes" ? true : false;

        echo "
            <tr>
                <td></td>
            </tr>
        ";
    }
}

if ($isQty != null) {

    $requests = Requests::getRequest($con, false, $isQty, $workOrderNo);
    $reqNo = $requests["reqNo"];
    $workOrderNo = $requests["workOrderNo"];
    $requester = $requests["name"];
    $inspector = $requests["inspector"];
    $area = $requests["area"];
    $item = $requests["item"];
    $priority = $requests["priority"];
    $notes = $requests["notes"];
    $pipeQty = $requests["pipeQty"];
    $clampQty = $requests["clampQty"];
    $woodQty = $requests["woodQty"];
    $pipeQtyStore = $requests["pipeQtyStore"];
    $pipeQtyStoreComment = $requests["pipeQtyStoreComment"];
    $clampQtyStore = $requests["clampQtyStore"];
    $clampQtyStoreComment = $requests["clampQtyStoreComment"];
    $woodQtyStore = $requests["woodQtyStore"];
    $woodQtyStoreComment = $requests["woodQtyStoreComment"];
    $issued = $requests["issued"] == 'yes' ? true : null;
    $finishDate = $requests["finishDate"];
    $executerAccept = $requests["executerAccept"] == 'yes' ? true : null;
    $new = $requests["new"] == "yes" ? true : false;
    $reqDate = $requests["reqDate"];
    $status = $requests["status"];
    $rejectReason = $requests["rejectReason"];

    $length = $requests["length"];
    $width = $requests["width"];
    $height = $requests["height"];
    $lwh = $length * $width * $height;

    
    echo "<label class='Get'>ReqNo</label>
    <label class='Getreq'>$reqNo</label>
    <br>
   
    <label class='Get'>Requester</label>
    <label class='Getreq1'>$requester</label>
    <br>
    <label class='Get' >Inspector</label>
    <label class='Getreq1'>$inspector</label>
   <br>
    <label class='Get'>Area</label>
    <label class='Getreq2'>$area</label>
    <br>
   
    
    <label class='length'>$length m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$width m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$height m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$lwh m</label>
  <br>
    <label class='Get'>Location</label>
    <label class='Getreq3'>$item</label>
   <br>
    
    <label class='Get'>priority</label>
    <label class='Getreq4'>$priority</label>
     
    <br>
    <label class='Get'>Notes</label>
    <label class='Getreq4'>$notes</label>
    <br>
   
    <label class='Get'>Date</label>
   <br>
    <input class='inputfieldrequest' type='date' name='finishDate' value='$finishDate' ";
    
    if (!$new) {
        echo 'readonly';
    }
    echo " required>
    ";
    if ($issued) {
        echo '
            <table >
            <thead >
                <th>Item description</th>
                <th >QTY Req</th>
                <th>QTY Issued</th>
                <th>Comment</th>
            </thead>
            <tbody>
        ';
        if ($pipeQty) {
            echo "
                    <tr>
                        <td>Pipe 6M</td>
                        <td><input class = 'Wood1' type='number' min = '1' name='pipeQty' value='$pipeQty' "; if ($status != 'rejected') { echo 'disabled';} echo"></td>
                        <td><input class = 'Wood1' type='number' min = '1' name='pipeQtyStore' value='$pipeQtyStore' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                        <td><input  class = 'Wood1' type='text' name='pipeQtyStoreComment' value='$pipeQtyStoreComment' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                    </tr>
                ";
        }
        if ($clampQty) {
            echo "
                    <tr>
                        <td>Clamp movable</td>
                        <td><input class = 'Wood1' type='number' min = '1' name='clampQty' value='$clampQty' "; if ($status != 'rejected') { echo 'disabled';} echo"></td>
                        <td><input class = 'Wood1' type='number' min = '1' name='clampQtyStore' value='$clampQtyStore' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                        <td><input  class = 'Wood1' type='text' name='clampQtyStoreComment' value='$clampQtyStoreComment' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                    </tr>
                ";
        }
        if ($woodQty) {
            echo "
                    <tr>
                        <td>Wood 4m</td>
                        <td><input class = 'Wood1' type='number' min = '1' name='woodQty' value='$woodQty' "; if ($status != 'rejected') { echo 'disabled';} echo"></td>
                        <td><input class = 'Wood1' type='number' min = '1' name='woodQtyStore' value='$woodQtyStore' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                        <td><input class = 'Wood1' type='text' name='woodQtyStoreComment' value='$woodQtyStoreComment' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                    </tr>
                ";
        }
    }
    echo '
        </tbody>
        </table>
    ';

    if ($issued && !$executerAccept) {
        echo '
            <button class="submittt" name="accept">accept</button>
        ';
    }
    if($status == 'rejected'){
        echo'
            <p>Rejected</p>
            <p>Reject Reason : '.$rejectReason.'</p>

            <button class="submit" name="resendToInspector">Resend to inspector</button>
        ';
    }
    echo "
";
}


?>