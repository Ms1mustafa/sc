<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

// $isNotification = $_GET['isNotification'];
// $isQty = $_GET['isQty'];
// $workOrderNo = $_GET['workOrderNo'];

$requests = Requests::getRequest($con, true, null, null, null, true);
foreach ($requests as $request) {

    $notification = new Notification();

    echo $notification->getAdminNotification($request);
}

?>