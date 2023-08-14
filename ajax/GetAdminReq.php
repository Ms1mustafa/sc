<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$admin = $_GET['admin'];
$requestAction = @$_GET['requestAction'];

if ($isNotification != null) {
    if ($requestAction) {
        $requests = Requests::getRequestsAction($con, true, $admin);

        foreach ($requests as $request) {

            $notification = new Notification();

            echo $notification->getReqActionNotification($request);
        }
    } else {
        $requests = Requests::getAdminRequests($con, true, $admin);
        foreach ($requests as $request) {

            $notification = new Notification();

            echo $notification->getAdminNotification($request);
        }
    }
}
if ($isNotification == null) {
    $workOrderNo = $_GET['workOrderNo'];

    $requests = Requests::getAdminRequests($con, null, $admin, $workOrderNo);
    $items = Requests::getItemsDes($con, $workOrderNo);

    $workOrderNo = $requests["workOrderNo"];
    $inspector = $requests["inspector"];
    $area = $requests["area"];
    $item = $requests["item"];
    $reqDate = FormSanitizer::formatDate($requests["reqDate"]);
    $inspectorDate = FormSanitizer::formatDate($requests["inspectorDate"]);

    echo "<label  class='Getinspect'>Inspector : </label>
    <label class='Getinspect1'>$inspector</label>
    <br>
    
    <label  class='Getinspect'>Area :</label>
    <label class='Getinspect3' >$area</label>
    <br>

    <label class='Getinspect'>Location :</label>
    <label class='Getinspect4'>$item</label>
    <br>

    <label class='Getinspect'>Request Added :</label>
    <label  class='Getinspect5'>$reqDate</label>
    <br>

    <label class='Getinspect'>Inspector accept :</label>
    <label  class='Getinspect5'>$inspectorDate</label>
    <br>
    
    <button class='submitacceptinspecter' name='dismantling'>dismantling</button>
";
}

?>