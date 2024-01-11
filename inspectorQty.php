<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$workOrderNo = $_GET["qtyNo"];

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

if (!$workOrderNo)
    header("location: index.php");

$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false);

Powers::inspector($account, $userToken);

$request = new Request($con);
$rejectsNum = $request->getRequestDetails($workOrderNo)["rejectsNum"] + 1;

if (isset($_POST["accept"])) {
    $success = $request->updateInspectorReq('accepted', '', $workOrderNo, '', $request->getRequestDetails($workOrderNo)["adminAddedName"], "Witing Dismalation");

    if ($success) {
        header("location: inspectorPage.php");
    }
}

if (isset($_POST["reject"])) {
    $rejectReason = @$_POST["rejectReason"];

    $success = $request->updateInspectorReq('rejected', $rejectReason, $workOrderNo, $rejectsNum, $request->getRequestDetails($workOrderNo)["executer"], "Reject Execution");

    if ($success) {
        header("location: inspectorPage.php");
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css?1999">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>Notification</title>
</head>

<body>
    <div>
        <a class="Back" href="inspectorPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <div class="wrappe">

        <div class="login-container" id="login">
            <form method="POST">
                <p class="namerQTY">
                    <?php echo $adminName; ?>
                </p>
                <br>

                <form method="POST">
                    <div id="reqInf"></div>
                </form>

            </form>

            <script>
                let timeout = 2000
                $(window).on("load", function () {
                    $.get(
                        "ajax/GetInspectorRequests.php",
                        { isNotification: null, inspector: '<?php echo $adminName; ?>', workOrderNo: '<?php echo $workOrderNo; ?>' },
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