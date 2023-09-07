<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Area.php');

$userEmail = $_COOKIE["email"];

$account = new Account($con);
Powers::owner($account, $userEmail);
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css.css?1999">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <title>All areas </title>
</head>

<body>
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>area name</td>
                    <td>delete</td>
                </tr>
            </thead>

            <tbody>
                <?php
                $id = 1;
                foreach ($areas as $area) {
                    echo '
                    <tr>
                        <td>' . $area["number"] . '</td>
                        <td>' . $area["name"] . '</td>
                        <td><input type="checkbox" name="deleteArea[]" value="' . $area["number"] . '"> Delete</td>
                    </tr>
                ';
                    $id++;
                }
                ?>
            </tbody>
        </table>
        <input type="submit" id="areaDeleteBtn" style="display: none;" name="areaDeleteBtn" value="delete">
    </form>

    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>location name</td>
                    <td>area name</td>
                    <td>delete</td>
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
                        <td>' . $location["number"] . '</td>
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
        <input type="submit" id="locationDeleteBtn" style="display: none;" name="locationDeleteBtn" value="delete">
    </form>
    
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>inspector name</td>
                    <td>inspector email</td>
                    <td>inspector passowrd</td>
                    <td>inspector area</td>
                    <td>delete</td>
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
        <input type="submit" id="inspectorDeleteBtn" style="display: none;" name="inspectorDeleteBtn" value="delete">
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
        
        // Add event listeners to checkboxes to toggle the submit button
        const submitButton = document.getElementById('areaDeleteBtn');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="deleteArea[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener("change", function () {
                toggleSubmitButton(submitButton, checkboxes)
            });
        }

        const submitButton2 = document.getElementById('locationDeleteBtn');
        const checkboxes2 = document.querySelectorAll('input[type="checkbox"][name="deleteLocation[]"]');
        for (var i = 0; i < checkboxes2.length; i++) {
            checkboxes2[i].addEventListener("change", function () {
                toggleSubmitButton(submitButton2, checkboxes2)
            });
        }

        const submitButton3 = document.getElementById('inspectorDeleteBtn');
        const checkboxes3 = document.querySelectorAll('input[type="checkbox"][name="deleteinspector[]"]');
        for (var i = 0; i < checkboxes3.length; i++) {
            checkboxes3[i].addEventListener("change", function () {
                toggleSubmitButton(submitButton3, checkboxes3)
            });
        }
    </script>

</body>

</html>