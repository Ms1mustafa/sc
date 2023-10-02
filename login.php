<?php

include_once('includes/classes/Account.php');
include_once('includes/classes/Encryption.php');

$userEmail = @$_COOKIE["email"];
if (@$userEmail) {
    header("location: index.php");
}

$account = new Account($con);



if (isset($_POST["submit"])) {
    $username = FormSanitizer::sanitizeFormString($_POST["username"]);
    $password = FormSanitizer::sanitizeFormString($_POST["password"]);
    // $email = $account->getAccountEmail($username);

    $success = $account->login($username, $password);

    if ($success) {
        $token = $account->getAccountToken($username);
        $hashedToken = Encryption::encryptToken($token, 'msSCAra');
        setcookie('token', $hashedToken, time() + (86400 * 365), "/");
        header("location: index.php");
        // $salt = "msSCAra";
        // $iterations = 10000;
        // $token = $account->getAccountToken($username);
        // $dataToHash = $salt . $token;
        // $hashedToken = hash_pbkdf2("sha512", $dataToHash, $salt, $iterations, 64);
        // echo $hashedToken;
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
    <link rel="stylesheet" href="css.css?1999">

    <title>Login</title>
</head>

<body>
    <div class="wrapp">
        <!------------------- login form -------------------------->
        <div class="login-container" id="login">
            <div class="">
                <h1 class="welcomlogin"><span class="colorScaffolding">W</span>elcome <span
                        class="colorScaffolding">T</span>o The <span class="colorScaffolding">S</span>caffolding <span
                        class="colorScaffolding">A</span>pplication </h1>
                <br>
                <br>
                <header><span class="colorScaffolding">L</span>ogin </header>
            </div>
            <div class="input-box1">

                <form method="POST">
                    <p class="error">
                        <?php echo $account->getError(constants::$loginFailed); ?>
                    </p>
                    <input type="text" name="username" class="inputfieldlogin" placeholder=" Username ..."
                        value="<?php getInputValue("username"); ?>" required>
            </div>
            <br>
            <div class="input-box1">

                <input type="password" name="password" class="inputfieldlogin" placeholder="Password"
                    value="<?php getInputValue("password"); ?>" required>

            </div>
            <br>
            <div class="input-box1">
                <input type="submit" name="submit" class="submitlogin" value="Sing in">
            </div>

            </form>

</body>

</html>