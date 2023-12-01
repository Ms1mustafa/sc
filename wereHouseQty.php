<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');
include_once('includes/classes/SendMail.php');

$workOrderNo = $_GET["qtyNo"];
$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

if (!$workOrderNo) {
    header("location: index.php");
}

$resent = @$_GET["resent"];
$dismantling = @$_GET["dismantling"];

$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false);
$anotherWereHouse = $account->getTransferAccount('wereHouse', $userEmail);

Powers::wereHouse($account, $userToken);

$request = new Request($con);
$itemName = @$_POST['itemName'];
$wereHouseQty = @$_POST['wereHouseQty'];
$wereHouseComment = @$_POST['wereHouseComment'];
$rejectsNum = @$_POST['rejectsNum'];
$qtyBack = @$_POST['qtyBack'];

$wereHouseItemName = @$_POST['wereHouseItemName'];
$wereHouseComment = @$_POST['wereHouseComment'];
$wereHouseItemQty = @$_POST['wereHouseItemQty'];

if (isset($_POST["submit"])) {
    if ($resent == 'yes') {
        $success = $request->updateRejectWerehouse($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment, $rejectsNum, $request->getRequestDetails($workOrderNo)["executer"], "Reject");
    } else {
        $success = $request->wereHouseUpdate($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment, $request->getRequestDetails($workOrderNo)["executer"], "Done");
    }

    if ($success) {
        $executer = $account->getMainAccount('Execution');
        $toMail = $account->getMailByName($executer);
        $sendMail = new SendMail();
        $mailDone = $sendMail->sendMail($toMail, "New notification from $adminName");
        if ($resent == 'yes') {
            header("location: wereHousePrint.php?req=" . $workOrderNo . "&rejected=1");
        } else {
            header("location: wereHousePrint.php?req=" . $workOrderNo . "&firstCm=1");
        }
    }
}

if (isset($_POST["change"])) {
    $newUser = @$_POST['newUser'];
    $success = $request->transfer($newUser, 'wereHouse', $workOrderNo);

    if ($success) {
        header("location: wereHousePrint.php?req=" . $workOrderNo . "");
    }
}

if (isset($_POST["dismantling"])) {
    $success = $request->dismantling('done', $workOrderNo, $request->getRequestDetails($workOrderNo)["adminAddedName"], "Dismantling", $rejectsNum, $itemName, $qtyBack, 'requestitemdes', $wereHouseItemName, $wereHouseComment, $wereHouseItemQty);

    if ($success) {
        header("location: wereHousePrint.php?req=" . $workOrderNo . "");
    }
}

function getInputValue($name)
{
    if (isset($_POST[$name]))
        echo $_POST[$name];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>


<body>
    <div>
        <a class="Back" href="wereHouse.php">

            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="printwerehouse">
        <?php
        if ($dismantling != 'yes') {
            echo '
                    <i class="fa-solid fa-print"  id="printButton"></i>
                ';
        }
        ?>

    </div>
    <div class="wrappe">


        <div class="login-container" id="login">
            <p class="namerQTY notPrint">
                <?php echo $adminName; ?>
            </p>
            <br>

            <form method="POST">
                <div id="reqInf"></div>

                <?php
                /*
                if ($resent == 'no') {
                    echo '
                    <select name = "newUser">
                                    <option selected disabled>Select WereHouse</option>
                             
                                    ';
                    echo $anotherWereHouse;
                    echo '
                                </select>
                                <br>
                                <button class=""name="change">Send to another executer</button>
                    ';
                }
                */

                if ($dismantling == 'yes') {
                    echo '
                    <br><br>
                        <table class="itemestablerq">
                            <thead >
                                <th >
                                    <select  class="inputfieldGetReq" id="wereHouseItemDescription">
                                        <option disabled selected>Item description</option>
                                    </select>
                                </th>
                                <th><p class="inputfieldGetReqoty"> comment</p></th>
                                <th><p class="inputfieldGetReqoty"> Qty</p></th>
                                <th><p class="inputfieldGetReqoty"> delete</p></th>
                            </thead>
                            <tbody id="wereHouseItemDescriptionBody">

                            </tbody>
                        </table>
                        <br>
                        <button class="buttondismantling" name="dismantling">Done</button>
                    ';
                }
                ?>
            </form>

            <script>
                let timeout = 2000
                $(window).on("load", function () {
                    $.get(
                        "ajax/GetWereHouseReq.php",
                        { isNotification: null, wereHouse: '<?php echo $adminName; ?>', workOrderNo: '<?php echo $workOrderNo; ?>' },
                        function (data) {
                            $("#reqInf").html(data);
                        }
                    );
                })

                $.get(
                    "ajax/GetItemDes.php",
                    function (data) {
                        $("#wereHouseItemDescription").append(data);
                    }
                );
            </script>

</body>

</html>