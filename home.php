<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false);

Powers::admin($account, $userToken);

$request = new Request($con);
// $requests = $request->getRequestNumber($adminName);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="gndt.js"></script>
    <script></script>
    <link rel="stylesheet" href="css.css">
    <title>Request </title>
</head>

<body>
    <div>
        <a class="buttonlogout" href="logout.php"><i class="fa-sharp fa-solid fa-right-to-bracket"></i> Logout</a>

    </div>
    <div class="wrappereq">


        <div class="login-container" id="login">

            <div class="input-box">
                <p class="adminhome">
                    <?php echo $adminName; ?>
                </p>
                <br>

                <p class="Notificationshome">Notifications</p>
                <br>
                <div id="result"></div>

                <a class="addRequest" href="addRequest.php">New Request</a>
                <br>
                <br>
                <a class="addRequest" href="adminRequests.php">Modify Request</a>
                <br>
                <br>
                <a class="addRequest" href="allReq.php?type=requester">All Requests</a>


            </div>
        </div>

    </div>

    <!-- <script>
        // notificationOn();
        Gndt('home', '<?php echo $adminName; ?>')
    </script> -->
    <script>
        let timeout = 0;

        function loadRequests() {
            $.get(
                "ajax/GetAdminReq.php",
                { isNotification: true, admin: '<?php echo $adminName; ?>', requestAction: null },
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