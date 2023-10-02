<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$workOrderNo = $_GET["qtyNo"];
$new = @$_GET["new"];
$reject = @$_GET["reject"];

$userToken = Encryption::decryptToken(@$_COOKIE["token"], 'msSCAra');
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::executer($account, $userToken);

if (!$workOrderNo)
    header("location: index.php");

$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);
$anotherExecuter = $account->getTransferAccount('execution', $userEmail);


$request = new Request($con);

$itemName = @$_POST['itemName'];
$itemQty = @$_POST['itemQty'];
$finishDate = @$_POST['finishDate'];
$rejectsNum = $request->getRequestDetails($workOrderNo)["rejectsNum"];

if (isset($_POST["submit"])) {

    $success = $request->executerUpdate($workOrderNo, $itemName, $itemQty, $rejectsNum, $finishDate);

    if ($success) {
        header("location: notification.php");
    }
}

if (isset($_POST["change"])) {
    $newUser = @$_POST['newUser'];
    $success = $request->transfer($newUser, 'executer', $workOrderNo);

    if ($success) {
        header("location: notification.php");
    }
}

if (isset($_POST["accept"])) {

    $success = $request->executerAccept($workOrderNo);

    if ($success) {
        header("location: notification.php");
    }
}

if (isset($_POST["resendToWereHouse"])) {

    $success = $request->updateRejectExecuter($workOrderNo, $itemName, $itemQty, $rejectsNum);

    if ($success) {
        header("location: notification.php");
    }
}

if (isset($_POST["resendToInspector"])) {

    $success = $request->resendToInspector($workOrderNo);

    if ($success) {
        header("location: notification.php");
    }
}

if (isset($_POST["dismantling"])) {
    $success = $request->dismantling('wereHouse', $workOrderNo);

    if ($success) {
        header("location: inspectorPage.php");
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

    <link rel="stylesheet" href="css.css?1990">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>Notification</title>
</head>

<body>
    <div>
        <a class="Back" href="notification.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="newrExcauter">


        <div class="login-container" id="login">
            <form method="POST">
                <p class="namerQTY">
                    <?php echo $adminName; ?>
                </p>

                <br>
                <div id="reqInf"></div>
                <br>
                <?php if ($new || $reject)
                    echo '
           
           
                        <table class="itemestablerq1">
                            <thead >
                                <th >
                                    <select  class="inputfieldGetReq" id="ItemDescription">
                                        <option disabled selected>Item description</option>
                                    </select>
                                </th>
                                <th><p class="inputfieldGetReqoty"> Qty</p></th>
                               
                            </thead>
                            <tbody id="ItemDescriptionBody">

                            </tbody>
                        </table>
                      
                    ';
                if ($reject == 'yes') {
                    echo '
                            <button class="submitDonereg" name="resendToWereHouse">Done</button>
                        ';
                }
                ?>
                <br>
                <?php if ($new) {
                    echo '
                    <button class="submitQTY" name="submit" id="executerDone">Done</button>
                    <br>
                   <br>
                    
                   
                    ';
                } ?>
            </form>

            <script>
                $(document).ready(function () {
                    $.get(
                        "ajax/GetRequests.php",
                        { isNotification: null, executer: '<?php echo $adminName; ?>', workOrderNo: '<?php echo $workOrderNo; ?>' },
                        function (data) {
                            $("#reqInf").html(data);
                        }
                    );
                    $.get(
                        "ajax/GetItemDes.php",
                        function (data) {
                            $("#ItemDescription").append(data);
                        }
                    );
                });

                window.addEventListener("load", () => {
                    // Get the input element
                    const finishDate = document.getElementById("finishDate");

                    // Get today's date
                    const today = new Date().toISOString().split('T')[0];

                    // Set the minimum attribute to restrict dates before today
                    finishDate.min = today;
                })

            </script>
</body>

</html>