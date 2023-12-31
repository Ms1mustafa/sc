<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userEmail = $_COOKIE["email"];
$account = new Account($con);

Powers::owner($account, $userEmail);

$area = new Area($con);
$getArea = $area->getArea();

$getAccount = $account->getAccount();

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $areaName = $_POST["areaName"];

    $success = $account->updateUser($email, $areaName, 'inspector');

    if ($success) {
        header("location: ownerPage.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>Owner </title>
</head>

<body>
    <div>
        <a class="Back" href="ownerPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
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