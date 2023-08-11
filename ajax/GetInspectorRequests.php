<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$isQty = $_GET['isQty'];
$workOrderNo = $_GET['workOrderNo'];
if ($isNotification != null) {
    $inspector = $_GET['inspector'];

    $requests = Requests::getRequest($con, $isNotification, false, null, null, null, $inspector);
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
    
        ";
   
    // if ($status == 'resent') {
    //     echo '
    //         <button name="accept" onclick="removeRequiredAttribute()">accept</button>
    //     ';
    // }
    if ($status = 'pending') {
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