<?php
require_once("../includes/config.php");
include_once('Requests.php');


$workOrderNo = $_GET['workOrderNo'];
$isRejected = $_GET['isRejected'];

$request = Requests::getRequest($con, $workOrderNo);
$requests = Requests::getWereHouseItems($con, $workOrderNo);
$rejectItems = Requests::getRejectItemsDes($con, $workOrderNo);

$reqNo = $request["reqNo"];
$adminAddedName = $request["adminAddedName"];
$inspector = $request["inspector"];
$area = $request["area"];
$item = $request["item"];

echo "
    <table class='descriptiontableReceivingMaterials'>
        <thead>
            <th>Item description</th>
            <th>QTY Issued</th>
            <th>QTY dismantling</th>
            <th>Comment</th>
        </thead>
        <tbody>
    ";

echo "
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
    ";

if ($isRejected) {
    $maxRejectsNum = -1; // Initialize with a low value
    foreach ($rejectItems as $item) {
        if ($item['rejectsNum'] > $maxRejectsNum) {
            $maxRejectsNum = $item['rejectsNum'];
        }
    }

    // Filter rows with the maximum rejectsNum value
    $rowsWithMaxRejectsNum = [];
    foreach ($rejectItems as $item) {
        if ($item['rejectsNum'] === $maxRejectsNum) {
            $rowsWithMaxRejectsNum[] = $item;
        }
    }

    // Now $rowsWithMaxRejectsNum contains the rows with the highest rejectsNum
    foreach ($rowsWithMaxRejectsNum as $item) {
        echo '
                <tr>
                    <td>' . $item['itemName'] . '</td>
                    <td>' . $item['wereHouseQty'] . '</td>
                    <td>' . $item['qtyBack'] . '</td>
                </tr>
            ';
    }
} else {

    foreach ($rejectItems as $item) {
        $itemName = $item['itemName'];
        if (!isset($mergedItems[$itemName])) {
            $mergedItems[$itemName] = array(
                'itemName' => $itemName,
                'itemQty' => 0,
                'wereHouseQty' => 0,
                'rejectsNum' => 0,
                'qtyBack' => 0
            );
        }

        $mergedItems[$itemName]['wereHouseQty'] += $item['wereHouseQty'];
        $mergedItems[$itemName]['rejectsNum'] += @$item['rejectsNum'];
        $mergedItems[$itemName]['qtyBack'] = @$item['qtyBack'];
    }

    foreach ($mergedItems as $item) {
        echo '
        <tr>
            <td>' . $item['itemName'] . '</td>
            <td>' . $item['wereHouseQty'] . '</td>
            <td>' . $item['qtyBack'] . '</td>
            <td></td>
        </tr>
    ';
    }

    foreach ($requests as $request) {
        $itemName = $request["itemName"];
        $wereHouseComment = $request["wereHouseComment"];
        $qtyBack = $request["qtyBack"];
        echo "
        <tr>
            <td>$itemName</td>
            <td></td>
            <td>$qtyBack</td>
            <td> <textarea class='pipecomitm pipecomm' readonly>$wereHouseComment</textarea ></td>
        </tr>
    ";
    }
}
?>