<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/WorkType.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/Encryption.php');

$userToken = Encryption::decryptToken(@$_COOKIE["token"], 'msSCAra');
$account = new Account($con);
$userEmail = $account->getAccountEmail($userToken);

$request = new Request($con);

Powers::admin($account, $userToken);

$generatedNumbers = [];

while (true) {
    $randomNumber = mt_rand(10000000000, 99999999999);
    $workOrderNum = strval($randomNumber);

    if (!in_array($workOrderNum, $generatedNumbers)) {
        $generatedNumbers[] = $workOrderNum;
        break;
    }
}

$requestNum = $request->getReqNum();

$numberOfElements = $requestNum;

$area = new Area($con);
$getArea = $area->getArea();

$i = 1;
$requestNum = "";
$currentYear = date("Y");
while ($i <= $numberOfElements) {
    $requestNum = str_pad($i, 5, '0', STR_PAD_LEFT);
    $requestNum = $currentYear . $requestNum;
    $i++;
}

$adminName = $account->getAccountDetails($userEmail, true, false, false, false, true);
$executer = $account->getAccountByType('Execution');

$area = new Area($con);
$getArea = $area->getArea();

$workType = new workType($con);
$getWT = $workType->getWT();

$request = new Request($con);

if (isset($_POST["submit"])) {
    $reqNo = FormSanitizer::sanitizeFormString($_POST["reqNo"]);
    $adminAddedName = FormSanitizer::sanitizeFormString($_POST["adminAddedName"]);
    $workOrderNo = FormSanitizer::sanitizeFormString($_POST["workOrderNo"]);
    $area = $area->getAreaName(@$_POST["area"]);
    $item = @$_POST["item"];
    $length = @$_POST["length"];
    $width = @$_POST["width"];
    $height = @$_POST["height"];
    $priority = @$_POST["priority"];
    $workType = @$_POST["workType"];
    $executer = $account->getMainAccount('Execution');
    $wereHouse = $account->getMainAccount('wereHouse');
    $inspector = @$_POST["inspector"];
    $inspectorName = $account->getAccountDetails($inspector, true, false, false, false, true);
    $notes = FormSanitizer::sanitizeFormString(@$_POST["notes"]);

    $success = $request->addRequest($reqNo, $adminAddedName, $workOrderNo, $area, $item, $length, $width, $height, $workType, $priority, $executer, $wereHouse, $inspectorName, $notes);

    if ($success) {
        header("location: home.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="css.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Alexandria:wght@200;300;400;500;600;700;800&family=Source+Sans+Pro:wght@600&display=swap"
        rel="stylesheet">

    <script src="script.js" defer></script>
    <title>Request </title>
</head>

<body class="bodyaddrequest">
    <div>
        <a class="Back" href="home.php">
            <i class="fa-solid fa-arrow-left"></i> Back</a>


    </div>
    <div class="newrequest">
        <div class="login-container" id="login">
            <div class="top">
                <header class="namerequest">NewRequest</header>
            </div>
            <br>
            <div class="input-box">

                <form method="POST">
                    <p class="errorrequest">
                        <?php echo $request->getError(constants::$workOrderNoTaken); ?>
                    </p>
                    <br>
                    <label class="labelnewrequest">Req Name</label>
                    <br>
                    <br>
                    <input type="text" class="inputfieldrequest" placeholder="name" name="adminAddedName"
                        value="<?php echo $adminName; ?>" readonly required>
            </div>


            <br>
            <div class="input-box">
                <label class="labelnewrequest">Req No</label>
                <br>
                <br>
                <input type="text" class="inputfieldrequest" placeholder="Req No" name="reqNo" readonly
                    value="<?php echo $requestNum; ?>" required>
            </div>
            <br>
            <div class="input-box">
                <?php echo $request->getError(constants::$usernameTaken); ?>
                <label class="labelnewrequest">Work Order No</label>
                <br>
                <br>
                <input type="text" class="inputfieldrequest" placeholder="Work Order No" name="workOrderNo" required>
            </div>
            <br>
            <div>


                <select name="area" class="inputfieldselectnewreq" id="area" required>
                    <option disabled selected value="">select area</option>
                    <?php echo $getArea; ?>
                </select>
            </div>
            <br>
            <select name="item" class="inputfieldselectnewreq" id="item" required>
                <option disabled selected value="">select location</option>
            </select>
            <br>
            <br>
            <div class="met">
                <input type="number" class="input-length" id="length" min="1" placeholder="L" name="length">
                <input type="number" class="input-length" id="width" min="1" placeholder="W" name="width">

                <input type="number" class="input-length" id="height" min="1" placeholder="H" name="height">
            </div>
            <p id="boxResult"></p>
            <br>
            <label class="labelnewrequestpriority">Priority</label>
            <br>
            <br>
            <input class="priorty" type="radio" id="immediately" value="Immediately Today" name="priority" checked>
            <label class="priorty" for="immediately">Immediately &nbsp; Today</label>
            <br>
            <input class="priorty" type="radio" id="high" value="High 2-3 Days" name="priority">
            <label class="priorty" for="high">High &nbsp; 2-3 Days</label>
            <br>
            <input class="priorty" type="radio" id="medium" value="Medium 3-4 Days" name="priority">
            <label class="priorty" for="medium">Medium &nbsp; 4-5 Days</label>
            <br>
            <input class="priorty" type="radio" id="low" value="Low More than 5 days" name="priority">
            <label class="priorty" for="low">Low &nbsp; More than 5 days</label>
            <br>
            <br>
            <select name="workType" class="inputfieldselectnewreq" required>
                <option disabled selected value="">Select work type</option>
                <?php echo $getWT; ?>
            </select>
            <br>
            <br>
            <select name="inspector" id="inspector" class="inputfieldselectnewreq" required>
                <option disabled selected value="">select inspector</option>
            </select>
            <br>
            <label class="labelnewrequestpriority">Notes</label>
            <br>
            <textarea class="inputfieldnot" name="notes" required></textarea>

            <div class="input-box">
                <button type="submit" name="submit" class="submitnewreq">Done</button>
            </div>


            </form>
        </div>
    </div>

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