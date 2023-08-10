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

Powers::admin($account, $userEmail);

$request = new Request($con);
$requests = $request->getRequestNumber($adminName);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css?1999">
    <title>Request </title>
</head>

<body>
    <div class="wrappe">
      

        <div class="login-container" id="login">

            <div class="input-box">
                <p class="adminhome">
                    <?php echo $adminName; ?>
                </p>
                <br>

                <p class="Notificationshome">Notifications</p>

                                <a class="addRequest" href="addRequest.php">New Request</a>
                <br>
                <br>
                <a class="addRequest" href="adminRequests.php">Modify Request</a>
                
                
            </div>
        </div>
    </div>

</body>

</html>