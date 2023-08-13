<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

Powers::wereHouse($account, $userEmail);

$request = new Request($con);


?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>

<body>
<div class="wrappe">
        <?php include_once('includes/navbar.php') ?>

        <div class="login-container" id="login">
        <p class="admin-Name"> <?php echo $adminName; ?></p>
    <br>
    <p class="Notificationqty">Notification</p>
    <div id="result"></div>

    <script>
        let timeout = 0;

        function loadRequests() {
            $.get(
                "ajax/GetWereHouseReq.php",
                { isNotification: true, wereHouse: '<?php echo $adminName; ?>' },
                function (data) {
                    $("#result").html(data);
                }
            );
        }

        function startTimer() {
            loadRequests();
            timeout = 3000;
            setTimeout(startTimer, timeout);
        }

        startTimer();

    </script>
</body>

</html>