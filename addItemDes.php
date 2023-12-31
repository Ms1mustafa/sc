<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/ItemDes.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::owner($account, $userToken);

$area = new ItemDes($con);
$getAreaId = $area->getIdNum();

$err = 'Item Description';

if (isset($_POST["submit"])) {
  $itemdesId = $getAreaId;
  $itemdesName = FormSanitizer::sanitizeFormString($_POST["itemdesName"]);

  if (!$itemdesName) {
    $err = 'Item description is required';
  }
  ;
  if ($itemdesId && $itemdesName)
    $success = $area->addWT($itemdesId, $itemdesName);

  if (@$success) {
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
  <link rel="stylesheet" href="css.css?1999">
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
  <title>Owner </title>
</head>

<body>
  <div>
    <a class="Back" href="ownerPage.php">
      <i class="fa-solid fa-arrow-left"></i> Back</a>
  </div>
  <div class="wrappereq">
    <div class="login-container" id="login">
      <div class="top">

        <header class="nameowner">Add Item...</header>
      </div>
      <div class="input-item">

        <form method="POST">
          <label class="Itemlabel">Item Description id</label>
          <br>
          <br>
          <input class="iteminput" type="text" name="itemdesId" value="<?php echo $getAreaId; ?>" placeholder="id"
            readonly required>
          <br>
          <br>
          <label class="Itemlabel" sfor="itemdesName">
            <?php echo $err; ?>
          </label>
          <br>
          <br>
          <input class="iteminput" type="text" name="itemdesName" id="itemdesName" placeholder="Item Description name"
            required>
          <br>
          <br>
          <button class="Additem" name="submit">Add</button>
          <br>
        </form>
</body>

</html>