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

    $requests = Requests::getWereHouseRequests($con, null, $wereHouse);
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
        <td hidden><input name="rejectsNum[]" value="' . $item['rejectsNum'] . '" readonly></td>
            <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
            <td>' . $item['itemQty'] . '</td>
            ';
        if ($issued) {
            echo "<td> <input class = '' type='number' min = '1' name='wereHouseQty[]' value=' ";
            $item['wereHouseQty'];
            echo "' disabled> </td>";
            echo "<td> <input class = '' type='text' min = '1' name='wereHouseComment[]' value=' ";
            $item['wereHouseComment'];
            echo "' disabled> </td>";
        } else {
            echo "<td> <input class = 'pipiss' type='number' min = '1' name='wereHouseQty[]' value=' ";
            $item['wereHouseQty'];
            echo "'> </td>";
            echo "<td> <input class = 'pipecomm' type='text' min = '1' name='wereHouseComment[]' value=' ";
            $item['wereHouseComment'];
            echo "'> </td>";
        }
        echo '
        </tr>
        ';
    }
    echo "       
        </tbody>
    </table>
    
    ";
    if (!$issued) {
        echo '<button  class="submitGetHose" name="submit">Done</button>';
    }
    echo "
";
}


?>