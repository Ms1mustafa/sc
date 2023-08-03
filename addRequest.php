<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/workType.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);

Powers::admin($account, $userEmail);

$generatedNumbers = [];

while (true) {
    $randomNumber = mt_rand(10000000000, 99999999999);
    $workOrderNum = strval($randomNumber);

    if (!in_array($workOrderNum, $generatedNumbers)) {
        $generatedNumbers[] = $workOrderNum;
        break;
    }
}

$requestNum = $account->getAccountDetails($userEmail, false, false, false, false, true);
$adminName = $account->getAccountDetails($userEmail, true, false, false, false, true);
$inspectors = $account->getAccount(true, false, true, true);
$executer = $account->getAccountByType('Execution');

$area = new Area($con);
$getArea = $area->getArea();

$workType = new workType($con);
$getWT = $workType->getWT();

$request = new Request($con);

if (isset($_POST["submit"])) {
    $reqNo = FormSanitizer::sanitizeFormString($_POST["reqNo"]);
    $name = FormSanitizer::sanitizeFormString($_POST["name"]);
    $workOrderNo = FormSanitizer::sanitizeFormString($_POST["workOrderNo"]);
    $area = $area->getAreaName(@$_POST["area"]);
    $item = @$_POST["item"];
    $length = @$_POST["length"];
    $width = @$_POST["width"];
    $height = @$_POST["height"];
    $priority = @$_POST["priority"];
    $workType = @$_POST["workType"];
    $inspector = @$_POST["inspector"];
    $inspectorName = $account->getAccountDetails($inspector, true, false, false, false, true);
    $notes = FormSanitizer::sanitizeFormString(@$_POST["notes"]);

    $success = $request->addRequest($reqNo, $name, $workOrderNo, $area, $item, $length, $width, $height, $priority, $workType, $executer, $inspectorName, $notes, 'pending');

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
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <title>Request </title>
</head>

<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <p>LOGO .</p>
            </div>

            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="#" class="link active">Home</a></li>
                    <li><a href="#" class="link">Blog</a></li>
                    <li><a href="#" class="link">Services</a></li>
                    <li><a href="#" class="link">About</a></li>
                </ul>
                <div class="nav-button">
                    <button class="btn white-btn">Log out</button>

                </div>
                <div class="nav-menu-btn">
                    <i class="bx bx-menu" onclick="myMenuFunction()"></i>
                </div>
        </nav>

        <div class="login-container" id="login">
            <div class="top">

                <header class="addrequest">Add Request...</header>
            </div>
            <br>
            <div class="input-box">

                <form method="POST">
                    <?php echo $request->getError(constants::$requestFailed); ?>
                    <br>
                    <label class="priority">Req Name</label>
                    <input type="text" class="input-field" placeholder="name" name="name"
                        value="<?php echo $adminName; ?>" readonly required>
            </div>
            <div class="input-box">
                <label class="priority">Req No</label>
                <input type="text" class="input-field" placeholder="Req No" name="reqNo" readonly
                    value="<?php echo $requestNum; ?>" required>
            </div>
            <div class="input-box">
                <label class="priority">Work Order No</label>
                <input type="text" class="input-field" placeholder="Work Order No" name="workOrderNo" readonly
                    value="<?php echo $workOrderNum; ?>" required>
            </div>
            <br>

            <select name="area" class="input-field" id="area" required>
                <option disabled selected value="">select area</option>
                <?php echo $getArea; ?>
            </select>
            <br>
            <br>
            <select name="item" class="input-field" id="item" required>
                <option disabled selected value="">select location</option>
            </select>
            <br>
            <br>
            <input type="number" class="input-number" id="length" min="1" placeholder="L" name="length"><span
                class="metre">m</span>
            <input type="number" class="input-number" id="width" min="1" placeholder="W" name="width"><span
                class="metre">m</span>
            <input type="number" class="input-number" id="height" min="1" placeholder="H" name="height"><span
                class="metre">m</span>
            <br>
            <p id="boxResult"></p>
            <br>
            <label class="priority">Priority</label>
            <br>
            <br>
            <input type="radio" id="immediately" value="Immediately Today" name="priority" checked>
            <label class="priority" for="immediately">Immediately &nbsp; Today</label>
            <br>
            <input type="radio" id="high" value="High 2-3 Days" name="priority">
            <label class="priority" for="high">High &nbsp; 2-3 Days</label>
            <br>
            <input type="radio" id="medium" value="Medium 3-4 Days" name="priority">
            <label class="priority" for="medium">Medium &nbsp; 3-4 Days</label>
            <br>
            <input type="radio" id="low" value="Low More than 5 days" name="priority">
            <label class="priority" for="low">Low &nbsp; More than 5 days</label>
            <br>
            <br>
            <select name="workType" class="input-field" required>
                <option disabled selected value="">Select work type</option>
                <?php echo $getWT; ?>
            </select>
            <br>
            <br>
            <select name="inspector" class="input-field" required>
                <option disabled selected value="">select inspector</option>
                <?php echo $inspectors; ?>
            </select>
            <br>
            <label class="priority">Notes</label>
            <textarea class="input-note" name="notes" required>Notes</textarea>
            <br>
            <div class="input-box">
                <button type="submit" name="submit" class="submit">submit</button>
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

        })
    </script>
</body>

</html>