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
    $reqNo = $requests["reqNo"];
    $status = $requests["status"];
    $inspector = $requests["inspector"];
    $adminAddedName = $requests["adminAddedName"];
    $area = $requests["area"];
    $item = $requests["item"];
    $executerAccept = $requests["executerAccept"];
    $rejectReason = $requests["rejectReason"];
    $executerDate = FormSanitizer::formatDate($requests["executerDate"]);
    $qtyBackStatus = $requests["qtyBackStatus"];
    $reqDate = FormSanitizer::formatDate($requests["reqDate"]);
    $inspectorDate = FormSanitizer::formatDate($requests["inspectorDate"]);

    $isRejected = $executerAccept === 'no' && $rejectReason;
    if ($isRejected)
        echo "
        <label  class='Getrquest'>Request No :</label>
        <label class='GetrquesQTY' >$reqNo</label>
        <br>
        <br>
        <label  class='Getrquest'>workOrderNo :</label>
        <label class='GetrquesQTY' >$workOrderNo</label>
        <br>
        <br>
        ";

    echo "<label  class='Getrquest'>";
    if ($isRejected)
        echo 'Requester';
    else
        echo 'Inspector';
    echo " : </label>
    <label class='GetrquesQTY'>";
    if ($isRejected)
        echo $adminAddedName;
    else
        echo $inspector;
    echo "</label>
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
    if ($isRejected) {
        echo "
            <label class='Getrquest'>Reject Date :</label>
            <label  class='GetrquesQTY'>$executerDate</label>
            <br>
            <br>
            <label class='Getrquest'>Reject reason :</label>
            <label  class='GetrquesQTY'>$rejectReason</label>
            <br>
            <br>
        ";
    } else
        echo "
            <label class='Getrquest'>Request Added :</label>
            <label  class='GetrquesQTY'>$reqDate</label>
            <br>
            <br>
            <label class='Getrquest'>Inspector accept :</label>
            <label  class='GetrquesQTY'>$inspectorDate</label>
            <br>
            <br>
        ";
    echo "
    ";
    //$qtyBackStatus != 'done' || 
    if ($status != 'rejected' && $qtyBackStatus != 'done' && $qtyBackStatus != 'wereHouse&requester') {
        echo "<button class='submitDismantling' name='dismantling'>Dismantling</button>";
    }
    if ($qtyBackStatus === 'wereHouse&requester') {
        echo "<button class='submitDismantling' name='RequesterDismDone'>Done</button>";
    }

    echo "
";
}

?>