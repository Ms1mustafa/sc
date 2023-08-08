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

    echo "<label  class='Getwerhose'>ReqNo</label>

    <label class='Getwerhose1'>$reqNo</label>
   <br>
    <label class='Getwerhose' >Requester </label>
    <label class='Getwerhose2'>$requester</label>
    <br>
    <label  class='Getwerhose'>Inspector</label>
    <label  class='Getwerhose2'>$inspector</label>
   <br>
    <label class='Getwerhose'>Area</label>
    <label class='Getwerhose3'>$area</label>
  <br>
    <label class='Getwerhose'>Location</label>
    <label class='Getwerhose4'>$item</label>
    <br>
    <label class='Getwerhose'>Notes</label>
    <label class='Getwerhose5'>$notes</label>

    <table class='itemestable'>
        <tr>
            <th>Item description</th>
            <th>QTY Req</th>
            <th>QTY Issued</th>
            <th>Comment</th>
       </tr>
        ";
    if ($pipeQty) {
        echo "
                    <tr>
                        <td>Pipe 6M</td>
                        <td><input class = 'pipe1'type='number' name='pipeQty' value='$pipeQty' readonly></td>
                        <td><input class = 'pipe1' type='number' min = '1' name='pipeQtyStore' value='$pipeQtyStore' "; if($issued){echo "disabled";}echo"></td>
                        <td><input  class = 'pipe1' type='text' min = '1' name='pipeQtyStoreComment' value='$pipeQtyStoreComment' "; if($issued){echo "disabled";}echo"></td>
                    </tr>
                ";
    }
    if ($clampQty) {
        echo "
                    <tr>
                        <td>Clamp movable</td>
                        <td><input class = 'clamp1' type='number' name='clampQty' value='$clampQty' readonly></td>
                        <td><input class = 'clamp1' type='number' min = '1' name='clampQtyStore' value='$clampQtyStore' "; if($issued){echo "disabled";}echo"></td>
                        <td><input class = 'clamp1' type='text' name='clampQtyStoreComment' value='$clampQtyStoreComment' "; if($issued){echo "disabled";}echo"></td>
                    </tr>
                ";
    }
    if ($woodQty) {
        echo "
                    <tr>
                        <td>Wood 4m</td>
                        <td><input  class = 'Wood1' type='number' name='woodQty' value='$woodQty' readonly></td>
                        <td><input class = 'Wood1'   type='number' min = '1' name='woodQtyStore' value='$woodQtyStore' "; if($issued){echo "disabled";}echo"></td>
                        <td><input class = 'Wood1' type='text' name='woodQtyStoreComment' value='$woodQtyStoreComment' "; if($issued){echo "disabled";}echo"></td>
                    </tr>
                ";
    }
    echo "       
        </tbody>
    </table>
    
    ";
    if(!$issued){
        echo'<button  class="submittt" name="submit">Done</button>';
    }
    echo"
";
}


?>