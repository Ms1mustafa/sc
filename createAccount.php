<?php

include_once('includes/classes/Account.php');

$account = new Account($con);
$requestNum = $account->getAccountNum($admin = true);

$numberOfElements = $requestNum;

$i = 1;
$requestNum = "";
$currentYear = date("Y");
while ($i <= $numberOfElements) {
  $requestNum = str_pad($i, 5, '0', STR_PAD_LEFT);
  $requestNum = $currentYear . $requestNum;
  $i++;
}


$Token = @date("ymdhis");
$RandomNumber = rand(100, 200);
$NewToken = $Token . $RandomNumber;

if (isset($_POST["submit"])) {
  $username = FormSanitizer::sanitizeFormString($_POST["username"]);
  $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
  $password = FormSanitizer::sanitizeFormString($_POST["password"]);
  $type = FormSanitizer::sanitizeFormString($_POST["type"]);

  if ($_POST["type"] == "admin") {
    $success = $account->register($NewToken, $username, $email, $password, $type, $requestNum);
  } else {
    $success = $account->register($NewToken, $username, $email, $password, $type, "");
  }

  if ($success) {
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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css.css">
  <title>SignUp</title>
</head>

<body>
  <!------------------- CreateAccount ------------------------->

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

          <header>CreateAccount...</header>
        </div>
        <div class="input-box">
        <p class="adminName"> <?php echo $requestNum;?></p>

  <form method="POST">
    <?php echo $account->getError(constants::$usernameTaken); ?>

    <label for="name">Name</label>
    <input type="text" name="username" id="name"class="input-field" placeholder="Name" value="<?php getInputValue("username"); ?>" required />
</div>

    <?php echo $account->getError(constants::$emailInvalid); ?>
    <?php echo $account->getError(constants::$emailTaken); ?>
    <div class="input-box">
    <label for="email">Email</label>
    <input type="Email" id="email" name="email"class="input-field" placeholder="Email" value="<?php getInputValue("email"); ?>" required />
</div>
<div class="input-box">
    <?php echo $account->getError(constants::$passwordLength); ?>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="input-field" placeholder="Password" value="<?php getInputValue("password"); ?>"
      required />
</div>
<br>

    <select class="input-field" name="type" >
    <option value="Select Aperson" >Select Aperson</option>
      <option value="owner" >owner</option>
      <option value="admin" >admin</option>
      <option value="inspector" >inspector</option>
      <option value="Execution" >Execution</option>
      <option value="WereHouse" >WereHouse</option>
    </select>
    <br>
<br>
       <div class="input-box">
    <input type="submit"name="submit" class="submit" >
</div>
  </form>
  
</body>

</html>