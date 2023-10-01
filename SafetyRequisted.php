<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Request.php');

$userEmail = $_COOKIE["email"];
$account = new Account($con);
$isAcc = $account->getAccountDetails($userEmail, true);

if (!$userEmail || !$isAcc) {
  header("location: login.php");
}

Powers::Safety($account, $userEmail);

$request = new Request($con);
$requests = $request->getAllRequests();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">


  <link rel="stylesheet" href="css.css?1999">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>

  <title>Safety Req </title>
</head>

<body>
  <div>
    <a class="Back" href="Safety.php">
      <i class="fa-solid fa-arrow-left"></i> Back</a>
  </div>
  <div class="wrappereq">


    <div class="login-container" id="login">

      <div class="input-box">
        <section>

          <table class="alluser">
            <tr>
              <th>Request NO</th>
              <th>Request Name</th>
              <th>Area</th>
              <th>Location</th>
            </tr>
            <?php
            foreach ($requests as $req) {
              echo '
                  <tr>
                    <td>' . $req["reqNo"] . '</td>
                    <td>' . $req["adminAddedName"] . '</td>
                    <td>' . $req["area"] . '</td>
                    <td>' . $req["item"] . '</td>
                  <tr>
                ';
            }
            ?>
          </table>
        </section>
      </div>
    </div>
  </div>
</body>

</html>