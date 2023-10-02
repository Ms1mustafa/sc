<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], 'msSCAra');
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

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
                <div id="result"></div>

                <a class="addRequest" href="addRequest.php">New Request</a>
                <br>
                <br>
                <a class="addRequest" href="adminRequests.php">Modify Request</a>


            </div>
        </div>

    </div>

    <script>
        notificationOn();

        let timeout = 0;
        let previousContent = "";
        let isFirstLoad = true; // Flag to track the initial page load

        function loadRequests() {
            $.get(
                "ajax/GetAdminReq.php", {
                isNotification: true,
                admin: '<?php echo $adminName; ?>'
            },
                function (data) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(data, 'text/html');
                    var aElements = doc.querySelectorAll('a.notification');
                    var numberOfAElements = aElements.length;

                    if (!isFirstLoad && +numberOfAElements > previousContent) {
                        sendNotification(`New notification from ${doc.querySelector('span.sender').textContent}`,
                            "tap to see the details", "images/notification.png",
                            window.location.href);
                    }

                    $("#result").html(data);

                    previousContent = numberOfAElements;
                    isFirstLoad = false; // Set the flag to false after the first load

                    setTimeout(loadRequests, 3000);
                }
            );
        }

        loadRequests();
    </script>
</body>

</html>