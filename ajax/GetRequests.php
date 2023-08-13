<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$executer = $_GET['executer'];

if ($isNotification != null) {

    $requests = Requests::getExecuterRequests($con, true, $executer);
    foreach ($requests as $request) {

        $notification = new Notification();

        echo $notification->getExecuterNotification($request);
    }
}

if ($isNotification == null) {
    $workOrderNo = $_GET['workOrderNo'];

    $requests = Requests::getExecuterRequests($con, null, $executer, $workOrderNo);
    $items = Requests::getItemsDes($con, $workOrderNo);
    $reqNo = $requests["reqNo"];
    $workOrderNo = $requests["workOrderNo"];
    $adminAddedName = $requests["adminAddedName"];
    $inspector = $requests["inspector"];
    $area = $requests["area"];
    $item = $requests["item"];
    $priority = $requests["priority"];
    $notes = $requests["notes"];
    $issued = $requests["issued"] == 'yes' ? true : null;
    $finishDate = $requests["finishDate"];
    $executerAccept = $requests["executerAccept"] == 'yes' ? true : null;
    $new = $requests["new"] == "yes" ? true : false;
    $reqDate = $requests["reqDate"];
    $status = $requests["status"];
    $rejectReason = $requests["rejectReason"];

    $length = $requests["length"];
    $width = $requests["width"];
    $height = $requests["height"];
    $lwh = $length * $width * $height;

    echo "<label class='Get'>ReqNo</label>
    <label class='Getreq'>$reqNo</label>
    <br>
   
    <label class='Get'>Requester</label>
    <label class='Getreq1'>$adminAddedName</label>
    <br>
    <label class='Get' >Inspector</label>
    <label class='Getreq1'>$inspector</label>
   <br>
    <label class='Get'>Area</label>
    <label class='Getreq2'>$area</label>
    <br>
   
    
    <label class='length'>$length m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$width m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$height m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$lwh m</label>
  <br>
    <label class='Get'>Location</label>
    <label class='Getreq3'>$item</label>
   <br>
    
    <label class='Get'>priority</label>
    <label class='Getreq4'>$priority</label>
     
    <br>
    <label class='Get'>Notes</label>
    <label class='Getreq4'>$notes</label>
    <br>
   
    <label class='Get'>Date</label>
   <br>
   
    <input class='inputfieldrequest' type='date' name='finishDate' value= '$finishDate' ";

    if (!$new) {
        echo 'readonly';
    }
    echo "required>
    ";
    if ($issued) {
        echo '
            <table >
            <thead >
                <th>Item description</th>
                <th >QTY Req</th>
                <th>QTY Issued</th>
                <th>Comment</th>
            </thead>
            <tbody>
        ';
        foreach ($items as $item) {
            echo '
            <tr>
                <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                <td>' . $item['itemQty'] . '</td>
                
                <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['wereHouseQty'] . '" readonly></td>
                <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['wereHouseComment'] . '" readonly></td>
                

            </tr>
            ';
        }
    }
    echo '
        </tbody>
        </table>
    ';

    if ($issued && !$executerAccept) {
        echo '
            <button class="submittt" name="accept">accept</button>
        ';
    }
    if ($status == 'rejected') {
        echo '
            <p>Rejected</p>
            <p>Reject Reason : ' . $rejectReason . '</p>

            <button class="submit" name="resendToInspector">Resend to inspector</button>
        ';
    }
    echo "
";
}


?>