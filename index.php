<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
$isAcc = @$account->getAccountEmail($userToken);

if (!$userToken) {
    header("location: login.php");
}
if (!$isAcc) {
    header("location: logout.php");
} else
    Powers::goTo($account, @$userToken);
?>