<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], 'msSCAra');
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
$isAcc = @$account->getAccountEmail($userToken);

if (!$userToken) {
    header("location: login.php");
}
if (!$isAcc) {
    echo '<h1>You dont have permissions to this site!</h1>';
} else
    Powers::goTo($account, @$userToken);
?>