<?php
include_once('includes/classes/Area.php');
include_once('includes/classes/FormSanitizer.php');

$userEmail = $_COOKIE["email"];

if(!$userEmail){
    header("location: login.php");
}

$area = new Area($con);
$getItemId = $area->getItemIdNum();
$getArea = $area->getArea();

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $areaId = $_POST["areaId"];
    $itemName = FormSanitizer::sanitizeFormString($_POST["itemName"]);
  
    $success = $area->addItem($id, $areaId, $itemName);
  
    if ($success) {
      header("location: addItem.php");
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
    <title>Add location </title>
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

          <header>Add Location...</header>
        </div>
        <div class="input-box">

    <form method="POST">
        <input type="text" class="inputfieldlogin" name="id" value="<?php echo $getItemId; ?>" placeholder="id" readonly required>
</div>
        <br>

        <select class="inputfieldlogin" name="areaId">
            <?php echo $getArea; ?>
        </select>
        <br>
        <br>
        <div class="input-box">

        <input type="text"class="inputfieldlogin"  name="itemName" placeholder="Add Item" required>
</div>
     <br>  
<div class="input-box">
        <button type="submit" name="submit"  class="submitlogin" >Add</button>
        </div>
        
    </form>
</body>

</html>