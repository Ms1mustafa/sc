<?php
require_once("../includes/config.php");
require_once("Inspectors.php");

$areaId = $_GET['areaId'];
$inspectors = Inspectors::Inspectors($con, $areaId);

echo $inspectors;

?>