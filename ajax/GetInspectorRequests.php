<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$inspector = @$_GET['inspector'] ?? @$_GET['admin'];

if ($isNotification != null) {
    $inspector = @$_GET['inspector'] ?? @$_GET['admin'];

    $requests = Requests::getInspectorRequests($con, true, $inspector);
    foreach ($requests as $request) {
        $notification = new Notification();

        echo $notification->getInspectorNotification($request);
    }
}

if ($isNotification == null) {
    $workOrderNo = $_GET['workOrderNo'];

    $requests = Requests::getInspectorRequests($con, null, $inspector, $workOrderNo);
    $items = Requests::getItemsDes($con, $workOrderNo);
    $rejectItems = Requests::getRejectItemsDes($con, $workOrderNo, true);

    $reqNo = $requests["reqNo"];
    $workOrderNo = $requests["workOrderNo"];
    $adminAddedName = $requests["adminAddedName"];
    $inspector = $requests["inspector"];
    $area = $requests["area"];
    $item = $requests["item"];
    $issued = $requests["issued"] == 'yes' ? true : null;
    $new = $requests["new"] == "yes" ? "New" : "";
    $status = $requests["status"];
    $note = $requests["notes"];
    $resend_note = $requests["resend_note"];

    echo "<label  class='Getrquest'>ReqNo : </label>
    <label class='GetrquesQTY'>$reqNo</label>
<br>
    <br>
    <label class='Getrquest'>Requester :</label>
    <label  class='GetrquesQTY'>$adminAddedName</label>
    <br>
    <br>
    <label class='Getrquest'>Inspector :</label>
    <label class='GetrquesQTY'>$inspector</label>
<br>
<br>
    <label  class='Getrquest'>Area :</label>
    <label class='GetrquesQTY' >$area</label>
    <br>
    <br>
    <label class='Getrquest'>Location :</label>
    <label class='GetrquesQTY'>$item</label>
   <br>
   <br>
   ";
    if ($resend_note) {
        echo "
    <label class='GetOTYNote'>Resent note :</label>
    <br>
    <label class='GetrquesQTY'>$resend_note</label>
    ";
    }
    // if ($status == 'resent') {
    //     echo '
    //         <button name="accept" onclick="removeRequiredAttribute()">accept</button>
    //     ';
    // }
    if ($status = 'pending') {
        echo '
            <button class="submitacceptinspecter" name="accept" onclick="removeRequiredAttribute()">Accept</button>
         
            <button class="submitacceptinspecter" name="reject" id="reject" onclick="addRequiredAttribute()">Reject</button>
            <br>
            <br>
            <textarea class="inputrejectreason" type="text" name="rejectReason" id="rejectReason" placeholder = "Reject reason"></textarea>
        ';
    }
    echo "
";
}


?>