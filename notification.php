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

Powers::executer($account, $userEmail);

$request = new Request($con);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css.css">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>

<body>
    <audio id="notificationSound">
        <source src="images/smile-ringtone.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div>
        <a class="buttonlogout" href="logout.php"><i class="fa-sharp fa-solid fa-right-to-bracket"></i> Logout</a>

    </div>
    <div class="wrappereq">

        <div class="login-container" id="login">
            <p class="nameadminrequest">
                <?php echo $adminName; ?>
            </p>
            <br>
            <p class="nameadminrequest">Notification</p>
            <div id="result"></div>

            <button id="playSoundButton">Play Sound</button>

            <script>
                let timeout = 0;
                let previousContent = "";
                
                document.getElementById("playSoundButton").addEventListener("click", function () {
                    playNotificationSound();
                });

                function playNotificationSound() {
                    var audio = document.getElementById("notificationSound");
                    audio.play();
                    // document.getElementById("playSoundButton").click();
                }


                function loadRequests() {
                    $.get(
                        "ajax/GetRequests.php",
                        { isNotification: true, executer: '<?php echo $adminName; ?>' },
                        function (data) {
                            var parser = new DOMParser();
                            var doc = parser.parseFromString(data, 'text/html');
                            var aElements = doc.querySelectorAll('a.notification');
                            var numberOfAElements = aElements.length;

                            if (+numberOfAElements > previousContent) {
                                playNotificationSound();
                            }

                            $("#result").html(data);

                            previousContent = numberOfAElements;

                            setTimeout(loadRequests, 3000);
                        }
                    );
                }

                loadRequests();
            </script>

</body>

</html>