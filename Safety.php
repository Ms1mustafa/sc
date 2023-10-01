<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$account = new Account($con);
$isAcc = $account->getAccountDetails($userEmail, true);

if (!$userEmail || !$isAcc) {
    header("location: login.php");
}

Powers::Safety($account, $userEmail);
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
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>Request </title>
</head>

<body>
    <div>
        <a class="buttonlogout" href="logout.php"><i class="fa-sharp fa-solid fa-right-to-bracket"></i> Logout</a>

    </div>
    <div class="wrappereq">


        <div class="login-container" id="login">
            <div class="input-box">
                <button class="inputfieldowner"><a href="SafetyRequisted.php">Requisted</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldowner"> <a href="Accipted.php">Accipted</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldowner"> <a href="Rejected.php">Rejected</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldowner"> <a href="Done.php">Done</a></button>
            </div>
            <br>
            <div class="input-box">
                <button class="inputfieldowner"> <a href="dismantling.php"> Dismantling</a></button>
            </div>
        </div>
    </div>

    </div>

</body>

</html>