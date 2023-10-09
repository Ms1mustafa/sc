<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Encryption.php');


$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::Safety($account, $userToken);

$req = new Request($con);
$requests = $req->getRequestDetails();
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
        <a class="Back" href="ownerPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="wrappereq">

        <div class="login-container" id="login">
            <div class="top">
                <div style="overflow-x:auto;">
                    <form method="POST" action=""> <!-- Assuming "deleteUser.php" is the action URL -->
                        <table class="alluser">
                            <thead>
                                <tr>
                                    <th>Req No</th>
                                    <th>Requester</th>
                                    <th>Start date</th>
                                    <th>Work order No</td>
                                    <th>Area</th>
                                    <th>Location</th>
                                    <th>Pending In</th>
                                    <th>Pending Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($requests as $request) {
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

                                    if ($executerNew == 'yes') {
                                        $reqStatus = $executer;
                                        $finishDate = $reqDate;
                                        if ($wereHouseDate) {
                                            $finishDate = $wereHouseDate;
                                        }
                                    } elseif (($executerNew != 'yes' && $issued != 'yes' && $status == 'pending') || $status == 'resent') {
                                        $reqStatus = $wereHouse;
                                        $finishDate = $executerDate;
                                    } elseif (($issued == 'yes' && $status == 'pending') || $status == 'resentInspector') {
                                        $reqStatus = $inspector;
                                        $finishDate = $executerDate;
                                    } elseif ($status == 'rejected') {
                                        $reqStatus = 'rejected';
                                        $finishDate = $inspectorDate;
                                    } elseif ($status == 'accepted') {
                                        $reqStatus = 'accepted';
                                        $finishDate = $inspectorDate;
                                    }

                                    if ($qtyBackStatus != 'no') {
                                        $reqStatus = 'dismantling';
                                    }


                                    echo '
                    <tr>
                        <td>' . $request["reqNo"] . '</td>
                        <td>' . $request["adminAddedName"] . '</td>
                        <td>' . $reqDate . '</td>
                        <td>' . $request["workOrderNo"] . '</td>
                        <td>' . $request["area"] . '</td>
                        <td>' . $request["item"] . '</td>
                        <td>' . $reqStatus . '</td>
                        <td>' . $finishDate . '</td>
                        </tr>
                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
</body>

</html>