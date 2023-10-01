<?php
include_once('includes/classes/WorkType.php');
include_once('includes/classes/FormSanitizer.php');

$area = new workType($con);
$getAreaId = $area->getIdNum();

if (isset($_POST["submit"])) {
  $wtId = $_POST["wtId"];
  $wtName = FormSanitizer::sanitizeFormString($_POST["wtName"]);

  $success = $area->addWT($wtId, $wtName);

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
  <link rel="stylesheet" href="css.css">
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
  <title>Add Worke </title>
</head>

<body>
<div>
        <a class="Back" href="ownerPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
<div class="wrappereq">

  <div class="login-container" id="login">
<div class="top">

          <header class="nameowner">Add Worke...</header>
        </div>
        <div class="input-box">
  <form method="POST">
    
    <input type="text"class="inputfieldarea" name="wtId" value="<?php echo $getAreaId; ?>" placeholder="id" readonly required>
</div>
    <br>
    <div class="input-box">
    <form method="POST">
    
    <input type="text"  class="inputfieldarea" name="wtName" id="wtName" placeholder="Work type name" required>
</div>
    <br>
    <div class="input-box">
        <button type="submit" name="submit"  class="submitarea" >Add</button>
        </div>
    
  </form>
</body>

</html>