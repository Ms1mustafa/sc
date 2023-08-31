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
    $lastrejectItems = Requests::getRejectItemsDes($con, $workOrderNo, true);
    $rejectItems = Requests::getRejectItemsDes($con, $workOrderNo);
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

    echo "
    <div class = 'notPrint'>
    <label  class='Getrquest'>ReqNo</label>

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
    </div>
    ";

    if ($qtyBackStatus == 'wereHouse') {
        
        echo '
        </tbody>
        </table>
        <table class="descriptiontable2">
            <thead>
                <th>Item description</th>
                <th hidden>QTY Req</th>
                <th>QTY Issued</th>
                <th hidden>Rejects</th>
                <th>QTY dismantling</th>
            </thead>
            <tbody>
            ';
            $mergedItems = array();

            if ($rejectItems) {
                $itemsLoop = $rejectItems;
            } else {
                $itemsLoop = $items;
            }
            
            $dismantling = 'dismantling';
            foreach ($itemsLoop as $item) {
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
            
                    $mergedItems[$itemName]['wereHouseQty'] += $item['wereHouseQty'];
                    $mergedItems[$itemName]['rejectsNum'] += @$item['rejectsNum'];
                }
            }
            
            foreach ($mergedItems as $item) {
                echo '
                    <tr>
                        <td><input class="pipe1" min="1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
                        <td hidden>' . $item['itemQty'] . '</td>
                        <td>' . $item['wereHouseQty'] . '</td>
                        <td hidden><input class="pipiss" name="rejectsNum[]" value="' . @$item['rejectsNum'] . '" readonly></td>
                        <td><input class="pipiss" type="number" min="1" name="qtyBack[]" required></td>
                    </tr>
                ';
            }
            
        echo '
            </tbody>
        </table>
        <button class="buttondismantling" name="' . $dismantling . '">Done</button>
        ';
    } else {

        echo "
   <div>
   <h1 class='ReceivingMaterialswere'>Receiving Materials</h1>
   <br>
    <table class='itemestable'>
        <tr>
            <th>Item description</th>
            <th>QTY Req</th>
            <th>QTY Issued</th>
            <th>Comment</th>
        </tr>
        ";
        foreach ($lastrejectItems as $item) {
            echo '
        <tr>
        <td hidden><input name="rejectsNum[]" value="' . @$item['rejectsNum'] . '" readonly></td>
            <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
            <td>' . $item['itemQty'] . '</td>
            ';
            echo "<td> <input class = 'pipiss' type='number' min = '1' name='wereHouseQty[]' value= " . @$item['wereHouseQty'] . "> </td>";
            echo "<td><textarea class = 'pipecomm' type='text' min = '1' name='wereHouseComment[]' ";
            if (@$item['wereHouseComment']) {
                echo 'readonly';} echo">". @$item['wereHouseComment'] ."</textarea></td>";
            echo '
        </tr>
        ';
        }
        echo "       
        </tbody>
    </table>
    </div>
    <div>
    <h3 class='Issuedprint'>Issued By: &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   Recorded By:</h3>
    <button  class='submitGetHose' name='submit'>Done</button>
    </div>
    ";
        echo "
";
    }
}


?>