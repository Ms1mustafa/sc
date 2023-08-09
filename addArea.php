<?php
include_once('includes/classes/Area.php');
include_once('includes/classes/FormSanitizer.php');

$area = new Area($con);
$getAreaId = $area->getIdNum();

if (isset($_POST["submit"])) {
  $areaId = $_POST["areaId"];
  $areaName = FormSanitizer::sanitizeFormString($_POST["areaName"]);

  $success = $area->addArea($areaId, $areaName);

  if ($success) {
    header("location: ownerPage.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css.css?1999">
  <title>Add Area </title>
</head>

<body>
<div class="wrappe">
<nav class="nav">
        <div class="nav-logo">
            <p>LOGO .</p>
</div>
          
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="ownerPage.php" class="link active">Home</a></li>
                <li><a href="#" class="link">Blog</a></li>
                <li><a href="#" class="link">Services</a></li>
                <li><a href="#" class="link">About</a></li>
            </ul>
            
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
  <div class="login-container" id="login">
<div class="top">

          <header>Add Area...</header>
        </div>
        <div class="input-box">
  <form method="POST">
    <input type="text"  class="inputfieldlogin" name="areaId" value="<?php echo $getAreaId; ?>" placeholder="id" readonly required>
</div>
<br>
<div class="input-box">
    <input type="text" class="inputfieldlogin"  name="areaName" placeholder="Add Area" required>
</div>
<br>
<div class="input-box">
        <button type="submit" name="submit"  class="submitlogin" >Add</button>
        </div>
   
   
  </form>
</body>

</html>