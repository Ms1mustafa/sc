<?php
include_once('includes/classes/Area.php');
include_once('includes/classes/FormSanitizer.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
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
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
  <title>Add location </title>
</head>

<body>
<div>
        <a class="Back" href="ownerPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
  <div class="wrappereq">
        <div class="login-container" id="login">
      <div class="top">

        <header class="nameowner">Add Location...</header>
      </div>
      <div class="input-box">

        <form method="POST">
          <input type="text" class="inputfieldarea" name="id" value="<?php echo $getItemId; ?>" placeholder="id"
            readonly required>
      </div>
      <br>

      <select class="inputfieldarea2" name="areaId">
        <?php echo $getArea; ?>
      </select>
      <br>
      <br>
      <br>
      <div >

  
        <input type="text" class="inputfieldarea3" name="itemName" placeholder="Add Item" required>
      </div>
      <br>
      <br>
      <div >
        <button type="submit" name="submit" class="submitlocation">Add</button>
      </div>

      </form>
</body>

</html>