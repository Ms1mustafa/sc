<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$wereHouse = $_GET['wereHouse'];

if ($isNotification != null) {

    $requests = Requests::getWereHouseRequests($con, true, $wereHouse);
    foreach ($requests as $request) {
        $notification = new Notification();

        echo $notification->getWereHouseNotification($request);
    }
}

if ($isNotification == null) {
    $workOrderNo = $_GET['workOrderNo'];

    $requests = Requests::getWereHouseRequests($con, null, $wereHouse, $workOrderNo);
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
    $qtyBackStatus = $requests["qtyBackStatus"];

    if ($qtyBackStatus == 'wereHouse') {
        echo '
        <table class="descriptiontable2">
            <thead>
                <th>Item description</th>

                <th >QTY Req</th>
                <th>QTY Issued</th>
                <th>QTY dismantling</th>
            </thead>
            <tbody>
            ';
        if ($rejectItems) {
            $itemsLoop = $rejectItems;
        } else {
            $itemsLoop = $items;
        }

        $dismantling = $rejectItems ? 'rejectDismantling' : 'dismantling';
        foreach ($itemsLoop as $item) {
            if ($status != 'rejected') {
                echo '
                    <tr >
                        <td hidden><input name="rejectsNum[]" value="' . @$item['rejectsNum'] . '" readonly></td>
                        <td>' . $item['itemName'] . '</td>
                        <td>' . $item['itemQty'] . '</td>
                        <td>' . $item['wereHouseQty'] . '</td>
                        <td>' . $item['wereHouseComment'] . '</td>
                    </tr>
                ';
            }
        }
        echo '
            </tbody>
        </table>
        <button class="submitGetHose" name="'.$dismantling.'">Done</button>
        ';
    } else {

        echo "<label  class='Getrquest'>ReqNo</label>

    <label class='GetrquesQTY'>$reqNo</label>
   <br>
   <br>
    <label class='Getrquest' >Requester </label>
    <label class='GetrquesQTY'>$adminAddedName</label>
    <br>
    <br>
    <label  class='Getrquest'>Inspector</label>
    <label  class='GetrquesQTY'>$inspector</label>
   <br>
   <br>
    <label class='Getrquest'>Area</label>
    <label class='GetrquesQTY'>$area</label>
  <br>
  <br>
    <label class='Getrquest'>Location</label>
    <label class='GetrquesQTY'>$item</label>
    <br>
    <br>
   <div>
    <table class='itemestable'>
        <tr>
            <th>Item description</th>
            <th>QTY Req</th>
            <th>QTY Issued</th>
            <th>Comment</th>
        </tr>
        ";
        if ($rejectItems) {
            $itemsLoop = $rejectItems;
        } else {
            $itemsLoop = $items;
        }

        foreach ($itemsLoop as $item) {
            echo '
        <tr>
        <td hidden><input name="rejectsNum[]" value="' . @$item['rejectsNum'] . '" readonly></td>
            <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
            <td>' . $item['itemQty'] . '</td>
            ';
            echo "<td> <input class = 'pipiss' type='number' min = '1' name='wereHouseQty[]' value=' ";
            $item['wereHouseQty'];
            echo "'> </td>";
            echo "<td>  <textarea class = 'pipecomm' type='text' min = '1' name='wereHouseComment[]' value=' ";
            $item['wereHouseComment'];
            echo "'>  </textarea></td>";
            echo '
        </tr>
        ';
        }
        echo "       
        </tbody>
    </table>
    </div>
    <div>
    <button  class='submitGetHose' name='submit'>Done</button>
    </div>
    ";
        echo "
";
    }
}


?>