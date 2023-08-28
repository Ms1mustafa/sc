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
    $lastrejectItems = Requests::getRejectItemsDes($con, $workOrderNo, true);
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
        <table class="descriptiontable2">
            <thead>
                <th>Item description</th>
                <th >QTY Req</th>
                <th>QTY Issued</th>
                <th hidden>Reject</th>
            </thead>
            <tbody>
            ';
            $mergedItems = array();

            foreach ($rejectItems as $item) {
                if ($status != 'rejected') {
                    $itemName = $item['itemName'];
                    if (!isset($mergedItems[$itemName])) {
                        $mergedItems[$itemName] = array(
                            'itemName' => $itemName,
                            'itemQty' => 0,
                            'wereHouseQty' => 0,
                            'rejectsNum' => 0
                        );
                    }
            
                    $mergedItems[$itemName]['itemQty'] += $item['itemQty'];
                    $mergedItems[$itemName]['wereHouseQty'] += $item['wereHouseQty'];
                    $mergedItems[$itemName]['rejectsNum'] += $item['rejectsNum'];
                }
            }
            
            foreach ($mergedItems as $item) {
                echo '
                    <tr>
                        <td><input class="pipe1" min="1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                        <td>' . $item['itemQty'] . '</td>
                        <td>' . $item['wereHouseQty'] . '</td>';
                if ($item["rejectsNum"] > 0) {
                    echo '<td hidden>reject ' . $item["rejectsNum"] . '</td>';
                }
                echo '</tr>';
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
                    <label class='GetOTYNote'>Notes</label>
                    <br>
                    <textarea class='QTYnotes'>$notes</textarea>
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
                <div>
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
            foreach ($lastrejectItems as $item) {
                if ($status != 'rejected') {
                    echo '
                    <tr >
                        <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                        <td>' . $item['itemQty'] . '</td>
                        <td>' . $item['wereHouseQty'] . '</td>
                        <td><textarea class = "pipecomm">' . $item['wereHouseComment'] . '</textarea></td>
                    </tr>
                ';
                }
            }
        }
        echo '
        </table>
        </div>
        </main>
     
        ';

        if ($issued && !$executerAccept) {
            echo '
           <div>
                <button class="submitDone" name="accept">Done</button>
            ';
        }
        if ($status == 'rejected' || $status == 'backExecuter') {
            echo '
                <p class="rejectreason2">Reject Reason : ' . $rejectReason . '</p>
                </div>
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