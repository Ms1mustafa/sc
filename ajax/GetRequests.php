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
    
    <label class='length'>$length m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$width m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$height m</label>
    &nbsp; &nbsp; &nbsp;
    <label class='length'>$lwh m</label>
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
    <label class='Getrquest'>Notes</label>
    <label class='GetrquesQTY'>$notes</label>
    <br>
   <br>
    <label class='Getrquest'>Date</label>
   <br>
   <br>
    <input class='inputfieldrequestqty' type='date' name='finishDate' value= '$finishDate' ";

    if (!$new) {
        echo 'readonly ';
    }
    echo "required>
    ";
    if ($issued) {
        echo '
        <main>
   
      
        <table class="description" >
       
                <th>Item description</th>
                <th >QTY Req</th>
                <th>QTY Issued</th>
                <th>Comment</th>
          
        ';
        foreach ($items as $item) {
            echo '
            <tr>
                <td><input class = "" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                <td>' . $item['itemQty'] . '</td>
                
                <td><input class = "" min = "1" name="itemName[]" value="' . $item['wereHouseQty'] . '" readonly></td>
                <td><input class = "" min = "1" name="itemName[]" value="' . $item['wereHouseComment'] . '" readonly></td>
                

            </tr>
            ';
        }
    }
    echo '
    </tbody>
    </table>
    </div>
    </main>
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