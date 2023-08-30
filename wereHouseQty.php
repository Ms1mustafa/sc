<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$workOrderNo = $_GET["qtyNo"];
if (!$workOrderNo) {
    header("location: index.php");
}
$resent = @$_GET["resent"];
$dismantling = @$_GET["dismantling"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);
$anotherWereHouse = $account->getTransferAccount('wereHouse', $userEmail);

Powers::wereHouse($account, $userEmail);

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
        $success = $request->updateRejectWerehouse($workOrderNo, $itemName, $wereHouseQty, $wereHouseComment, $rejectsNum);
    } else {
        $success = $request->wereHouseUpdate($workOrderNo, $itemName, $wereHouseQty, $rejectsNum, $wereHouseComment);
    }

    if ($success) {
        header("location: wereHouse.php");
    }
}

if (isset($_POST["change"])) {
    $newUser = @$_POST['newUser'];
    $success = $request->transfer($newUser, 'wereHouse', $workOrderNo);

    if ($success) {
        header("location: wereHouse.php");
    }
}

if (isset($_POST["dismantling"])) {
    $success = $request->dismantling('done', $workOrderNo, $rejectsNum, $itemName, $qtyBack, 'requestitemdes', $wereHouseItemName, $wereHouseComment, $wereHouseItemQty);

    if ($success) {
        header("location: wereHousePrint.php?req=".$workOrderNo."");
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
    <div class="wrappe">


        <div class="login-container" id="login">
            <p class="namerQTY">
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
                        <table class="description">
                            <thead >
                                <th >
                                    <select  class="inputfieldGetReq" id="wereHouseItemDescription">
                                        <option disabled selected>Item description</option>
                                    </select>
                                </th>
                                <th><p class="inputfieldGetReqoty"> comment</p></th>
                                <th><p class="inputfieldGetReqoty"> Qty</p></th>
                            </thead>
                            <tbody id="wereHouseItemDescriptionBody">

                            </tbody>
                        </table>
                        <br>
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