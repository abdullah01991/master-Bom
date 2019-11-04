<?php
  $nav_selected = "REPORTS";
  $left_buttons = "YES";
  $left_selected = "REPORT";
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
      var sliceSelection = "";
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
        var appStatusDataSet = google.visualization.arrayToDataTable([
          
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
        var appStatusOptions = {
          title: 'Application Report',
          legend : 'none'
        };
        var chart = new google.visualization.PieChart(document.getElementById('appStatusChart'));
        chart.draw(appStatusDataSet, appStatusOptions);
        google.visualization.events.addListener(chart, "select", appStatusSelectHandler);
        function appStatusSelectHandler(){
          var selectedItem = chart.getSelection()[0];
          if(selectedItem){
            var sliceName = appStatusDataSet.getValue(selectedItem.row, 0);
          }
          $(document).ready(function(){
              $("#selectionTable").load("loadChartTable.php",{
                targetChart:"app_status",
                targetSliceName: sliceName
              });
          });
          chart.setSelection();
        }
      }
      
      
      //Cmp Status code.
      function drawCmpStatusChart() {
        var cmpStatusDataSet = google.visualization.arrayToDataTable([
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($cmpStatusChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $cmpStatusChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $cmpStatusChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var cmpStatusOptions = {
          title: 'Component Status Report',
          legend : 'none'
        };
        var chart = new google.visualization.PieChart(document.getElementById('cmpStatusChart'));
        chart.draw(cmpStatusDataSet, cmpStatusOptions);
        google.visualization.events.addListener(chart, "select", cmpStatusSelectHandler);
        function cmpStatusSelectHandler(){
          var selectedItem = chart.getSelection()[0];
          if(selectedItem){
            var sliceName = cmpStatusDataSet.getValue(selectedItem.row, 0);
          }
          
          $(document).ready(function(){
              $("#selectionTable").load("loadChartTable.php",{
                targetChart:"cmp_status",
                targetSliceName: sliceName
              });
          });
          chart.setSelection();
        }
      }
        // Request Status code.
      function drawRequestStatusChart() {
        var requestStatusDataSet = google.visualization.arrayToDataTable([
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($requestStatusChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $requestStatusChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $requestStatusChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var requestStatusOptions = {
          title: 'Request Status Report',
          legend : 'none'
        };
        var chart = new google.visualization.PieChart(document.getElementById('requestStatusChart'));
        chart.draw(requestStatusDataSet, requestStatusOptions);
        google.visualization.events.addListener(chart, "select", requestStatusSelectHandler);
        function requestStatusSelectHandler(){
          var selectedItem = chart.getSelection()[0];
          if(selectedItem){
            var sliceName = requestStatusDataSet.getValue(selectedItem.row, 0);
          }
          $(document).ready(function(){
              $("#selectionTable").load("loadChartTable.php",{
                targetChart:"request_status",
                targetSliceName: sliceName
              });
          });
          chart.setSelection();
        }
      }
      // Request Step code.
      function drawRequestStepStatusChart() {
        var requestStepDataSet = google.visualization.arrayToDataTable([
          ['Key', 'Value'],
          <?php
            $arrayKeys = array_keys($requestStepChartData);
            // Had to pull out the and put into an array so I could use a for loop. This was so I could itentify the
            // last item and remove to comma. Doesn't work otherwise.
            for($i = 0; $i < count($arrayKeys); $i++){
              if($i == count($arrayKeys) - 1){
                echo "['" . $arrayKeys[$i] . "'," . $requestStepChartData[$arrayKeys[$i]] . "]";
              } else {
                echo "['" . $arrayKeys[$i] . "'," . $requestStepChartData[$arrayKeys[$i]] . "],";
              }
            }
          ?>
        ]);
        var requestStepOptions = {
          title: 'Request Step Report',
          legend : 'none'
        };
        var chart = new google.visualization.PieChart(document.getElementById('requestStepChart'));
        chart.draw(requestStepDataSet, requestStepOptions);
        google.visualization.events.addListener(chart, "select", requestStepSelectHandler);
        function requestStepSelectHandler(){
          var selectedItem = chart.getSelection()[0];
          if(selectedItem){
            var sliceName = requestStepDataSet.getValue(selectedItem.row, 0);
          }
          $(document).ready(function(){
              $("#selectionTable").load("loadChartTable.php",{
                targetChart:"request_step",
                targetSliceName: sliceName
              });
          });
          chart.setSelection();
        }
      }
</script>

</head>
  <div class="container-fluid">
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="#">BOM Reports</a>
          </li>
        </ul>
      </nav>
    </div>
    <div id="bomCharts">
      <div  class="row">
        <div id="appStatusChart" class="col-lg-6" style="width: 50%; height: 300px;"></div>
        <div id="cmpStatusChart" class="col-lg-6" style="width: 50%; height: 300px;"></div>
      </div>
      <div class="row">
        <div id="requestStatusChart" class="col-lg-6" style="width: 50%; height: 300px;"></div>
        <div id="requestStepChart" class="col-lg-6" style="width: 50%; height: 300px;"></div>
    </div>
    <div id="selectionTable"></div>
    </div>
  </div>

<?php
  include("./footer.php");
?>

<script>
  $(".sidebar").click(function(){
    $("#bomCharts").toggle();
  });
</script>
