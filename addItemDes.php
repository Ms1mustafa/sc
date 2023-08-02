<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/ItemDes.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];
$account = new Account($con);

Powers::owner($account, $userEmail);

$area = new ItemDes($con);
$getAreaId = $area->getIdNum();


if (isset($_POST["submit"])) {
  $itemdesId = $_POST["itemdesId"];
  $itemdesName = FormSanitizer::sanitizeFormString($_POST["itemdesName"]);

  $success = $area->addWT($itemdesId, $itemdesName);

  if ($success) {
    header("location: addItemDes.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner </title>
</head>

<body>
  <form method="POST">
    <label>Item Description id</label>
    <input type="text" name="itemdesId" value="<?php echo $getAreaId; ?>" placeholder="id" readonly required>
    <br>
    <label for="itemdesName">Item Description id</label>
    <input type="text" name="itemdesName" id="itemdesName" placeholder="Item Description name" required>
    <br>
    <button name="submit">Add</button>
    <br>
  </form>
</body>

</html>