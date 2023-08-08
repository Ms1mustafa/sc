<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);
$isOwner = $account->getAccountDetails($userEmail, null, null, null, true);

Powers::owner($account, $userEmail);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>Owner </title>
</head>

<body>
    <div class="wrappe">
        <?php include_once('includes/navbar.php') ?>

        <div class="login-container" id="login">
            <div class="top">

                <header></header>
            </div>

            <p class="adminName">
                <?php echo $adminName; ?>
            </p>
            <br>
            <p class="adminName">
                <?php echo $userEmail; ?>
            </p>
            <br>

            <div class="input-box">
                <button class="inputfieldlogin"><a href="addArea.php">Add area</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldlogin"><a href="addLocation.php">Add location</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldlogin"><a href="addWorkType.php">Add work type</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldlogin"> <a href="createAccount.php">Create new account</a></button>
            </div>
            <br>
        </div>
    </div>
</body>

</html>