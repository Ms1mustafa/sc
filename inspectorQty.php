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

Powers::inspector($account, $userEmail);

$request = new Request($con);

if (isset($_POST["accept"])) {
    $success = $request->updateInspectorReq('accepted', '', $workOrderNo);

    if ($success) {
        header("location: inspectorQty.php?qtyNo=" . $workOrderNo . "");
    }
}

if (isset($_POST["reject"])) {
    $rejectReason = @$_POST["rejectReason"];

    $success = $request->updateInspectorReq('rejected', $rejectReason, $workOrderNo);

    if ($success) {
        header("location: inspectorQty.php?qtyNo=" . $workOrderNo . "");
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
    <script src="script.js" defer></script>
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
                "ajax/GetInspectorRequests.php",
                { isNotification: null, isQty: true, workOrderNo: <?php echo $workOrderNo; ?> },
                function (data) {
                    $("#reqInf").html(data);
                }
            );
        })

        function addRequiredAttribute() {
            const rejectReason = document.getElementById('rejectReason');
            rejectReason.required = true;
        }

        function removeRequiredAttribute() {
            const rejectReason = document.getElementById('rejectReason');
            rejectReason.required = false;
        }
    </script>

</body>

</html>