<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$workOrderNo = $_GET["workOrderNo"];
$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

if (!@$workOrderNo)
    header("Location: home.php");

$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false);

Powers::admin($account, $userToken);

$request = new Request($con);

if (isset($_POST["dismantling"])) {
    $success = $request->dismantling('executer', $workOrderNo, $request->getRequestDetails($workOrderNo)["executer"], "Dismantling");

    if ($success) {
        header("location: inspectorPage.php");
    }
}

if (isset($_POST["doneReq"])) {
    $success = $request->requesterDone($workOrderNo, 'dismantilingDone', true, $request->getRequestDetails($workOrderNo)["adminAddedName"], "Done");
    if ($success) {
        header("location: inspectorPage.php");
    }
}

if (isset($_POST["RequesterDismDone"])) {
    $success = $request->RequesterDismDone($workOrderNo);
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
    <link rel="stylesheet" href="css.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Notification</title>
</head>

<body>
    <div>
        <a class="Back" href="home.php">
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

                    <?php
                    if (@$_GET["status"] == 'done' || @$_GET["status"] == 'rejected') {
                        echo '<button class="submitDismantling" name="doneReq">Done</button>';
                    }
                    ?>
                </form>


            </form>

            <script>
                let timeout = 2000
                $(window).on("load", function () {
                    $.get(
                        "ajax/GetAdminReq.php",
                        { isNotification: null, admin: '<?php echo $adminName; ?>', workOrderNo: '<?php echo $workOrderNo; ?>' },
                        function (data) {
                            $("#reqInf").html(data);
                        }
                    );
                })
            </script>

</body>

</html>