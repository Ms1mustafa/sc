<?php
ob_start();

date_default_timezone_set('Asia/Baghdad');
$currentDateTime = date("Y-m-d H:i:s");

try {
    $con = new PDO("mysql:dbname=sca;host:localhost", "root", "123456789");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>