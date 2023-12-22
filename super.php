<?php
include_once('includes/classes/Account.php');
include_once('includes/classes/Area.php');
include_once('includes/classes/Request.php');
include_once('includes/classes/Powers.php');
include_once('includes/classes/FormSanitizer.php');

$request = new Request($con);
$Area = new Area($con);

$filter = @$_POST["month"] ?? date('Y-m');
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

<body>

  <!--------------------------------Dashboard-------------------------------------->


  <section>
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
          echo "
            <tr>
          <td>";
          echo $area['name'] . "</td>
          <td>";
          echo $request->getRequestNum($area['name'], "qtyBackStatus = 'finish'") . "</td>
          <td>";
          echo $request->getRequestNum($area['name'], "qtyBackStatus != 'finish'") . "</td>
            </tr>
          ";
          // echo "<td>" . $area['name'] . "</td>";
        }
        ?>
      </tbody>
    </table>
  </section>

 
  <section>
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
        <tr>
        <td>20230001</td>
        <td>20230001</td>
        <td>20230001</td>
        <td>20230001</td>
        </tr>
        
      </tablel>
      </section>
  
    <section class="sectiondas">
      <label class="" for=""></label>
      <table class="alluser">
        <form action="" method="POST">
          <input type="month" id="month" name="month" value=<?php echo $filter; ?>>
          <input class="" type="submit" value="filter">
        </form>
        <tr>
          <th>Area</th>
          <th>Orders</th>
        </tr>
        <tbody>
          <?php
          foreach ($Area->getArea(true) as $area) {
            echo "
            <tr>
          <td>";
            echo $area['name'] . "</td>
          <td>";
            echo $request->getRequestNum($area['name'], null, $filter) . "
          </tr>
          ";
            // echo "<td>" . $area['name'] . "</td>";
          }
       
          ?>
        </tbody>
      
      </table>
    </section>


  


</body>

</html>