<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Encryption.php');


$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false);
$type = @$_GET["type"];
$reqNo = @$_GET["reqNo"];

$req = new Request($con);

if ($type === "requester") {
    Powers::admin($account, $userToken);
    $request = $req->getRequestDetails($reqNo, $adminName);
} else {
    Powers::Safety($account, $userToken);
    $request = $req->getRequestDetails($reqNo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>All users </title>
</head>

<body>
    <div>
        <a class="Back" href="home.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="wrappereq">

        <div class="login-container" id="login">
            <div class="top">
                <div style="overflow-x:auto;">
                    <form method="POST" action=""> <!-- Assuming "deleteUser.php" is the action URL -->
                        <?php
                        $status = $request["status"];
                        $qtyBackStatus = $request["qtyBackStatus"];
                        $executerAccept = $request["executerAccept"];
                        $executerNew = $request["executerNew"];
                        $issued = $request["issued"];
                        $executer = $request["executer"];
                        $wereHouse = $request["wereHouse"];
                        $inspector = $request["inspector"];
                        $reqDate = FormSanitizer::formatDate($request["reqDate"]);
                        $executerDate = FormSanitizer::formatDate($request["executerDate"]);
                        $wereHouseDate = FormSanitizer::formatDate($request["wereHouseDate"]);
                        $inspectorDate = FormSanitizer::formatDate($request["inspectorDate"]);

                        $reqStatus = "";

                        $reqStatus = '';
                        $finishDate = '';
                        echo "
                        <div id='reqInf'>
                        <label  class='Getrquest'>ReqNo : </label>
                        <label class='Getrquest'>" . $request["reqNo"] . "</label>
                        <br>
                        <label class='Getrquest'>Requester :</label>
                        <label class='Getrquest'>" . $request["adminAddedName"] . "</label>
                        <br>
                        <label class='Getrquest'>Inspector :</label>
                        <label class='Getrquest'>" . $request["inspector"] . "</label>
                        <br>
                        <label  class='Getrquest'>Area :</label>
                        <label class='Getrquest'>" . $request["area"] . "</label>
                        <br>
                        <label class='Getrquest'>Location :</label>
                        <label class='Getrquest'>" . $request["item"] . "</label>
                        <br>
                        <label class='Getrquest'>Length :</label>
                        <label class='Getrquest'>" . $request["length"] . "</label>
                        <br>
                        <label class='Getrquest'>Width :</label>
                        <label class='Getrquest'>" . $request["width"] . "</label>
                        <br>
                        <label class='Getrquest'>Height :</label>
                        <label class='Getrquest'>" . $request["height"] . "</label>
                        <br>
                        </div>
                    ";

                        ?>
                        </tbody>
                        </table>
                    </form>
</body>

</html>