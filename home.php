<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/request.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, false);
$adminReqNo = $account->getAccountDetails($userEmail, false, false, false, false, true);

Powers::admin($account, $userEmail);

$request = new Request($con);
$requests = $request->getRequestNumber($adminName);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css">
    <title>Request </title>
</head>

<body>
    <div class="wrappe">
        <?php include_once('includes/navbar.php') ?>

        <div class="login-container" id="login">

            <div class="input-box">
                <p class="Name">
                    <?php echo $adminName; ?>
                </p>
                <br>

                <p class="Notifications">Notifications</p>

                <table>
                    <tbody>
                        <?php
                        // for ($i = 0; $i < $requests; $i++) {
                        //     echo '
                        //         <tr>
                        //             <td>' . $adminReqNo . '</td>
                        //             <td>Request</td>
                        //         </tr>
                        //     ';
                        // }
                        // ?>
                    </tbody>
                </table>
                <a class="addRequest" href="addRequest.php">New Request</a>
                <br>
                <br>
                <a class="addRequest" href="adminRequests.php">Modify Request</a>
                <br>
                <br>
                <a class="addRequest" href="">Dismantle Request</a>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>

</body>

</html>