<?php
include_once('includes/config.php');
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/WorkType.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

$inspectors = $account->getAccount(true, false, true, true);

Powers::admin($account, $userToken);

$workOrderNo = $_GET["workOrderNo"];

if (!@$workOrderNo)
    header("Location: adminRequests.php");

$request = new Request($con);
$getRequest = $request->getRequestDetails($workOrderNo);

$canEdit = $getRequest['executerDate'] == NULL ? '' : 'disabled';
$executerAccept = $getRequest['executerAccept'] == 'yes' ? true : false;


$area = new Area($con);
$getArea = $area->getArea();

$workType = new workType($con);
$getWT = $workType->getWT();

if (isset($_POST["edit"])) {
    $area = $area->getAreaName(@$_POST["area"]);
    $item = @$_POST["item"];
    $length = @$_POST["length"];
    $width = @$_POST["width"];
    $height = @$_POST["height"];
    $priority = @$_POST["priority"];
    $workType = @$_POST["workType"];
    $inspector = @$_POST["inspector"];
    $inspectorName = $getRequest["inspector"] ?? $account->getAccountDetails($inspector, true, false, false, false);
    $notes = FormSanitizer::sanitizeFormString(@$_POST["notes"]);

    $success = $request->editRequest($workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $inspectorName, $notes);
    if ($success) {
        header("location: home.php");
    }
}

if (isset($_POST["delete"])) {

    $success = $request->deleteRequest($workOrderNo);
    if ($success) {
        header("location: home.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Document</title>
</head>

<body class="bodyaddrequest">
    <div>
        <a class="Back" href="adminRequests.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <div class="newrequest">

        <div class="login-container" id="login">
            <div class="top">

                <header class="namerequest">EditRequest</header>
            </div>
            <br>
            <div class="input-box">

                <form method="POST">
                    <p class="errorrequest">
                        <?php echo $request->getError(constants::$requestFailed); ?>
                    </p>
                    <label class="requestAction">ReqNo :
                        <?php echo $getRequest['reqNo']; ?>
                    </label>
                    <br>
                    <br>
                    <label class="requestAction">Work Order No :
                        <?php echo $workOrderNo; ?>
                    </label>
                    <br>

                    <br>
                    <label class="requestAction">Requester :
                        <?php echo $getRequest['adminAddedName']; ?>
                    </label>
                    <br>
                    <br>
                    <br>
                    <label class="requestActionArea">Area</label>
                    <br>
                    <br>
                    <select class="inputfieldrequestAction" name="area" id="area" required <?php echo $canEdit; ?>>
                        <?php if ($getRequest['area']) {

                            echo '<option value="' . $getRequest['area'] . '" selected >' . $getRequest['area'] . '</option>';
                        } ?>
                        <?php echo $getArea; ?>
                    </select>
                    <br>
                    <br>
                    <label class="requestActionArea">Location</label>
                    <br>
                    <br>
                    <select class="inputfieldrequestAction" name="item" id="item" required <?php echo $canEdit; ?>>
                        <?php if ($getRequest['item']) {

                            echo '<option value="' . $getRequest['item'] . '" selected >' . $getRequest['item'] . '</option>';
                        } ?>
                    </select>
                    <br>
                    <br>
                    <input type="number" class="inputlength" id="length" min="1" placeholder="L" name="length"
                        value="<?php echo $getRequest['length']; ?>" <?php echo $canEdit; ?>>
                    <input type="number" class="inputlength" id="width" min="1" placeholder="W" name="width"
                        value="<?php echo $getRequest['width']; ?>" <?php echo $canEdit; ?>>
                    <input type="number" class="inputlength" id="height" min="1" placeholder="H" name="height"
                        value="<?php echo $getRequest['height']; ?>" <?php echo $canEdit; ?>>
                    <br>
                    <br>
                    <label class="requestActionArea">priority</label>
                    <br>
                    <br>
                    <input type="radio" id="immediately" value="Immediately Today" name="priority" <?php echo $getRequest['priority'] == 'Immediately Today' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
                    <label class="requestActionArea" for="immediately">Immediately &nbsp; Today</label>
                    <br>
                    <input type="radio" id="high" value="High 2-3 Days" name="priority" <?php echo $getRequest['priority'] == 'High 2-3 Days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
                    <label class="requestActionArea" for="high">High &nbsp; 2-3 Days</label>
                    <br>
                    <input type="radio" id="medium" value="Medium 3-4 Days" name="priority" <?php echo $getRequest['priority'] == 'Medium 3-4 Days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
                    <label class="requestActionArea" for="medium">Medium &nbsp; 3-4 Days</label>
                    <br>
                    <input type="radio" id="low" value="Low More than 5 days" name="priority" <?php echo $getRequest['priority'] == 'Low More than 5 days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
                    <label class="requestActionArea" for="low">Low &nbsp; More than 5 days</label>
                    <br>
                    <br>
                    <label class="requestActionArea">work type</label>
                    <br>
                    <br>
                    <select class="inputfieldrequestAction" name="workType" required <?php echo $canEdit; ?>>
                        <option selected value="<?php echo $getRequest['workType'] ?? ''; ?>">
                            <?php echo $getRequest['workType'] ?? 'Select work type'; ?>
                        </option>
                        <?php echo $getWT; ?>
                    </select>
                    <br>
                    <br>
                    <label class="requestActionArea">Inspector</label>
                    <br>
                    <br>
                    <select class="inputfieldrequestAction" name="inspector" id="inspector" required <?php echo $canEdit; ?>>
                        <option selected value="<?php echo $getRequest['inspector'] ?? ''; ?>">
                            <?php echo $getRequest['inspector'] ?? 'select inspector'; ?>
                        </option>
                        <?php echo $inspectors; ?>
                    </select>
                    <br>
                    <br>
                    <label class="requestActionArea">Notes</label>
                    <br>
                    <br>
                    <textarea class="inputfieldnotAction"
                        name="notes"><?php echo $getRequest['notes']; ?> <?php echo $canEdit; ?></textarea>
                    <br>
                    <br>
                    <?php
                    if (!$executerAccept) {
                        echo '
                <button type="submit"  class="submitEdite" name="edit"' . $canEdit . '>Edit</button>
                <br>
                <br>
                <button type="submit"  class="submitEdite" name="delete"' . $canEdit . '>Delete</button>
            ';
                    } else {
                        echo '
                <br>
                <button type="submit"  class="submit" name="dismantling"' . $canEdit . '>dismantling</button>
            ';
                    }
                    ?>

                </form>

                <script>
                    $("#area").on("change", function (e) {
                        $.get(
                            "ajax/GetItems.php",
                            { areaId: $("#area").val() },
                            function (data) {
                                $("#item").html(data);
                            }
                        );
                        $.get(
                            "ajax/GetInspectors.php",
                            { areaId: $("#area").val() },
                            function (data) {
                                $("#inspector").html(data);
                            }
                        );

                    })
                </script>
</body>

</html>