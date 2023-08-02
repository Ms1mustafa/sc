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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Notification</title>
</head>

<body>
    <form method="POST">
        <?php echo $adminName; ?>
        <br>
        <p>QTY</p>
        <div id="reqInf"></div>
        <?php if ($new)
            echo '
                <table>
                <thead>
                    <th>
                        <select id="ItemDescription">
                            <option disabled selected>Item description</option>
                            <option value="Pipe 6M">Pipe 6M</option>
                            <option value="Clamp movable">Clamp movable</option>
                            <option value="Wood 4m">Wood 4m</option>
                        </select>
                    </th>
                    <th>Qty</th>
                </thead>
                <tbody id="ItemDescriptionBody">

                </tbody>
            </table>
            ';
        ?>
        <?php if ($new) {
            echo '<button name="submit">submit</button>';
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