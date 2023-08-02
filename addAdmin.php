<?php
include_once('includes/classes/Area.php');
include_once('includes/classes/Account.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
    header("location: login.php");
}

$area = new Area($con);
$getArea = $area->getArea();

$account = new Account($con);
$getAccount = $account->getAccount();

if (
    isset($_POST["subm
it"])
) {
    $email = $_POST["email"];
    $areaName = $_POST["areaName"];

    $success = $account->updateUser($email, $areaName, 'admin');

    if ($success) {
        header("location: addAdmin.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css.css?1999">
    <title>add Admin </title>
</head>

<body>
<div class="wrapper">
  <div class="login-container" id="login">
<div class="top">

          <header>Add Admin...</header>
        </div>
        <div class="input-box">
    <form method="POST">
        <select class="input-field" name="areaName">
            <?php echo $getArea; ?>
        </select>
</div>
        <br>
        <div class="input-box">
        <select class="input-field" name="email">
            <?php echo $getAccount; ?>
        </select>
</div>
        <br>

        <div class="input-box">
        <button type="submit" name="submit"  class="submit" >Add</button>
        </div>
    </form>
</body>

</html>