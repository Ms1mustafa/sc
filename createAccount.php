<?php

include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::owner($account, $userToken);

$area = new Area($con);
$getArea = $area->getArea();

$Token = @date("ymdhis");
$RandomNumber = rand(100, 200);
$NewToken = $Token . $RandomNumber;
$hashedToken = Encryption::encryptToken($NewToken, constants::$tokenEncKey);

$err = '';

if (isset($_POST["submit"])) {
  $username = FormSanitizer::sanitizeFormString($_POST["username"]);
  $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
  $password = FormSanitizer::sanitizeFormString($_POST["password"]);
  $type = FormSanitizer::sanitizeFormString(@$_POST["type"]);
  $areaName = FormSanitizer::sanitizeFormString($_POST["areaName"]);

  if ($username && $email && $password && $type && @$areaName) {
    if ($_POST["type"] == "inspector") {
      $success = $account->register($NewToken, $username, $email, $password, $type, $areaName);
    } else {
      $success = $account->register($NewToken, $username, $email, $password, $type);
    }
  } else {
    $err = 'All fields are required';
  }


  if (@$success) {
    header("location: index.php");
  }
}

function getInputValue($name)
{
  if (isset($_POST[$name]))
    echo $_POST[$name];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
  <script src="script.js" defer></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css.css?1999">
  <title>SignUp</title>
</head>

<body>
  <!------------------- CreateAccount ------------------------->
  <div>
    <a class="Back" href="ownerPage.php">
      <i class="fa-solid fa-arrow-left"></i> Back</a>
  </div>

  <div class="pageoner">

    <div class="login-container" id="login">
      <div class="top">

        <header class="nameowner">CreateAccount</header>
      </div>
      <br>
      <?php echo $err; ?>
      <br>
      <br>
      <div class="input-box">
        <form method="POST">
          <?php echo $account->getError(constants::$usernameTaken); ?>


          <input type="text" name="username" id="name" class="inputfieldarea" placeholder="Name"
            value="<?php getInputValue("username"); ?>" required />
      </div>
      <br>
      <?php echo $account->getError(constants::$emailInvalid); ?>
      <?php echo $account->getError(constants::$emailTaken); ?>
      <div class="input-box">

        <input type="Email" id="email" name="email" class="inputfieldarea" placeholder="Email"
          value="<?php getInputValue("email"); ?>" required />
      </div>
      <br>
      <div class="input-box">
        <?php echo $account->getError(constants::$passwordLength); ?>

        <input type="password" name="password" id="password" class="inputfieldarea" placeholder="Password"
          value="<?php getInputValue("password"); ?>" required />
      </div>
      <br>

      <select class="inputfieldownerselect-areatAccount" id="userType" name="type" required>
        <option value="" disabled selected>Select Aperson</option>
        <option value="owner">owner</option>
        <option value="requester">requester</option>
        <option value="inspector">inspector</option>
        <option value="execution">Execution</option>
        <option value="wereHouse">WereHouse</option>
        <option value="supervisor">Supervisor</option>
        <option value="safety">Safety</option>
      </select>
      <br>
      <br>
      <select class="inputfieldownerselect-areatAccount" name="areaName" id="areas" style="display: none;">
        <?php echo $getArea; ?>
      </select>
      <br>
      <div class="input-box">
        <input type="submit" name="submit" class="submitarea">
      </div>
      </form>

      <script>
        const userType = document.getElementById("userType");
        const areas = document.getElementById("areas");

        userType?.addEventListener('change', () => {
          if (userType.value == 'inspector') {
            areas.style.display = 'block';
          } else {
            areas.style.display = 'none';
          }
        })
      </script>

</body>

</html>