<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');

$userEmail = @$_COOKIE["email"];
$account = new Account($con);
$isAcc = @$account->getAccountDetails($userEmail, true);

if (!$userEmail) {
    header("location: login.php");
}
if (!$isAcc) {
    echo '<h1>You dont have permissions to this site!</h1>';
} else
    Powers::goTo($account, @$userEmail);
?>