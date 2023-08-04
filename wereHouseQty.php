<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$workOrderNo = $_GET["qtyNo"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

Powers::wereHouse($account, $userEmail);

$request = new Request($con);

if (isset($_POST["submit"])) {
    $pipeQtyStore = @$_POST["pipeQtyStore"];
    $pipeQtyStoreComment = @$_POST["pipeQtyStoreComment"];
    $clampQtyStore = @$_POST["clampQtyStore"];
    $clampQtyStoreComment = @$_POST["clampQtyStoreComment"];
    $woodQtyStore = @$_POST["woodQtyStore"];
    $woodQtyStoreComment = @$_POST["woodQtyStoreComment"];
    $pipeQty = @$_POST["pipeQty"];
    $clampQty = @$_POST["clampQty"];
    $woodQty = @$_POST["woodQty"];

    $success = $request->updateIssuedReq($adminName, $pipeQty, $clampQty, $woodQty, $pipeQtyStore, $pipeQtyStoreComment, $clampQtyStore, $clampQtyStoreComment, $woodQtyStore, $woodQtyStoreComment, $workOrderNo);

    if ($success) {
        header("location: wereHouse.php");
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>

<body>
    <form method="POST">
        <?php echo $adminName; ?>
        <br>
        <p>QTY</p>
        <form method="POST">
            <div id="reqInf"></div>
        </form>

    </form>

    <script>
        let timeout = 2000
        $(window).on("load", function () {
            $.get(
                "ajax/GetStoreRequests.php",
                { isNotification: null, isQty: true, workOrderNo: <?php echo $workOrderNo; ?> },
                function (data) {
                    $("#reqInf").html(data);
                }
            );
        })
    </script>

</body>

</html>