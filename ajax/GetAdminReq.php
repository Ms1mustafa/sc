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
    $qtyBackStatus = $requests["qtyBackStatus"];
    $reqDate = FormSanitizer::formatDate($requests["reqDate"]);
    $inspectorDate = FormSanitizer::formatDate($requests["inspectorDate"]);

    echo "<label  class='Getrquest'>Inspector : </label>
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
    <label class='Getrquest'>Request Added :</label>
    <label  class='GetrquesQTY'>$reqDate</label>
    <br>
    <br>
    <label class='Getrquest'>Inspector accept :</label>
    <label  class='GetrquesQTY'>$inspectorDate</label>
    <br>
    <br>
    ";
    if ($qtyBackStatus != 'done') {
        echo "<button class='submitDismantling' name='dismantling'>Dsmantling</button>";
    }
    echo "
";
}

?>