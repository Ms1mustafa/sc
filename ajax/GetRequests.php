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

    echo "<label>ReqNo</label>
    <label>$reqNo</label>
    <br>
    <label>Requester</label>
    <label>$requester</label>
    <br>
    <label>Inspector</label>
    <label>$inspector</label>
    <br>
    <label>Area</label>
    <label>$area</label>
    <br>
    <label>Location</label>
    <label>$item</label>
    <br>
    <label>priority</label>
    <label>$priority</label>
    <br>
    <label>Notes</label>
    <label>$notes</label>
    <br>
    <label>Date</label>
    <input type='date' name='finishDate' value='$finishDate' ";
    if (!$new) {
        echo 'readonly';
    }
    echo " required>
    ";
    if ($issued) {
        echo '
            <table>
            <thead>
                <th>Item description</th>
                <th>QTY Req</th>
                <th>QTY Issued</th>
                <th>Comment</th>
            </thead>
            <tbody>
        ';
        if ($pipeQty) {
            echo "
                    <tr>
                        <td>Pipe 6M</td>
                        <td><input type='number' min = '1' name='pipeQty' value='$pipeQty' "; if ($status != 'rejected') { echo 'disabled';} echo"></td>
                        <td><input type='number' min = '1' name='pipeQtyStore' value='$pipeQtyStore' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                        <td><input type='text' name='pipeQtyStoreComment' value='$pipeQtyStoreComment' ";
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
                        <td><input type='number' min = '1' name='clampQty' value='$clampQty' "; if ($status != 'rejected') { echo 'disabled';} echo"></td>
                        <td><input type='number' min = '1' name='clampQtyStore' value='$clampQtyStore' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                        <td><input type='text' name='clampQtyStoreComment' value='$clampQtyStoreComment' ";
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
                        <td><input type='number' min = '1' name='woodQty' value='$woodQty' "; if ($status != 'rejected') { echo 'disabled';} echo"></td>
                        <td><input type='number' min = '1' name='woodQtyStore' value='$woodQtyStore' ";
            if ($issued) {
                echo "disabled";
            }
            echo "></td>
                        <td><input type='text' name='woodQtyStoreComment' value='$woodQtyStoreComment' ";
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
            <button name="accept">accept</button>
        ';
    }
    if($status == 'rejected'){
        echo'
            <p>Rejected</p>
            <p>Reject Reason : '.$rejectReason.'</p>

            <button name="resendToInspector">Resend to inspector</button>
        ';
    }
    echo "
";
}


?>