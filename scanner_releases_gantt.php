<?php
  $nav_selected = "SCANNER"; 
  $left_buttons = "YES"; 
  $left_selected = "RELEASESLIST"; 
  $date = "open_date";
  include("./nav.php");
  global $db;
  // This section holds logic associated with preferences. A query which returns a result will set $getPreferences to true and populate the appropriate variables.
  $getPreferences = "SELECT preference, value FROM preferences;";
  $result = $db->query($getPreferences);
  if ($result->num_rows > 0){
    $hasPreferences = true;
    while($row = $result->fetch_assoc()){
      switch($row["preference"]){
        case "min_date":
        $min_date = $row["value"];
        break;
        case "max_date":
        $max_date = $row["value"];
        break;
        case "release_status":
        $status = $row["value"];
        break;
        case "release_type":
        $type = $row["value"];
        break;
      }
    }
  }
  if($min_date == "" && $max_date == "" && $status == "" && $type == ""){
    $hasPreferences = false;
  }
   else {
    $hasPreferences = false;
  }
  $result->close();
  ?>


<div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Scanner -> System Releases Gantt</h3>

        <h3><img src="images/gantt.png" style="max-height: 35px;" />System Releases</h3>





<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');
      data.addRows([
         <?php
//Added if statement to run the appropriate query based on whether the $hasPreferences variable is true or false.
if($hasPreferences) {
  $sql = "SELECT id,name,type,DATE_FORMAT($date,'%Y,%m,%e') AS start_d,DATE_FORMAT(rtm_date, '%Y,%m,%e') AS end_d,(rtm_date)-($date) AS duration from releases WHERE $date > '$min_date' AND $date < '$max_date' AND status = '$status' AND type = '$type' ORDER BY $date ASC;";
} else {
  $sql = "SELECT id,name,type,DATE_FORMAT($date,'%Y,%m,%e') AS start_d,DATE_FORMAT(rtm_date, '%Y,%m,%e') AS end_d,(rtm_date)-($date) AS duration from releases ORDER BY $date ASC;";
}
$result = $db->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '["'.$row["id"].'","'
                                 .$row["name"].'","'
                                 .$row["type"].'", new Date('
                                 .$row["start_d"].'), new Date('
                                 .$row["end_d"].'),'
                                 .$row["duration"].',null,null],';
                    }//end while
                }//end if
                else {
                    echo "0 results";
                }//end else
                 $result->close();
                ?>
      ]);
      var options = {
        height:800,
        gantt: {
          trackHeight: 30
        }
      };
      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="chart_div"></div>
</body>
</html>
