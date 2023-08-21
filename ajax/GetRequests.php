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
    $rejectItems = Requests::getRejectItemsDes($con, $workOrderNo);
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
    $qtyBackStatus = $requests["qtyBackStatus"];
    $rejectReason = $requests["rejectReason"];

    $length = $requests["length"];
    $width = $requests["width"];
    $height = $requests["height"];
    $lwh = $length * $width * $height;

    if ($qtyBackStatus == 'executer') {
        echo '
        <table class="descriptiontable">
            <thead>
                <th>Item description</th>
                <th >QTY Req</th>
                <th>QTY Issued</th>
            </thead>
            <tbody>
            ';
            if ($rejectItems) {
                $itemsLoop = $rejectItems;
            } else {
                $itemsLoop = $items;
            }
            
            foreach ($itemsLoop as $item) {
                if ($status != 'rejected') {
                    echo '
                    <tr >
                        <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                        <td>' . $item['itemQty'] . '</td>
                        <td>' . $item['wereHouseQty'] . '</td>
                    </tr>
                ';
                }
            }
            echo '
            </tbody>
        </table>
        <button class="submitQTY2" name="dismantling">Done</button>
        ';
    } else {
        echo "<label class='Getrquest'>ReqNo</label>
        <label class='GetrquesQTY'>$reqNo</label>
        <br>
       <br>
        <label class='Getrquest'>Requester</label>
        <label class='GetrquesQTY'>$adminAddedName</label>
        <br>
        <br>
        <label class='Getrquest' >Inspector</label>
        <label class='GetrquesQTY'>$inspector</label>
       <br>
       <br>
        <label class='Getrquest'>Area</label>
        <label class='GetrquesQTY'>$area</label>
        <br>
       <br>
        
        <label class='length'>$length L</label>
        &nbsp; &nbsp; &nbsp;
        <label class='length'>$width W</label>
        &nbsp; &nbsp; &nbsp;
        <label class='length'>$height H</label>
        &nbsp; &nbsp; &nbsp;
        <label class='length'>$lwh m3</label>
      <br>
      <br>
        <label class='Getrquest'>Location</label>
        <label class='GetrquesQTY'>$item</label>
       <br>
        <br>
        <label class='Getrquest'>priority</label>
        <label class='GetrquesQTY'>$priority</label>
         <br>
        <br>
        ";
            if(!$issued){
                echo "
                    <label class='Getrquest'>Notes</label>
                    <label class='GetrquesQTY'>$notes</label>
                    <br>
                    <br>
                    <label class='Getrquest'>Date</label>
                    <br>
                    <input class='inputfieldrequestqty' type='date' id='finishDate' name='finishDate' value= '$finishDate'
                    ";
                    if (!$new) {
                        echo 'readonly ';
                    }
                    echo"
                    >
                ";
            }
        echo"
         ";
        if ($issued && $status != 'rejected') {
            echo '
                <main>
                <table class="description" >
            ';
            if ($status != 'rejected') {
                echo '
                    <th>Item description</th>
                    <th >QTY Req</th>
                    <th>QTY Issued</th>
                    <th>Comment</th>
              
            ';
            }
            if ($rejectItems) {
                $itemsLoop = $rejectItems;
            } else {
                $itemsLoop = $items;
            }
            foreach ($itemsLoop as $item) {
                if ($status != 'rejected') {
                    echo '
                    <tr >
                        <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                        <td>' . $item['itemQty'] . '</td>
                        <td>' . $item['wereHouseQty'] . '</td>
                        <td>' . $item['wereHouseComment'] . '</td>
                    </tr>
                ';
                }
            }
        }
        echo '
        </table>
        </div>
        </main>
        <br>
        ';

        if ($issued && !$executerAccept) {
            echo '
           
                <button class="submitDone" name="accept">Done</button>
            ';
        }
        if ($status == 'rejected' || $status == 'backExecuter') {
            echo '
                <p class="rejectreason">Reject Reason : ' . $rejectReason . '</p>
            ';
        }
        if ($status == 'rejected') {
            echo '
           <br>
           <div>
            <button class="submitDonereg" name="resendToWereHouse">Done</button>
            </div>
            ';
        }
        if ($status == 'backExecuter') {
            echo '
            <button class="submitQTY2" name="resendToInspector">Resend to Inspector</button>
            
            ';
        }
        echo "
    ";
    }

}


?>