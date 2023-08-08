<?php
require_once("../includes/config.php");
require_once("Items.php");

$areaId = $_GET['areaId'];
$users = Items::items($con, $areaId);

echo $users;

?>