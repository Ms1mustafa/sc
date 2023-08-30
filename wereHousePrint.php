<?php

$workOrderNo = $_GET["req"];

// require_once('ajax/GetWereHousePrint.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css.css?1999">
    <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Notification</title>
</head>


<body>
    <div id="reqInf"></div>
    <button>Print</button>

    <script>
        $(window).on("load", function () {
            $.get(
                "ajax/GetWereHousePrint.php",
                { workOrderNo: '<?php echo $workOrderNo; ?>' },
                function (data) {
                    $("#reqInf").html(data);
                }
            );
        })
    </script>

</body>

</html>