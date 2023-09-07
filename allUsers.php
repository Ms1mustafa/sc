<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

$account = new Account($con);
Powers::owner($account, $userEmail);

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
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css.css?1999">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>All users </title>
</head>


<body>
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <td>username</td>
                    <td>email</td>
                    <td>password</td>
                    <td>area</td>
                    <td>type</td>
                    <td>request number</td>
                    <td>delete</td>
                </tr>
            </thead>
    
            <tbody>
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
                        <td>' . $user["requestNum"] . '</td>
                        <td><input type="checkbox" name="delete[]" value="' . $user["username"] . '"> Delete</td>
                        </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
        <input type="submit" id="deleteBtn" style="display: none;" name="submit" value="delete">
    </form>
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
        var submitButton = document.getElementById('deleteBtn');
        
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