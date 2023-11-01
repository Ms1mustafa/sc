<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);

if (!$userToken) {
    header("location: login.php");
}

$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false);

Powers::wereHouse($account, $userToken);

$request = new Request($con);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="gndt.js"></script>

    <title>Notification</title>
</head>

<body>
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
        </div>
        <script>
            // notificationOn();
            Gndt('wereHouse', '<?php echo $adminName; ?>')
        </script>
</body>

</html>