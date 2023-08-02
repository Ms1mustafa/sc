<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$account = new Account($con);

Powers::owner($account, $userEmail);

$area = new Area($con);
$getArea = $area->getArea();

$getAccount = $account->getAccount();

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $areaName = $_POST["areaName"];

    $success = $account->updateUser($email, $areaName,'inspector');

    if ($success) {
        header("location: addAdmin.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner </title>
</head>

<body>
    <form method="POST">
        <select name="areaName">
            <?php echo $getArea; ?>
        </select>

        <br>

        <select name="email">
            <?php echo $getAccount; ?>
        </select>

        <br>

        <button name="submit">Add</button>
    </form>
</body>

</html>