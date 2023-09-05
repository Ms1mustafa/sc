<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');


$userEmail = $_COOKIE["email"];

$account = new Account($con);
Powers::owner($account, $userEmail);

$req = new Request($con);
$requests = $req->getRequestDetails();
// print_r($requests);

// if (isset($_POST["submit"])) {

//     // Check if "delete" checkboxes are selected
//     if (isset($_POST["delete"]) && is_array($_POST["delete"])) {
//         $usernames = $_POST["delete"];
        
//         $deletedSuccessfully = $account->deleteUser($usernames);

//         if ($deletedSuccessfully) {
//             header("Refresh: 0");
//         } else {
//             echo "Failed to delete users.";
//         }
//     } else {
//         echo "No users selected for deletion.";
//     }
// }
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
    <form method="POST" action=""> <!-- Assuming "deleteUser.php" is the action URL -->
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>requester</td>
                    <td>work order No</td>
                    <td>request added date</td>
                    <td>request status</td>
                    <td>request finish date</td>
                </tr>
            </thead>
    
            <tbody>
                <?php
                $id = 1;
                foreach ($requests as $request) {
                    $status = $request["status"];
                    $qtyBackStatus = $request["qtyBackStatus"];
                    $executerAccept = $request["executerAccept"];
                    $executerNew = $request["executerNew"];
                    $issued = $request["issued"];
                    $executer = $request["executer"];
                    $wereHouse = $request["wereHouse"];
                    $inspector = $request["inspector"];

                    $reqStatus = "";

                    if($executerNew == 'yes'){
                        $reqStatus = $executer;
                    }
                    if(($executerNew != 'yes' && $issued != 'yes' && $status == 'pending') || $status == 'resent'){
                        $reqStatus = $wereHouse;
                    }
                    if(($issued == 'yes' && $status == 'pending') || $status == 'resentInspector'){
                        $reqStatus = $inspector;
                    }
                    if($status == 'rejected'){
                        $reqStatus = 'rejected';
                    }elseif($status == 'accepted'){
                        $reqStatus = 'accepted';
                    }
                    if($qtyBackStatus != 'no'){
                        $reqStatus = 'dismantling';
                    }

                    echo '
                    <tr>
                        <td>'. $id .'</td>
                        <td>' . $request["adminAddedName"] . '</td>
                        <td>' . $request["workOrderNo"] . '</td>
                        <td>' . FormSanitizer::formatDate($request["reqDate"]) . '</td>
                        <td>' . $reqStatus . '</td>
                        <td>' . FormSanitizer::formatDate($request["reqDate"]) . '</td>
                        </tr>
                    ';
                    $id ++;
                }
                ?>
            </tbody>
        </table>
        <input type="submit" style="display: none;" name="submit" value="Submit">
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