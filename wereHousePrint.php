<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$workOrderNo = $_GET["req"];
$isRejected = @$_GET["rejected"];
$firstCm = @$_GET["firstCm"];

if (!$workOrderNo)
    header("location: index.php");

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

Powers::wereHouse($account, $userToken);

// require_once('ajax/GetWereHousePrint.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>


<body>
    <div>
        <a class="Back" href="wereHouseQty.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="wrappe">


        <div class="login-container" id="login">
            <h1 class="ReceivingMaterials">Receiving Materials</h1>
            <br>
            <br>
            <div id="reqInf"></div>
            <h3 class="Issued">Issued By: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; Recorded By:</h3>
            <button class="Print" id="printButton">Print</button>

            <script>
                $(window).on("load", function () {
                    $.get(
                        "ajax/GetWereHousePrint.php",
                        { workOrderNo: '<?php echo $workOrderNo; ?>', isRejected: '<?php echo $isRejected; ?>', firstCm: '<?php echo $firstCm; ?>' },
                        function (data) {
                            $("#reqInf").html(data);
                        }
                    );
                })
            </script>

</body>

</html>