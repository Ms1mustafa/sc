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

    echo "<label  class='Getwerhose'>ReqNo</label>

    <label class='Getwerhose1'>$reqNo</label>
   <br>
    <label class='Getwerhose' >Requester </label>
    <label class='Getwerhose2'>$adminAddedName</label>
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
    foreach ($items as $item) {
        echo '
        <tr>
            <td><input class = "pipe1" min = "1" name="itemName[]" value="' . $item['itemName'] . '" readonly></td>
            <td>' . $item['itemQty'] . '</td>
            ';
                if($issued){
                    echo "<td> <input class = 'pipe1' type='number' min = '1' name='wereHouseQty[]' value=' "; $item['wereHouseQty']; echo"' disabled> </td>";
                    echo "<td> <input class = 'pipe1' type='text' min = '1' name='wereHouseComment[]' value=' "; $item['wereHouseComment']; echo"' disabled> </td>";
                }else{
                    echo "<td> <input class = 'pipe1' type='number' min = '1' name='wereHouseQty[]' value=' "; $item['wereHouseQty']; echo"'> </td>";
                    echo "<td> <input class = 'pipe1' type='text' min = '1' name='wereHouseComment[]' value=' "; $item['wereHouseComment']; echo"'> </td>";
                }
            echo'
        </tr>
        ';
    }
    echo "       
        </tbody>
    </table>
    
    ";
    if (!$issued) {
        echo '<button  class="submittt" name="submit">Done</button>';
    }
    echo "
";
}


?>