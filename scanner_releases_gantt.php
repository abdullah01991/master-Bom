<?php

  $nav_selected = "SCANNER"; 
  $left_buttons = "YES"; 
  $left_selected = "RELEASESGANTT"; 

  include("./nav.php");
  global $db;

  ?>
<!DOCTYPE HTML>
<html>
<head>


<div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Scanner -> System Releases Gantt</h3>
         <h3><img src="images/releases_gantt.png" style="max-height: 35px;" />System Releases Gantt</h3>
         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
         <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);
 function drawChart() {
        
        TODO: Gantt Chart Code
        <?php

$sql = "SELECT * from releases ORDER BY id ASC, ORDER BY open_date ASC, ORDER BY rtm_date ASC;";
$result = $db->query($sql);       

                if ($result->num_rows > 0) {
                  // output data of each row
                 while($row = $result->fetch_assoc()) {
                     echo '<tr>
                              <td>'.$row["id"].'</td>
                              <td>'.$row["name"].' </span> </td>
                              <td>'.$row["type"].'</td>
                              <td>'.$row["status"].'</td>
                              <td>'.$row["open_date"].' </span> </td>
                              <td>'.$row["dependency_date"].'</td>
                              <td>'.$row["freeze_date"].'</td>
                              <td>'.$row["rtm_date"].' </span> </td>
                              <td>'.$row["manager"].' </span> </td>
                              <td>'.$row["author"].' </span> </td>
                              <td>'.$row["app_id"].' </span> </td>
                          </tr>';
                  }//end while
              }//end if
              else {
                  echo "0 results";
                }//end else

                  $result->close();
                ?>
 var data = google.visualization.arrayToDataTable([

 ]);

  var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

  var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
 chart.draw(data,options);
 }
  </script>



  <?php include("./footer.php"); ?>

  
</head>
<body>
 <div class="container-fluid">
 <div id="chart_div"></div>
 </div>
 
</body>
</html>
