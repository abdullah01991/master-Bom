<?php
  $nav_selected = "REPORTS";
  $left_buttons = "NO";
  $left_selected = "";
  include("./nav.php");
  $appStatusChartData = array();
  $cmpStatusChartData = array();
  $requestStatusChartData = array();
  $requestStepChartData = array();
  
  // Query the sbom table and add appropriate data to each of the data arrays.
  $sql = "SELECT * from sbom;";
  $result = $db->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      // Populate the app_status data.
      if(!array_key_exists($row["app_status"],$appStatusChartData)){
        $appStatusChartData += array($row["app_status"] => 1);
      } else {
        $appStatusChartData[$row["app_status"]] += 1;
      }
      // Populate the cmp_status data.
      if(!array_key_exists($row["cmp_status"],$cmpStatusChartData)){
        $cmpStatusChartData += array($row["cmp_status"] => 1);
      } else {
        $cmpStatusChartData[$row["cmp_status"]] += 1;
      }
      // Populate the request_status data.
      if(!array_key_exists($row["request_status"],$requestStatusChartData)){
        $requestStatusChartData += array($row["request_status"] => 1);
      } else {
        $requestStatusChartData[$row["request_status"]] += 1;
      }
      // Populate the request_step data.
      if(!array_key_exists($row["request_step"],$requestStepChartData)){
        $requestStepChartData += array($row["request_step"] => 1);
      } else {
        $requestStepChartData[$row["request_step"]] += 1;
      }
    }
  }
?>

<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(
        function(){
          drawAppStatusChart();
          drawCmpStatusChart();
          drawRequestStatusChart();
          drawRequestStepStatusChart();
        }
      );
      
      //Chart one code.
      function drawAppStatusChart() {
        var dataSetOne = google.visualization.arrayToDataTable([
          
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($appStatusChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var optionsSetOne = {
          title: 'Application Report',
          legend : 'none'
        };
        var chartOne = new google.visualization.PieChart(document.getElementById('piechartOne'));
        chartOne.draw(dataSetOne, optionsSetOne);
      }
      
      //Chart two code.
      function drawCmpStatusChart() {
        var dataSetTwo = google.visualization.arrayToDataTable([
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($appStatusChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var optionsSetTwo = {
          title: 'Component Report',
          legend : 'none'
        };
        var chartTwo = new google.visualization.PieChart(document.getElementById('piechartTwo'));
        chartTwo.draw(dataSetTwo, optionsSetTwo);
      }
        //Chart three code.
      function drawRequestStatusChart() {
        var dataSetThree = google.visualization.arrayToDataTable([
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($appStatusChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var optionsSetThree = {
          title: 'Request Report',
          legend : 'none'
        };
        var chartThree = new google.visualization.PieChart(document.getElementById('piechartThree'));
        chartThree.draw(dataSetThree, optionsSetThree);
      }
      //Chart four code.
      function drawRequestStepStatusChart() {
        var dataSetFour = google.visualization.arrayToDataTable([
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($appStatusChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $appStatusChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var optionsSetFour = {
          title: 'Request Step Report',
          legend : 'none'
        };
        var chartFour = new google.visualization.PieChart(document.getElementById('piechartFour'));
        chartFour.draw(dataSetFour, optionsSetFour);
      }    
</script>

</head>

  <div class="container">
    <div  class="row">
      <div id="piechartOne" class="col-lg-6" style="width: 50%; height: 300px;"></div>
      <div id="piechartTwo" class="col-lg-6" style="width: 50%; height: 300px;"></div>
    </div>
    <div class="row">
      <div id="piechartThree" class="col-lg-6" style="width: 50%; height: 300px;"></div>
      <div id="piechartFour" class="col-lg-6" style="width: 50%; height: 300px;"></div>
    </div>
    <div class="row">
      <div id="tableData" class="col-lg-12">
        
      </div>
    </div>
    

  </div>


<?php include("./footer.php"); ?>
