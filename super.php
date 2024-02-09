<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/ItemDes.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');

$account = new Account($con);
$request = new Request($con);
$Area = new Area($con);
$items = new ItemDes($con);

$filter = @$_POST["month"] ?? date('Y-m');
$requests = $request->getRequestDetails(null, null, 'all');
// echo FormSanitizer::formatMonthYear('2023-01');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <!-- <link rel="stylesheet" href="../shared.css" /> -->
  <link rel="stylesheet" href="dashbordtable.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/6c84e23e68.js" crossorigin="anonymous"></script>

  <title>Dashboard </title>
</head>

<body class="">
  <div class="nave">
    <p class="hidden-xs"><strong>Scaff</strong>olding</span></a>
    <p>

      <li>
        <form role="search" class="app-search hidden-xs">
          <input type="text" placeholder="Search..." class="form-control">

        </form>
      </li>
  </div>



  <!--------------------------------Dashboard-------------------------------------->

  <section class="Dashboardsection">
    <label class="LabelRq" for="">Request</label>
    <div class="flexe">
      <table class="alluser">
        <thead>
          <tr>
            <th>Area</th>
            <th>Close</th>
            <th>In Process</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $totalFinishCount = 0;
          $totalNotFinishCount = 0;

          foreach ($Area->getArea(true) as $area) {
            $areaName = $area['name'];
            $finishCount = $request->getRequestNum($areaName, "qtyBackStatus = 'finish'");
            $notFinishCount = $request->getRequestNum($areaName, "qtyBackStatus != 'finish'");

            $totalFinishCount += $finishCount;
            $totalNotFinishCount += $notFinishCount;


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
          <td>Totel</td>
          <td>
            <?php echo $totalFinishCount; ?>
          </td>
          <td>
            <?php echo $totalNotFinishCount; ?>
          </td>

        </tbody>

      </table>

      <p class="totel"> Totel =
        <?php echo $totalFinishCount + $totalNotFinishCount; ?>
      </p>


      <div class="flexe1">

        <label class="LabelMothly" for="">Monthly Request Check</label>
        <br>
        <br>
        <table class="alluser">
          <div>
            <form action="" method="POST">
              <input class="month" type="month" id="month" name="month" value=<?php echo $filter; ?>>&nbsp;
              <input class="filterDashboard" type="submit" value="filter">
            </form>
          </div>
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

      </div>


  </section>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <section class="dastable">
    <label class="Labelthebeste" for="">Request Top 10</label>
    <div class="flex3">



      <button class="Sortby" onclick="toggleSort()">Sort by delay</button>
      <form action="" method="POST">
        <input class="month2" type="month" id="month" name="month" value=<?php echo $filter; ?>>&nbsp;
        <input class="filterDashboard2" type="submit" value="filter">
      </form>


      <table class="alluser2">
        <thead>
          <tr>
            <th> Req Num</th>
            <th>Pending In</th>
            <th>Type pending</th>
            <th>Type Req</th>
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

            if (ucfirst($account->getTypeByName($req["pending_in"])) === "Requester") {
              if ($status === 'accepted') {
                $pendingTime = FormSanitizer::formatTimeDifference($qtyBackDate ? FormSanitizer::formatDate($qtyBackDate) : $inspectorDate, date('Y-m-d H:i:s.u'));
              }
              if ($status === 'rejected' && !$inspectorDate) {
                $pendingTime = FormSanitizer::formatTimeDifference($qtyBackDate ? FormSanitizer::formatDate($qtyBackDate) : $executerDate, date('Y-m-d H:i:s.u'));
              }
            }

            if (ucfirst($account->getTypeByName($req["pending_in"])) === "Inspector") {
              $executerAcceptDate = $req["executerAcceptDate"] ? $req["executerAcceptDate"] : null;
              $resentDate = $req["resentDate"] ? $req["resentDate"] : null;
              $pendingTime = FormSanitizer::formatTimeDifference($executerAcceptDate, date('Y-m-d H:i:s.u'));
              if ($status === 'resentInspector') {
                $pendingTime = FormSanitizer::formatTimeDifference($resentDate, date('Y-m-d H:i:s.u'));
              }
            }
            $sortedRequests[] = [
              'reqNo' => $req["reqNo"],
              'pending_in' => $req["pending_in"],
              'type_req' => $req["type_req"],
              'type' => ucfirst($account->getTypeByName($req["pending_in"])),
              'pendingTime' => $pendingTime,
            ];
          }

          // Sort the array based on pending time (ascending order)
          usort($sortedRequests, function ($a, $b) {
            return strtotime($a['pendingTime']) - strtotime($b['pendingTime']);
          });

          // Display the first 10 rows
          $reverseSort = isset($_GET['reverseSort']) ? true : false;

          // Reverse the array if needed
          if ($reverseSort) {
            $sortedRequests = array_reverse($sortedRequests);
          }

          // Display the first 10 rows
          $counter = 0;
          foreach ($sortedRequests as $sortedReq) {
            if ($counter >= 10) {
              break; // Limit to 10 rows
            }

            echo '
      <tr>
        <td>' . $sortedReq["reqNo"] . '</td>
        <td>' . $sortedReq["pending_in"] . '</td>
        <td>' . $sortedReq["type"] . '</td>
        <td>' . $sortedReq["type_req"] . '</td>
        <td>' . $sortedReq["pendingTime"] . '</td>
      </tr>
    ';

            $counter++;
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

  <div>
  </div>

  <script>
    // JavaScript function to toggle between ascending and descending sort order
    function toggleSort() {
      var currentUrl = window.location.href;
      var reverseSort = currentUrl.includes('reverseSort');

      // Toggle the reverseSort parameter in the URL
      if (reverseSort) {
        // Remove the reverseSort parameter
        currentUrl = currentUrl.replace(/[\?&]reverseSort=1/, '');
      } else {
        // Add the reverseSort parameter
        currentUrl += currentUrl.includes('?') ? '&reverseSort=1' : '?reverseSort=1';
      }

      // Redirect to the updated URL
      window.location.href = currentUrl;
    }
  </script>
  <div>
    <table class="alluser4">
      <thead>
        <tr>
          <th> Item</th>
          <th>QTY</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($items->getItemDesNew() as $item) {
          // Get the name of the item
          $itemName = $item['name'];

          // Query the database to get the sum of damaged items for the current item
          $damagedSum = 0; // Initialize the sum
          $damagedItems = $request->getDamagedItems($itemName); // Replace with your actual database query
        
          // Calculate the sum of damaged items
          foreach ($damagedItems as $damagedItem) {
            $damagedSum += $damagedItem['damaged']; // Assuming 'damaged' is the column name
          }

          // Output the item name and the sum of damaged items
          echo "<tr>";
          echo "<td>$itemName</td>";
          echo "<td>$damagedSum</td>"; // Output the sum of damaged items
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</body>

</html>