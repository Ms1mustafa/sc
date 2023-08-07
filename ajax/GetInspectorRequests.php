<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$isQty = $_GET['isQty'];
$workOrderNo = $_GET['workOrderNo'];
if ($isNotification != null) {

    $requests = Requests::getRequest($con, $isNotification, false, null, null, null, true);
    foreach ($requests as $request) {
        $notification = new Notification();

        echo $notification->getInspectorNotification($request);
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
    $new = $requests["new"] == "yes" ? "New" : "";
    $status = $requests["status"];

    echo "<label  class='Getinspect'>ReqNo</label>
    <label class='Getinspect1'>$reqNo</label>
<br>
    
    <label class='Getinspect'>Requester</label>
    <label  class='Getinspect2'>$requester</label>

    <br>
    <label class='Getinspect'>Inspector</label>
    <label class='Getinspect2'>$inspector</label>
<br>
    <label  class='Getinspect'>Area</label>
    <label class='Getinspect3' >$area</label>
    <br>

    <label class='Getinspect'>Location</label>
    <label class='Getinspect4'>$item</label>
   <br>
    <label class='Getinspect'>Notes</label>
    <label  class='Getinspect5'>$notes</label>
    <table class='itemestable'>
        <tr>
            <th>Item description</th>
            <th>QTY Req</th>
            <th>QTY Issued</th>
            <th>Comment</th>
       </tr
        ";
    if ($pipeQty) {
        echo "
                    <tr>
                        <td>Pipe 6M</td>
                        <td>$pipeQty</td>
                        <td><input class = 'pipe1' type='number' min = '1' name='pipeQtyStore' value='$pipeQtyStore' ";
        if ($issued) {
            echo "disabled";
        }
        echo "></td>
                        <td><input class = 'pipe1' type='text' name='pipeQtyStoreComment' value='$pipeQtyStoreComment' ";
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
                        <td>$clampQty</td>
                        <td><input class = 'pipe1' type='number' min = '1' name='clampQtyStore' value='$clampQtyStore' ";
        if ($issued) {
            echo "disabled";
        }
        echo "></td>
                        <td><input class = 'pipe1' type='text' name='clampQtyStoreComment' value='$clampQtyStoreComment' ";
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
                        <td>$woodQty</td>
                        <td><input class = 'pipe1' type='number' min = '1' name='woodQtyStore' value='$woodQtyStore' ";
        if ($issued) {
            echo "disabled";
        }
        echo "></td>
                        <td><input  class = 'pipe1' type='text' name='woodQtyStoreComment' value='$woodQtyStoreComment' ";
        if ($issued) {
            echo "disabled";
        }
        echo "></td>
                    </tr>
                ";
    }
    echo "
            
        </tbody>
    </table>
  
    ";
    if ($status == 'resent') {
        echo '
            <button name="accept" onclick="removeRequiredAttribute()">accept</button>
        ';
    }
    if ($status == 'pending') {
        echo '
            <button class="submitacceptinspecter" name="accept" onclick="removeRequiredAttribute()">accept</button>
            <br>
            <br>
            <button class="submitrejectinspecter" name="reject" id="reject" onclick="addRequiredAttribute()">reject</button>
            <br>
            <br>
            <input class="inputrejectreason" type="text" name="rejectReason" id="rejectReason" placeholder = "Reject reason">
        ';
    }
    echo "
";
}


?>