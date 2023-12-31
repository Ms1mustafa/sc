<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);
Powers::owner($account, $userToken);

$inspectors = $account->getAccountByType('inspector');

$area = new Area($con);
$areas = $area->getArea(true);
$locations = $area->getLocation();

if (isset($_POST["areaDeleteBtn"])) {

    // Check if "delete" checkboxes are selected
    if (isset($_POST["deleteArea"]) && is_array($_POST["deleteArea"])) {
        $ids = $_POST["deleteArea"];

        $deletedSuccessfully = $area->deleteArea($ids);

        if ($deletedSuccessfully) {
            header("Refresh: 0");
        } else {
            echo "Failed to delete areas.";
        }
    } else {
        echo "No areas selected for deletion.";
    }
}

if (isset($_POST["locationDeleteBtn"])) {

    // Check if "delete" checkboxes are selected
    if (isset($_POST["deleteLocation"]) && is_array($_POST["deleteLocation"])) {
        $ids = $_POST["deleteLocation"];

        $deletedSuccessfully = $area->deleteLocation($ids);

        if ($deletedSuccessfully) {
            header("Refresh: 0");
        } else {
            echo "Failed to delete areas.";
        }
    } else {
        echo "No areas selected for deletion.";
    }
}

if (isset($_POST["inspectorDeleteBtn"])) {

    // Check if "delete" checkboxes are selected
    if (isset($_POST["deleteinspector"]) && is_array($_POST["deleteinspector"])) {
        $usernames = $_POST["deleteinspector"];

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
    <link rel="stylesheet" href="dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>All areas </title>
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
                        <br>
                        <br>
                        <br>
                        <br>
                        <table>
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>area name</th>
                                    <th>delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $id = 1;
                                foreach ($areas as $area) {
                                    echo '
                    <tr>
                        <td>' . $id . '</td>
                        <td>' . $area["name"] . '</td>
                        <td><input type="checkbox" name="deleteArea[]" value="' . $area["number"] . '"> Delete</td>
                    </tr>
                ';
                                    $id++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <input class="submitDelet" type="submit" id="areaDeleteBtn" style="display: none;"
                            name="areaDeleteBtn" value="delete">
                    </form>
                    <br>
                    <br>

                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>location name</th>
                                    <th>area name</th>
                                    <th>delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $id = 1;
                                foreach ($locations as $location) {
                                    $area = new Area($con);
                                    $areaName = $area->getAreaName($location["areaId"]);
                                    echo '
                    <tr>
                        <td>' . $id . '</td>
                        <td>' . $location["name"] . '</td>
                        <td>' . $areaName . '</td>
                        <td><input type="checkbox" name="deleteLocation[]" value="' . $location["number"] . '"> Delete</td>
                    </tr>
                ';
                                    $id++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <input class="submitDelet" type="submit" id="locationDeleteBtn" style="display: none;"
                            name="locationDeleteBtn" value="delete">
                    </form>

                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>inspector name</th>
                                    <th>inspector email</th>
                                    <th>inspector passowrd</th>
                                    <th>inspector area</th>
                                    <th>delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $id = 1;
                                foreach ($inspectors as $inspector) {
                                    $area = new Area($con);
                                    $areaName = $area->getAreaName($inspector["area"]);
                                    echo '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $inspector["username"] . '</td>
                            <td>' . $inspector["email"] . '</td>
                            <td>' . $inspector["password"] . '</td>
                            <td>' . $areaName . '</td>
                            <td><input type="checkbox" name="deleteinspector[]" value="' . $inspector["username"] . '"> Delete</td>
                        </tr>
                    ';
                                    $id++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <input class="submitDelet" type="submit" id="inspectorDeleteBtn" style="display: none;"
                            name="inspectorDeleteBtn" value="delete">
                    </form>

                    <script>
                        // Function to check if at least one checkbox is checked
                        function atLeastOneCheckboxChecked(checkboxes) {
                            for (var i = 0; i < checkboxes.length; i++) {
                                if (checkboxes[i].checked) {
                                    return true; // At least one checkbox is checked
                                }
                            }
                            return false; // No checkboxes are checked
                        }

                        // Function to toggle the display of the submit button
                        function toggleSubmitButton(submitButton, checkboxes) {

                            if (atLeastOneCheckboxChecked(checkboxes)) {
                                submitButton.style.display = "block"; // Show the button
                            } else {
                                submitButton.style.display = "none"; // Hide the button
                            }
                        }

                        const showBtn = function (submitButton, checkboxes) {
                            for (var i = 0; i < checkboxes.length; i++) {
                                checkboxes[i].addEventListener("change", function () {
                                    toggleSubmitButton(submitButton, checkboxes)
                                });
                            }
                        }


                        // Add event listeners to checkboxes to toggle the submit button
                        const submitButton = document.getElementById('areaDeleteBtn');
                        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="deleteArea[]"]');
                        showBtn(submitButton, checkboxes);

                        const submitButton2 = document.getElementById('locationDeleteBtn');
                        const checkboxes2 = document.querySelectorAll('input[type="checkbox"][name="deleteLocation[]"]');
                        showBtn(submitButton2, checkboxes2);

                        const submitButton3 = document.getElementById('inspectorDeleteBtn');
                        const checkboxes3 = document.querySelectorAll('input[type="checkbox"][name="deleteinspector[]"]');
                        showBtn(submitButton3, checkboxes3);
                    </script>

</body>

</html>