<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');

$userEmail = @$_COOKIE["email"];
if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
Powers::goTo($account, @$userEmail);
?>