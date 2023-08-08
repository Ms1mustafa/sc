<?php
ob_start();

date_default_timezone_set('Asia/Baghdad');
$currentDateTime = date("Y-m-d H:i:s");

try{
    $con = new PDO("mysql:dbname=sc;host:localhost", "root", "1234512345");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    exit("Connection failed: " . $e->getMessage());
}
?>