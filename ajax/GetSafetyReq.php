<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];

if ($isNotification != null) {
    $requests = Requests::getSafetyRequests($con, true, "accepted");
    foreach ($requests as $request) {
        $notification = new Notification();

        echo $notification->getInspectorNotification($request, 'safety');
    }
}

if ($isNotification == null) {
    $workOrderNo = $_GET['workOrderNo'];

    $requests = Requests::getSafetyRequests($con, null, 'accepted', $workOrderNo);

    $reqNo = $requests["reqNo"];
    $workOrderNo = $requests["workOrderNo"];
    $adminAddedName = $requests["adminAddedName"];
    $inspector = $requests["inspector"];
    $area = $requests["area"];
    $item = $requests["item"];
    $notes = $requests["notes"];
    $issued = $requests["issued"] == 'yes' ? true : null;
    $new = $requests["new"] == "yes" ? "New" : "";
    $status = $requests["status"];

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
    <label class='GetOTYNote'>Notes :</label>
    <label class='GetrquesQTY'>$notes</label>
    <br>
";
}


?>