<?php
require_once("../includes/config.php");
include_once('Requests.php');

$workOrderNo = $_GET['workOrderNo'];
$isRejected = $_GET['isRejected'];

$requests = Requests::getWereHouseItems($con, $workOrderNo);
$rejectItems = Requests::getRejectItemsDes($con, $workOrderNo);

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