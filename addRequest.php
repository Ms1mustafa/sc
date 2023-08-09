<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/WorkType.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Powers.php');

$userEmail = $_COOKIE["email"];

if (!$userEmail) {
    header("location: login.php");
}

$account = new Account($con);

$request = new Request($con);

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
    
   
    <link rel="stylesheet" href="css.css?1999">
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

<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <p>LOGO .<i class="fa-solid fa-circle-caret-left"></i></p>
                

            </div>
           
            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="home.php" class="link active">Home</a></li>
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

                <header ></header>
            </div>
            <br>
            <div class="input-box">

                <form method="POST">
                    <?php echo $request->getError(constants::$workOrderNoTaken); ?>
                    <br>
                    <label class="priority">Req Name</label>
                    <br>
                    <input type="text" class="input-field" placeholder="name" name="name"
                        value="<?php echo $adminName; ?>" readonly required>
            </div>
            <br>
            <div class="input-box">
                <label class="priority">Req No</label>
                <br>
                <input type="text" class="input-field" placeholder="Req No" name="reqNo" readonly
                    value="<?php echo $requestNum; ?>" required>
            </div>
            <br>
            <div class="input-box">
            <?php echo $request->getError(constants::$usernameTaken); ?>
                <label class="priority">Work Order No</label>
                <br>
                <input type="text" class="input-field" placeholder="Work Order No" name="workOrderNo" required>
            </div>
            <br>
<div>
            <select name="area" class="input-field" id="area" required>
                <option disabled selected value="">select area</option>
                <?php echo $getArea; ?>
            </select>
</div>
<br>
            <select name="item" class="input-field" id="item" required>
                <option disabled selected value="">select location</option>
            </select>
            <br>
            <br>
            <div class="met">
            <input type="number" class="input-number" id="length" min="1" placeholder="L" name="length"><span
                class="metre">L</span>
            <input type="number" class="input-number" id="width" min="1" placeholder="W" name="width"><span
                class="metre">W</span>
              
              <input type="number" class="input-number" id="height" min="1" placeholder="H" name="height"><span
                class="metre">H</span>
</div>
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
            <label class="priority" for="medium">Medium &nbsp; 4-5 Days</label>
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
            <select name="inspector" id="inspector" class="input-field" required>
                <option disabled selected value="">select inspector</option>
            </select>
            <br>
            <label class="priority">Notes</label>
            <br>
            <textarea class="input-note" name="notes" required></textarea>
         
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