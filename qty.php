<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');
include_once('includes/classes/SendMail.php');

$workOrderNo = $_GET["qtyNo"];
$new = @$_GET["new"];
$reject = @$_GET["reject"];

$err = '';
$errDate = '';

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::executer($account, $userToken);

if (!$workOrderNo)
    header("location: index.php");

$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false);
$anotherExecuter = $account->getTransferAccount('execution', $userEmail);


$request = new Request($con);
$wereHouse = $request->getWereHouse($workOrderNo);
$requester = $request->getRequester($workOrderNo);
$inspector = $request->getInspector($workOrderNo);

$itemName = @$_POST['itemName'];
$itemQty = @$_POST['itemQty'];
$finishDate = @$_POST['finishDate'];
$rejectsNum = $request->getRequestDetails($workOrderNo)["rejectsNum"];

if (isset($_POST["submit"])) {
    if (!$itemName)
        $err = 'please add 1 item description at least';
    if (!$finishDate)
        $errDate = 'please select date';
    if ($itemName && $finishDate)
        $success = $request->executerUpdate($workOrderNo, $itemName, $itemQty, $rejectsNum, $finishDate, $request->getRequestDetails($workOrderNo)["wereHouse"], "Issu Materials");

    if (@$success) {
        $toMail = $account->getMailByName($wereHouse);
        $sendMail = new SendMail();
        $mailDone = $sendMail->sendMail($toMail, "New notification from $adminName");
        header("location: notification.php");
    }
}

$errRejectReason = '';

if (isset($_POST["reject"])) {
    $rejectReason = @$_POST['rejectReason'];

    if (!$rejectReason)
        $errRejectReason = 'please write rejectReason';
    if ($rejectReason)
        $success = $request->executerReject($workOrderNo, $rejectReason, $request->getRequestDetails($workOrderNo)["adminAddedName"], "Reject");

    if (@$success) {
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

    $success = $request->executerAccept($workOrderNo, $request->getRequestDetails($workOrderNo)["inspector"], "Wating Inspecter");

    if ($success) {
        $toMail = $account->getMailByName($inspector);
        $sendMail = new SendMail();
        $mailDone = $sendMail->sendMail($toMail, "New notification from $adminName");
        header("location: notification.php");
    }
}

if (isset($_POST["resendToWereHouse"])) {

    $success = $request->updateRejectExecuter($workOrderNo, $itemName, $itemQty, $rejectsNum, $request->getRequestDetails($workOrderNo)["wereHouse"], "Issu Materials Reject");

    if ($success) {
        $toMail = $account->getMailByName($wereHouse);
        $sendMail = new SendMail();
        $mailDone = $sendMail->sendMail($toMail, "New notification from $adminName");
        header("location: notification.php");
    }
}

if (isset($_POST["resendToInspector"])) {
    $resend_note = @$_POST['resendNote'];

    if ($resend_note) {
        $success = $request->resendToInspector($workOrderNo, $resend_note, $request->getRequestDetails($workOrderNo)["inspector"], "Return Inspector");
    } else {
        $success = $request->resendToInspector($workOrderNo, $resend_note, $request->getRequestDetails($workOrderNo)["inspector"], "Accept Inspector");
    }


    if ($success) {
        $toMail = $account->getMailByName($inspector);
        $sendMail = new SendMail();
        $mailDone = $sendMail->sendMail($toMail, "New notification from $adminName");
        header("location: notification.php");
    }
}

if (isset($_POST["dismantling"])) {
    $success = $request->dismantling('wereHouse&requester', $workOrderNo, $request->getRequestDetails($workOrderNo)["wereHouse"], "Recivied");

    if ($success) {
        $toMail = $account->getMailByName($requester);
        $sendMail = new SendMail();
        $mailDone = $sendMail->sendMail($toMail, "New notification from $adminName");
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
                               
                                <th><p class=""> Qty &nbsp; &nbsp;</p></th>
                                <th><p class=""> Delet</p></th>
                               
                            </thead>
                            <tbody id="ItemDescriptionBody">
' . $err . '
                            </tbody>
                        </table>
                        <br>
                      
                    ';
                if ($reject == 'yes') {
                    echo '
                            <button class="submitDonereg" name="resendToWereHouse">Done</button>
                            <br>
                            <button class="submitDonereg" id="resendToInspector" name="resendToInspector">Resend to inspector</button>
                            <textarea id="resendNote" name="resendNote"></textarea>
                        ';
                }
                ?>
                <br>
                <?php if ($new) {
                    echo '
                    <button class="submitQTY" name="submit" id="executerDone">Done</button>
                    <br>
                    <br>
                                     
                    <button class="submitQTYreject" onclick="removeRequiredAttribute()" name="reject" id="reject" onclick="addRequiredAttribute()">Reject</button>
                    <br>
                    ' . $errRejectReason . '
                    <br>
                    <textarea class="rejectqty" type="text" name="rejectReason" id="rejectReason" placeholder = "Reject reason"></textarea>
                    <br>
                    ';
                } ?>
            </form>

            <script>
                $(document).ready(function () {
                    $.get(
                        "ajax/GetRequests.php",
                        { isNotification: null, executer: '<?php echo $adminName; ?>', workOrderNo: '<?php echo $workOrderNo; ?>', errDate: '<?php echo $errDate; ?>' },
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