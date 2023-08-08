<?php

include_once('includes/classes/Account.php');

$userEmail = @$_COOKIE["email"];
if(@$userEmail){
    header("location: index.php");
}

$account = new Account($con);



if (isset($_POST["submit"])) {
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $password = FormSanitizer::sanitizeFormString($_POST["password"]);

    $success = $account->login($email, $password);

    if ($success) {
        setcookie('email', $email, time() + (86400 * 365), "/");
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
  <link rel="stylesheet" href="css.css?1222">
 
    <title>Login</title>
</head>

<body>
<div class="wrapp">
     <!------------------- login form -------------------------->
<div class="login-container" id="login">
<div class="top">

          <header>Sing up Now..!</header>
        </div>
        <div class="input-box">

    <form method="POST">
        <?php echo $account->getError(constants::$loginFailed); ?>
        <input type="Email" name="email"class="inputfieldlogin" placeholder="Username or Email"value="<?php getInputValue("email"); ?>" required>
        <i class="bx bx-user"></i>
        </div>
        <div class="input-box">

        <input type="password" name="password"class="inputfieldlogin" placeholder="Password" value="<?php getInputValue("password"); ?>" required>
        <i class="bx bx-lock-alt"></i>
        </div>
        <div class="input-box">
        <input type="submit" name="submit" class="submitlogin" value="Sign In">
        </div>
        
    </form>

</body>

</html>
