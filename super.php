<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');

$account = new Account($con);
$request = new Request($con);
$Area = new Area($con);

$filter = @$_POST["month"] ?? date('Y-m');
$requests = $request->getRequestDetails(null, null, 'all');
// echo FormSanitizer::formatMonthYear('2023-01');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <!-- <link rel="stylesheet" href="../shared.css" /> -->
  <link rel="stylesheet" href="dashboard.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>

  <title>Dashboard </title>
</head>

<body class="bodyDashboardIMg">

  <!--------------------------------Dashboard-------------------------------------->


  <section class="Dashboardsection">
    <label class="LabelRq" for="">Request</label>
    <table class="alluser">
      <thead>
        <tr>
          <th>Area</th>
          <th>Don</th>
          <th>InProcess</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($Area->getArea(true) as $area) {
          $areaName = $area['name'];
          $finishCount = $request->getRequestNum($areaName, "qtyBackStatus = 'finish'");
          $notFinishCount = $request->getRequestNum($areaName, "qtyBackStatus != 'finish'");

          echo "<tr>
                  <td>$areaName</td>
                  <td>";
          // Check if finish count is greater than 0
          if ($finishCount > 0) {
            echo "<a href='allReq.php?qbs=finish&n=" . urlencode($areaName) . "'>$finishCount</a>";
          } else {
            echo $finishCount;
          }

          echo "</td>
              <td>";

          // Check if not finish count is greater than 0
          if ($notFinishCount > 0) {
            echo "<a href='allReq.php?qbs=notfinish&n=" . urlencode($areaName) . "'>$notFinishCount</a>";
          } else {
            echo $notFinishCount;
          }

          echo "</td>
              </tr>";
        }
        ?>
      </tbody>

    </table>



    <label class="" for=""></label>
    <table class="alluser">
      <form action="" method="POST">
        <input class="month" type="month" id="month" name="month" value=<?php echo $filter; ?>>&nbsp;
        <input class="filterDashboard" type="submit" value="filter">
      </form>
      <tr>
        <th>Area</th>
        <th>Orders</th>
      </tr>
      <tbody>
        <?php
        foreach ($Area->getArea(true) as $area) {
          $areaName = $area['name'];
          $orders = $request->getRequestNum($area['name'], null, $filter);
          echo "
            <tr>
          <td>";
          echo $areaName . "</td>
          <td>";
          if ($orders > 0) {
            echo "<a href='allReq.php?&n=" . urlencode($areaName) . "'>$orders</a>";
          } else {
            echo $orders;
          }
          "
          </tr>
          ";
          // echo "<td>" . $area['name'] . "</td>";
        }

        ?>
      </tbody>

    </table>



    <label class="LabelRq" for="">Request the best</label>
    <table class="alluser">
      <thead>
        <tr>
          <th> Req Num</th>
          <th>Pending In</th>
          <th>Type pending</th>
          <th>Pending time</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($requests as $req) {
          $status = $req["status"];
          $qtyBackStatus = $req["qtyBackStatus"];
          $qtyBackDate = $req["qtyBackDate"];
          $executer = $req["executer"];
          $wereHouse = $req["wereHouse"];
          $inspector = $req["inspector"];
          $reqDate = $req["reqDate"];
          $executerDate = $req["executerDate"];
          $wereHouseDate = $req["wereHouseDate"];
          $inspectorDate = $req["inspectorDate"];
          $reqType = $req["type_req"];

          $pendingTime = '';
          if (ucfirst($account->getTypeByName($req["pending_in"])) === "WereHouse") {
            $pendingTime = FormSanitizer::formatTimeDifference($qtyBackDate ? FormSanitizer::formatDate($qtyBackDate) : $executerDate, date('Y-m-d H:i:s.u'));
          }

          if (ucfirst($account->getTypeByName($req["pending_in"])) === "Execution") {
            $pendingTime = FormSanitizer::formatTimeDifference($reqDate, date('Y-m-d H:i:s.u'));

            if ($qtyBackDate) {
              $pendingTime = FormSanitizer::formatTimeDifference($qtyBackDate, date('Y-m-d H:i:s.u'));
            } elseif ($inspectorDate) {
              $pendingTime = FormSanitizer::formatTimeDifference($inspectorDate, date('Y-m-d H:i:s.u'));
            } elseif ($wereHouseDate) {
              $pendingTime = FormSanitizer::formatTimeDifference($wereHouseDate, date('Y-m-d H:i:s.u'));
            }
          }

          if (ucfirst($account->getTypeByName($req["pending_in"])) === "WereHouse") {
            $pendingTime = FormSanitizer::formatTimeDifference($qtyBackDate ? FormSanitizer::formatDate($qtyBackDate) : $executerDate, date('Y-m-d H:i:s.u'));
          }

          if (ucfirst($account->getTypeByName($req["pending_in"])) === "Inspector") {
            $executerAcceptDate = $req["executerAcceptDate"] ? $req["executerAcceptDate"] : null;
            $resentDate = $req["resentDate"] ? $req["resentDate"] : null;
            $pendingTime = FormSanitizer::formatTimeDifference($executerAcceptDate, date('Y-m-d H:i:s.u'));
            if ($status === 'resentInspector') {
              $pendingTime = FormSanitizer::formatTimeDifference($resentDate, date('Y-m-d H:i:s.u'));
            }
          }

          // $pendingTime = FormSanitizer::formatTimeDifference($reqDate, date('Y-m-d H:i:s.u'));
          // if ($reqType === 'Executer')
          //   $pendingTime = FormSanitizer::formatTimeDifference($executerDate, date('Y-m-d H:i:s.u'));
        
          // if ($reqType === 'Reject' && $inspectorDate)
          //   $pendingTime = FormSanitizer::formatTimeDifference($inspectorDate, date('Y-m-d H:i:s.u'));
        
          // if ($reqType === 'Reject' && !$inspectorDate)
          //   $pendingTime = FormSanitizer::formatTimeDifference($executerDate, date('Y-m-d H:i:s.u'));
        
          // if ($reqType === 'WereHouse')
          //   $pendingTime = FormSanitizer::formatTimeDifference($executerDate, date('Y-m-d H:i:s.u'));
        
          // if ($reqType === 'Inspector')
          //   $pendingTime = FormSanitizer::formatTimeDifference($wereHouseDate, date('Y-m-d H:i:s.u'));
        
          echo '
                    <tr>
                        <td>' . $req["reqNo"] . '</a></td>
                        <td>' . $req["pending_in"] . '</td>
                        <td>' . ucfirst($account->getTypeByName($req["pending_in"])) . '</td>
                        <td>' . $pendingTime . '</td>
                        </tr>
                    ';
        }
        ?>
      </tbody>
      <!-- <tr>
        <td>20230001</td>
        <td>20230001</td>
        <td>20230001</td>
        <td>20230001</td>
      </tr> -->

      </tablel>
  </section>







</body>

</html>