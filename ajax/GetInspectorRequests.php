<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$inspector = $_GET['inspector'];

if ($isNotification != null) {
    $inspector = $_GET['inspector'];

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
    $notes = $requests["notes"];
    $issued = $requests["issued"] == 'yes' ? true : null;
    $new = $requests["new"] == "yes" ? "New" : "";
    $status = $requests["status"];

    echo "<label  class='Getinspect'>ReqNo : </label>
    <label class='Getinspect1'>$reqNo</label>
<br>
    
    <label class='Getinspect'>Requester :</label>
    <label  class='Getinspect2'>$adminAddedName</label>

    <br>
    <label class='Getinspect'>Inspector :</label>
    <label class='Getinspect2'>$inspector</label>
<br>
    <label  class='Getinspect'>Area :</label>
    <label class='Getinspect3' >$area</label>
    <br>

    <label class='Getinspect'>Location :</label>
    <label class='Getinspect4'>$item</label>
   <br>
    <label class='Getinspect'>Notes :</label>
    <label  class='Getinspect5'>$notes</label>
    
    ";
    if ($issued) {
        echo '
            <table  >
            <thead >
                <th>Item description</th>
                <th >QTY Req</th>
                <th>QTY Issued</th>
                <th>Comment</th>
            </thead>
            <tbody>
        ';
        if ($rejectItems) {
            $itemsLoop = $rejectItems;
        } else {
            $itemsLoop = $items;
        }
        foreach ($itemsLoop as $item) {
            echo '
            <tr>
                <td>' . $item['itemName'] . '</td>
                <td>' . $item['itemQty'] . '</td>
                
                <td>' . $item['wereHouseQty'] . '</td>
                <td>' . $item['wereHouseComment'] . '</td>
                

            </tr>
            ';
        }
    }
   
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