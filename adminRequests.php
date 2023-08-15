<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$requestAction = true;

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

// Powers::executer($account, $userEmail);

$request = new Request($con);


?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>

<body>
    <div>
<a class="Back" href="home.php">
    <i class="fa-solid fa-arrow-left"></i>    Back</a>
</div>

<div class="wrappe">
       
        
        <div class="login-container" id="login">
    <p class="nameadminrequest"><?php echo $adminName; ?></p>
    <br>
    <p class="nameadminrequest">Notification</p>
    <div id="result"></div>

    <script>
        let timeout = 0;

        function loadRequests() {
            $.get(
                "ajax/GetAdminReq.php",
                { isNotification : true, admin: '<?php echo $adminName; ?>', requestAction: true },
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