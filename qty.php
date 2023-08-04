<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/request.php');

$userEmail = $_COOKIE["email"];
$workOrderNo = $_GET["qtyNo"];
$new = @$_GET["new"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

$request = new Request($con);

if (isset($_POST["submit"])) {
    $pipeQty = $_POST["pipeQty"];
    $clampQty = $_POST["clampQty"];
    $woodQty = $_POST["woodQty"];
    $finishDate = $_POST["finishDate"];

    $success = $request->updateExecuterReq($pipeQty, $clampQty, $woodQty, $finishDate, $workOrderNo);

    if ($success) {
        header("location: notification.php");
    }
}

if (isset($_POST["accept"])) {

    $success = $request->executerAccept($workOrderNo);

    if ($success) {
        header("location: qty.php?qtyNo=".$workOrderNo."");
    }
}

if (isset($_POST["resendToInspector"])) {
    $pipeQty = $_POST["pipeQty"];
    $clampQty = $_POST["clampQty"];
    $woodQty = $_POST["woodQty"];
    
    $success = $request->resendToInspector($pipeQty, $clampQty, $woodQty, $workOrderNo);

    if ($success) {
        header("location: qty.php?qtyNo=".$workOrderNo."");
    }
}

function getInputValue($name)
{
    if (isset($_POST[$name]))
        echo $_POST[$name];
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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Notification</title>
</head>

<body>
<div class="wrappe">
        <?php include_once('includes/navbar.php') ?>

        <div class="login-container" id="login">
    <form method="POST">
    <p class="Name-1"><?php echo $adminName; ?></p>
        <br>
       
        <div id="reqInf"></div>
        <br>
        <?php if ($new)
            echo '
                <table >
                <thead >
                    <th >
                        <select class="input-fiel" id="ItemDescription">
                            <option disabled selected>Item description</option>
                            <option value="Pipe 6M">Pipe 6M</option>
                            <option value="Clamp movable">Clamp movable</option>
                            <option value="Wood 4m">Wood 4m</option>
                        </select>
                    </th>
                    <th><p class="input-fiel"> Qty</p></th>
                </thead>
                <tbody id="ItemDescriptionBody">

                </tbody>
            </table>
            ';
        ?>
        <br>
        <?php if ($new) {
            echo '<button   class="submit"name="submit">Done</button>';
        } ?>
    </form>

    <script>
        let timeout = 2000
        $(window).on("load", function () {
            $.get(
                "ajax/GetRequests.php",
                { isNotification: null, isQty: true, workOrderNo: <?php echo $workOrderNo; ?> },
                function (data) {
                    $("#reqInf").html(data);
                }
            );
        })
    </script>

</body>

</html>