<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');


$userEmail = $_COOKIE["email"];

$account = new Account($con);
Powers::owner($account, $userEmail);

$req = new Request($con);
$requests = $req->getRequestDetails();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css.css?1999">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>All users </title>
</head>


<body>
    <form method="POST" action=""> <!-- Assuming "deleteUser.php" is the action URL -->
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>requester</td>
                    <td>work order No</td>
                    <td>request added date</td>
                    <td>request status</td>
                    <td>request finish date</td>
                </tr>
            </thead>
    
            <tbody>
                <?php
                $id = 1;
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

                    if($executerNew == 'yes'){
                        $reqStatus = $executer;
                        $finishDate = $reqDate;
                        if($wereHouseDate){
                            $finishDate = $wereHouseDate;
                        }
                    }
                    if(($executerNew != 'yes' && $issued != 'yes' && $status == 'pending') || $status == 'resent'){
                        $reqStatus = $wereHouse;
                        $finishDate = $executerDate;
                    }
                    if(($issued == 'yes' && $status == 'pending') || $status == 'resentInspector'){
                        $reqStatus = $inspector;
                        $finishDate = $executerDate;
                    }
                    if($status == 'rejected'){
                        $reqStatus = 'rejected';
                        $finishDate = $inspectorDate;
                    }elseif($status == 'accepted'){
                        $reqStatus = 'accepted';
                        $finishDate = $inspectorDate;
                    }
                    if($qtyBackStatus != 'no'){
                        $reqStatus = 'dismantling';
                    }

                    echo '
                    <tr>
                        <td>'. $id .'</td>
                        <td>' . $request["adminAddedName"] . '</td>
                        <td>' . $request["workOrderNo"] . '</td>
                        <td>' . $reqDate . '</td>
                        <td>' . $reqStatus . '</td>
                        <td>' . $finishDate . '</td>
                        </tr>
                    ';
                    $id ++;
                }
                ?>
            </tbody>
        </table>
    </form>
</body>

</html>