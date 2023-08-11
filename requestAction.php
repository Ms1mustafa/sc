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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Document</title>
</head>

<body>

<div class="newrequest">
       
        <div class="login-container" id="login">
            <div class="top">

                <header class="namerequest">Edit Request</header>
            </div>
            <br>
            <br>
            <div class="input-box">
      
    <form method="POST">
        <?php echo $request->getError(constants::$requestFailed); ?>
        <label class="labelnewrequest">ReqNo</label>
        <br>
        <br>
        <input value="<?php echo $getRequest['reqNo']; ?>" placeholder="Req No" class="inputfieldrequest" name="reqNo" disabled readonly required>
</div>
        <br>
        <div class="input-box">
        <label class="labelnewrequest">Work Order No</label>
        <br>
        <input type="text"laceholder="Work Order No" class="inputfieldrequest" name="workOrderNo" disabled readonly
            value="<?php echo $workOrderNo; ?>" required>
</div>
        <br>
        <div class="input-box">
        <label class="labelnewrequest">Requester</label>
        <br>
        <input value="<?php echo $getRequest['name']; ?>" class="inputfieldrequest" name="name" disabled readonly>
</div>
        <br>
        <br>
      <div>
        <select  class="inputfieldselectnewreqAction" name="area" id="area" required <?php echo $canEdit; ?>>
            <?php if ($getRequest['area']) {

                echo '<option value="' . $getRequest['area'] . '" selected >' .$getRequest['area'] . ' - ' .$area->getAreaName($getRequest['area']) . '</option>';
            } ?>
            <?php echo $getArea; ?>
        </select>
        </div>
        <br>
       
        <br>
        <select  class="inputfieldselectnewreqAction" name="item"  id="item" required <?php echo $canEdit; ?>>
            <?php if ($getRequest['item']) {

                echo '<option value="' . $getRequest['item'] . '" selected >' . $getRequest['item'] . '</option>';
            } ?>
        </select>
        <br>
        <br>
        <div >
        <input type="number"   class="input-lengthAction" id="length" min="1" placeholder="L" name="length"
            value="<?php echo $getRequest['length']; ?>" <?php echo $canEdit; ?>>
        <input type="number"  class="input-lengthAction" id="width" min="1" placeholder="W" name="width"
            value="<?php echo $getRequest['width']; ?>" <?php echo $canEdit; ?>>
        <input type="number"  class="input-lengthAction" id="height" min="1" placeholder="H" name="height"
            value="<?php echo $getRequest['height']; ?>" <?php echo $canEdit; ?>>
        <br>
        <br>
        </div>
        <label class="labelnewrequestpriorityAction">priority</label>
        <br>
        <input class="priortyAction" type="radio" id="immediately" value="Immediately Today" name="priority" <?php echo $getRequest['priority'] == 'Immediately Today' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priortyAction" for="immediately">Immediately &nbsp; Today</label>
        <br>
        <input class="priortyAction" type="radio" id="high" value="High 2-3 Days" name="priority" <?php echo $getRequest['priority'] == 'High 2-3 Days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priortyAction" for="high">High &nbsp; 2-3 Days</label>
        <br>
        <input class="priortyAction" type="radio" id="medium" value="Medium 3-4 Days" name="priority" <?php echo $getRequest['priority'] == 'Medium 3-4 Days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priortyAction" for="medium">Medium &nbsp; 3-4 Days</label>
        <br>
        <input class="priortyAction" type="radio" id="low" value="Low More than 5 days" name="priority" <?php echo $getRequest['priority'] == 'Low More than 5 days' ? 'checked' : ''; ?> <?php echo $canEdit; ?>>
        <label class="priortyAction" for="low">Low &nbsp; More than 5 days</label>
        <br>
       
        <br>
        <select  class="inputfieldselectnewreqAction" name="workType"required <?php echo $canEdit; ?>>
            <option selected value="<?php echo $getRequest['workType'] ?? ''; ?>"><?php echo $getRequest['workType'] ?? 'Select work type'; ?></option>
            <?php echo $getWT; ?>
        </select>
        <br>
       
        <br>
        <select class="inputfieldselectnewreqAction" name="inspector"  required <?php echo $canEdit; ?>>
            <option selected value="<?php echo $getRequest['inspector'] ?? ''; ?>"><?php echo $getRequest['inspector'] ?? 'select inspector'; ?></option>
            <?php echo $inspectors; ?>
        </select>
        <br>
        <label class="labelnewrequestnotAction">Notes</label>
        <br>
        <input class="inputfieldnotAction" name="notes" value="<?php echo $getRequest['notes']; ?>" <?php echo $canEdit; ?>>
           <br>  
           <br>  
        <div class="input-box">
        <button type="submit"  class="submitnewreqAction" name="edit"  <?php echo $canEdit; ?>>Edit</button>
        <br>
        <br>
        <button type="submit"  class="submitnewreqAction"name="delete"  <?php echo $canEdit; ?>>Delete</button>
        </div>
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