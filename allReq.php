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

$req = new Request($con);

$filter = @$_POST["filter"] ?? "all";

if ($type === "requester") {
    Powers::admin($account, $userToken);
    $requests = $req->getRequestDetails($filter, null, $adminName);
} else {
    Powers::Safety($account, $userToken);
    $requests = $req->getRequestDetails($filter);
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
    <br>
   
        <form action="" method="POST">
        
            <select class="filter"name="filter">
                <option class="filter" value="all" <?php $filter == "all" ? "selected" : ""; ?>>All</option>
                <option class="filter" value="pending" <?php echo $filter === "pending" ? "selected" : ""; ?>>Pending</option>
                <option class="filter" value="accepted" <?php echo $filter === "accepted" ? "selected" : ""; ?>>Accepted</option>
                <option  class="filter" value="rejected" <?php echo $filter === "rejected" ? "selected" : ""; ?>>Rejected</option>
            </select>
            <input class=" inputfilter" type="submit" value="filter">
        </form>

        <div class="wrappereq">
        <div class="login-container" id="login">
            <div class="top">
                <div style="overflow-x:auto;">
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
                                <th>Type pending</th>
                                <th>Type Req</th>
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
                                echo '
                    <tr>
                        <td><a href="showReq.php?reqNo=' . $request["workOrderNo"] . '">' . $request["reqNo"] . '</a></td>
                        <td>' . $request["adminAddedName"] . '</td>
                        <td>' . $reqDate . '</td>
                        <td>' . $request["workOrderNo"] . '</td>
                        <td>' . $request["area"] . '</td>
                        <td>' . $request["item"] . '</td>
                        <td>' . $request["pending_in"] . '</td>
                        <td>' . ucfirst($account->getTypeByName($request["pending_in"])) . '</td>
                        <td>' . $request["type_req"] . '</td>
                        <td>' . FormSanitizer::formatDate($request["pending_date"]) . '</td>
                        </tr>
                    ';
                            }
                            ?>
                        </tbody>
                    </table>
</body>

</html>