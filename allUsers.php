<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::owner($account, $userToken);

$users = $account->getAllAccounts();

if (isset($_POST["submit"])) {

    // Check if "delete" checkboxes are selected
    if (isset($_POST["delete"]) && is_array($_POST["delete"])) {
        $usernames = $_POST["delete"];

        $deletedSuccessfully = $account->deleteUser($usernames);

        if ($deletedSuccessfully) {
            header("Refresh: 0");
        } else {
            echo "Failed to delete users.";
        }
    } else {
        echo "No users selected for deletion.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>All users </title>
</head>


<body>
    <div>
        <a class="Back" href="ownerPage.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="wrappereq">

        <div class="login-container" id="login">
            <div class="top">
                <div style="overflow-x:auto;">
                    <form method="POST" action="">
                        <!-- Assuming "deleteUser.php" is the action URL -->
                        <table class="alluser">

                            <tr>
                                <th>username</th>
                                <th>email</th>
                                <th>password</th>
                                <th>area</th>
                                <th>type</th>
                                <th>delete</th>
                            </tr>



                            <?php
                            foreach ($users as $user) {
                                $area = new Area($con);
                                $areaName = $area->getAreaName($user["area"]);
                                echo '
                    <tr>
                        <td>' . $user["username"] . '</td>
                        <td>' . $user["email"] . '</td>
                        <td>' . $user["password"] . '</td>
                        <td>' . $areaName . '</td>
                        <td>' . $user["type"] . '</td>
                        <td><input type="checkbox" name="delete[]" value="' . $user["username"] . '"> Delete</td>
                        </tr>
                    ';
                            }
                            ?>

                        </table>
                        <input class="submitDelet" type="submit" style="display: none;" name="submit"
                            class="submitalluser" value="Submit">
                    </form>
                </div>
                <script>
                    // Function to check if at least one checkbox is checked
                    function atLeastOneCheckboxChecked() {
                        var checkboxes = document.querySelectorAll('input[type="checkbox"][name="delete[]"]');
                        for (var i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i].checked) {
                                return true; // At least one checkbox is checked
                            }
                        }
                        return false; // No checkboxes are checked
                    }

                    // Function to toggle the display of the submit button
                    function toggleSubmitButton() {
                        var submitRow = document.getElementById("submit-row");
                        var submitButton = document.querySelector('input[type="submit"][name="submit"]');

                        if (atLeastOneCheckboxChecked()) {
                            submitButton.style.display = "block"; // Show the button
                        } else {
                            submitButton.style.display = "none"; // Hide the button
                        }
                    }

                    // Add event listeners to checkboxes to toggle the submit button
                    var checkboxes = document.querySelectorAll('input[type="checkbox"][name="delete[]"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].addEventListener("change", toggleSubmitButton);
                    }
                </script>
</body>

</html>