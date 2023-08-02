<?php
include_once('includes/classes/workType.php');
include_once('includes/classes/FormSanitizer.php');

$area = new workType($con);
$getAreaId = $area->getIdNum();

if (isset($_POST["submit"])) {
  $wtId = $_POST["wtId"];
  $wtName = FormSanitizer::sanitizeFormString($_POST["wtName"]);

  $success = $area->addWT($wtId, $wtName);

  if ($success) {
    header("location: addWorkType.php");
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
  <link rel="stylesheet" href="css.css">
  <title>Add Worke </title>
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
            <div class="nav-button">
            <button class="btn white-btn" >Log out</button>
            
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
  <div class="login-container" id="login">
<div class="top">

          <header>Add Worke...</header>
        </div>
        <div class="input-box">
  <form method="POST">
    <label>Work type id</label>
   
    <input type="text"class="input-field" name="wtId" value="<?php echo $getAreaId; ?>" placeholder="id" readonly required>
</div>
    <br>
    <div class="input-box">
    <form method="POST">
    <label for="wtName">Work type Name</label>
    <input type="text"  class="input-field" name="wtName" id="wtName" placeholder="Work type name" required>
</div>
    <br>
    <div class="input-box">
        <button type="submit" name="submit"  class="submit" >Add</button>
        </div>
    
  </form>
</body>

</html>