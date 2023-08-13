<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$workOrderNo = $_GET["qtyNo"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

Powers::wereHouse($account, $userEmail);

$request = new Request($con);

if (isset($_POST["submit"])) {
    $pipeQtyStore = @$_POST["pipeQtyStore"];
    $pipeQtyStoreComment = @$_POST["pipeQtyStoreComment"];
    $clampQtyStore = @$_POST["clampQtyStore"];
    $clampQtyStoreComment = @$_POST["clampQtyStoreComment"];
    $woodQtyStore = @$_POST["woodQtyStore"];
    $woodQtyStoreComment = @$_POST["woodQtyStoreComment"];
    $pipeQty = @$_POST["pipeQty"];
    $clampQty = @$_POST["clampQty"];
    $woodQty = @$_POST["woodQty"];

    // $success = $request->updateIssuedReq($adminName, $pipeQty, $clampQty, $woodQty, $pipeQtyStore, $pipeQtyStoreComment, $clampQtyStore, $clampQtyStoreComment, $woodQtyStore, $woodQtyStoreComment, $workOrderNo);

    if ($success) {
        header("location: wereHouse.php");
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>

<body>
<div class="wrappe">
        <?php include_once('includes/navbar.php') ?>

        <div class="login-container" id="login">
       <p class="admin-Name"> <?php echo $adminName; ?></p>
    
     
       
        <form method="POST">
            <div id="reqInf"></div>
        </form>

    </form>

    <script>
        let timeout = 2000
        $(window).on("load", function () {
            $.get(
                "ajax/GetWereHouseReq.php",
                { isNotification: null, wereHouse: '<?php echo $adminName; ?>', workOrderNo : <?php echo $workOrderNo; ?> },
                function (data) {
                    $("#reqInf").html(data);
                }
            );
        })
    </script>

</body>

</html>