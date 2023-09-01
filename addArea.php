<?php
include_once('includes/classes/Area.php');
include_once('includes/classes/FormSanitizer.php');

$area = new Area($con);
$getAreaId = $area->getIdNum();
$allAreas = $area->getArea();

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
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
  <title>Add Area </title>
</head>

<body>
<div>
        <a class="Back" href="ownerPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
<div class="wrappereq">

  <div class="login-container" id="login">
<div class="top">

          <header class="nameowner">Add Area...</header>
        </div>
        <div class="input-box">
  <form method="POST">
    <input type="text"  class="inputfieldarea" name="areaId" value="<?php echo $getAreaId; ?>" placeholder="id" readonly required>
</div>
<br>
<div class="input-box">
    <input type="text" class="inputfieldarea"  name="areaName" placeholder="Add Area" required>
</div>
<br>
<div class="input-box">
        <button type="submit" name="submit"  class="submitarea" >Add</button>
        </div>
   
   
  </form>
<?php
echo $allAreas
?>
</body>

</html>