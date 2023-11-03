<?php
ob_start();
// session_start();

date_default_timezone_set('Asia/Baghdad');

try {
    $con = new PDO("mysql:dbname=sca;host:localhost", "root", "123456789");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>