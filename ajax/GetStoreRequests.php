<?php
require_once("../includes/config.php");
require_once("Requests.php");
include_once('../includes/classes/FormSanitizer.php');
include_once('../includes/classes/Notification.php');

$isNotification = $_GET['isNotification'];
$isQty = $_GET['isQty'];
$workOrderNo = $_GET['workOrderNo'];
if ($isNotification != null) {

    $requests = Requests::getRequest($con, $isNotification, false, null, true);
    foreach ($requests as $request) {
        $notification = new Notification();

        echo $notification->getWereHouseNotification($request);
    }
}

if ($isQty != null) {

    $requests = Requests::getRequest($con, false, $isQty, $workOrderNo);
    $reqNo = $requests["reqNo"];
    $workOrderNo = $requests["workOrderNo"];
    $requester = $requests["name"];
    $inspector = $requests["inspector"];
    $area = $requests["area"];
    $item = $requests["item"];
    $notes = $requests["notes"];
    $pipeQty = $requests["pipeQty"];
    $clampQty = $requests["clampQty"];
    $woodQty = $requests["woodQty"];
    $pipeQtyStore = $requests["pipeQtyStore"];
    $pipeQtyStoreComment = $requests["pipeQtyStoreComment"];
    $clampQtyStore = $requests["clampQtyStore"];
    $clampQtyStoreComment = $requests["clampQtyStoreComment"];
    $woodQtyStore = $requests["woodQtyStore"];
    $woodQtyStoreComment = $requests["woodQtyStoreComment"];
    $issued = $requests["issued"] == 'yes' ? true : null;
    $new = $requests["new"] == "yes" ? "New" : "";
    $status = $requests["status"];

    echo "<label  class='num'>ReqNo</label>
    <label class='number'>$reqNo</label>
   
    <label class='num-1' >Requester </label>
    <label class='number-1'>$requester</label>
    <br>
    <label  class='num'>Inspector</label>
    <label  class='number-2'>$inspector</label>
   
    <label class='num-3'>Area</label>
    <label class='number-1'>$area</label>
  
    <label class='num'>Location</label>
    <label class='number-2'>$item</label>
    
    <label class='num-4'>Notes</label>
    <label class='number-4'>$notes</label>

    <table>
        <thead>
            <th>Item description</th>
            <th>QTY Req</th>
            <th>QTY Issued</th>
            <th>Comment</th>
        </thead>
        <tbody>
        ";
    if ($pipeQty) {
        echo "
                    <tr>
                        <td>Pipe 6M</td>
                        <td><input type='number' name='pipeQty' value='$pipeQty' readonly></td>
                        <td><input type='number' min = '1' name='pipeQtyStore' value='$pipeQtyStore' "; if($issued){echo "disabled";}echo"></td>
                        <td><input type='text' name='pipeQtyStoreComment' value='$pipeQtyStoreComment' "; if($issued){echo "disabled";}echo"></td>
                    </tr>
                ";
    }
    if ($clampQty) {
        echo "
                    <tr>
                        <td>Clamp movable</td>
                        <td><input type='number' name='clampQty' value='$clampQty' readonly></td>
                        <td><input type='number' min = '1' name='clampQtyStore' value='$clampQtyStore' "; if($issued){echo "disabled";}echo"></td>
                        <td><input type='text' name='clampQtyStoreComment' value='$clampQtyStoreComment' "; if($issued){echo "disabled";}echo"></td>
                    </tr>
                ";
    }
    if ($woodQty) {
        echo "
                    <tr>
                        <td>Wood 4m</td>
                        <td><input type='number' name='woodQty' value='$woodQty' readonly></td>
                        <td><input type='number' min = '1' name='woodQtyStore' value='$woodQtyStore' "; if($issued){echo "disabled";}echo"></td>
                        <td><input type='text' name='woodQtyStoreComment' value='$woodQtyStoreComment' "; if($issued){echo "disabled";}echo"></td>
                    </tr>
                ";
    }
    echo "       
        </tbody>
    </table>
    
    ";
    if(!$issued){
        echo'<button  class="submit" name="submit">Done</button>';
    }
    echo"
";
}


?>