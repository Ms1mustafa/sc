<?php
require_once("../includes/config.php");
require_once("ItemDes.php");

$users = ItemDes::ItemDes($con);

echo $users;

?>