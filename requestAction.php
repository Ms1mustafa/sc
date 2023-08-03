<?php
include_once('includes/config.php');
include_once('includes/classes/Account.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/workType.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);
$inspectors = $account->getAccount(true, false, true, true);

Powers::admin($account, $userEmail);

$workOrderNo = $_GET["workOrderNo"];

$request = new Request($con);
$getRequest = $request->getRequestDetails($workOrderNo);

$canEdit = $getRequest['executerDate'] == NULL ? '' : 'disabled';


$area = new Area($con);
$getArea = $area->getArea();

$workType = new workType($con);
$getWT = $workType->getWT();

if (isset($_POST["edit"])) {
    $area = @$_POST["area"];
    $item = @$_POST["item"];
    $length = @$_POST["length"];
    $width = @$_POST["width"];
    $height = @$_POST["height"];
    $priority = @$_POST["priority"];
    $workType = @$_POST["workType"];
    $inspector = @$_POST["inspector"];
    $inspectorName = $getRequest["inspector"] ?? $account->getAccountDetails($inspector, true, false, false, false, false);
    $notes = FormSanitizer::sanitizeFormString(@$_POST["notes"]);

    $success = $request->editRequest($workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $inspectorName, $notes);
    if ($success) {
        header("location: requestAction.php?workOrderNo=".$workOrderNo."");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <form method="POST">
        <?php echo $request->getError(constants::$requestFailed); ?>
        <label>ReqNo</label>
        <input value="<?php echo $getRequest['reqNo']; ?>" placeholder="Req No" name="reqNo" disabled readonly required>
        <br>
        <label class="priority">Work Order No</label>
        <input type="text" class="input-field" placeholder="Work Order No" name="workOrderNo" disabled readonly
            value="<?php echo $workOrderNo; ?>" required>
        <br>
        <label>Requester</label>
        <input value="<?php echo $getRequest['name']; ?>" name="name" disabled readonly>
        <br>
        <br>
        <label>Area</label>
        <select name="area" class="input-field" id="area" required <?php echo $canEdit; ?>>
            <?php if ($getRequest['area']) {

                echo '<option value="' . $getRequest['area'] . '" selected >' .$getRequest['area'] . ' - ' .$area->getAreaName($getRequest['area']) . '</option>';
            } ?>
            <?php echo $getArea; ?>
        </select>
        <br>
        <label>Location</label>
        <select name="item" class="input-field" id="item" required <?php echo $canEdit; ?>>
            <?php if ($getRequest['item']) {

                echo '<option value="' . $getRequest['item'] . '" selected >' . $getRequest['item'] . '</option>';
            } ?>
        </select>
        <br>
        <input type="number" class="input-number" id="length" min="1" placeholder="L" name="length"
            value="<?php echo $getRequest['length']; ?>" <?php echo $canEdit; ?>><span class="metre">m</span>
        <input type="number" class="input-number" id="width" min="1" placeholder="W" name="width"
            value="<?php echo $getRequest['width']; ?>" <?php echo $canEdit; ?>><span class="metre">m</span>
        <input type="number" class="input-number" id="height" min="1" placeholder="H" name="height"
            value="<?php echo $getRequest['height']; ?>" <?php echo $canEdit; ?>><span class="metre">m</span>
        <br>
        <label>priority</label>
        <br>
        <input type="radio" id="immediately" value="Immediately Today" name="priority" <?php echo $getRequest['priority'] == 'Immediately Today' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priority" for="immediately">Immediately &nbsp; Today</label>
        <br>
        <input type="radio" id="high" value="High 2-3 Days" name="priority" <?php echo $getRequest['priority'] == 'High 2-3 Days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priority" for="high">High &nbsp; 2-3 Days</label>
        <br>
        <input type="radio" id="medium" value="Medium 3-4 Days" name="priority" <?php echo $getRequest['priority'] == 'Medium 3-4 Days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priority" for="medium">Medium &nbsp; 3-4 Days</label>
        <br>
        <input type="radio" id="low" value="Low More than 5 days" name="priority" <?php echo $getRequest['priority'] == 'Low More than 5 days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priority" for="low">Low &nbsp; More than 5 days</label>
        <br>
        <label>work type</label>
        <select name="workType" class="input-field" required <?php echo $canEdit; ?>>
            <option selected value="<?php echo $getRequest['workType'] ?? ''; ?>"><?php echo $getRequest['workType'] ?? 'Select work type'; ?></option>
            <?php echo $getWT; ?>
        </select>
        <br>
        <label>Inspector</label>
        <select name="inspector" class="input-field" required <?php echo $canEdit; ?>>
            <option selected value="<?php echo $getRequest['inspector'] ?? ''; ?>"><?php echo $getRequest['inspector'] ?? 'select inspector'; ?></option>
            <?php echo $inspectors; ?>
        </select>
        <br>
        <label>Notes</label>
        <input name="notes" value="<?php echo $getRequest['notes']; ?>" <?php echo $canEdit; ?>>
        <br>
        <button type="submit" name="edit" class="submit" <?php echo $canEdit; ?>>Edit</button>
        <button type="submit" name="delete" class="submit" <?php echo $canEdit; ?>>Delete</button>
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

        })
    </script>
</body>

</html>