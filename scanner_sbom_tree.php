<?php
  $nav_selected = "SCANNER";
  $left_buttons = "YES";
  $left_selected = "SBOMTREE";
  global $db;
  global $pid;
  
  include("./nav.php");
  
 ?>

 <div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Scanner --> BOM Tree</h3>
      <h3><img src="images/sbom_tree.png" style="max-height: 35px;" />System Software BOM</h3>

      <button id="expandAll">Expand All</button>
      <button id="collapseAll">Collapse All</button> 

      <table id="sbomTable" cellpadding="0" cellspacing="0" border="0"
            class="datatable table table-bordered datatable-style table-hover"
            width="100%" style="width: 100px;">
              <thead>
                <tr id="table-first-row">
                        <th>Sbom Tree</th>
                        <th>App ID</th>
                        <th>App Name</th>
                        <th>App Version</th>
                        <th>CMP ID</th>
                        <th>CMP Name</th>
                        <th>CMP Version</th>
                        <th>CMP Type</th>
                        <th>App Status</th>
                        <th>CMP Status</th>
                        <th>Request ID</th>
                        <th>Request Date</th>
                        <th>Request Status</th>
                        <th>Request Step</th>
                        <th>Notes</th>
                </tr>
              </thead>
      <?php
      $count = 0;
      $cmpArray = array();
      $appArray = array();
      $nodeArray = array();
      $appQuery = "SELECT * from sbom ORDER BY row_id ASC;";
        $appRes = $db->query($appQuery);
        if ($appRes->num_rows > 0) {
          while($row = $appRes->fetch_assoc()) {
            if($pid != $row["app_id"]){
              $count = 0;
              $pid = $row["app_id"];
            }
            $nodeArray[$row["app_id"].$count] = 
            '<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
            <td>'.$row["cmp_name"].' '.$row["cmp_version"].'</td>
            <td>'.$row["app_id"].' </span> </td>
            <td>'.$row["app_name"].' </span> </td>
            <td>'.$row["app_version"].' </span> </td>
            <td>'.$row["cmp_id"].' </span> </td>
            <td>'.$row["cmp_name"].' </span> </td>
            <td>'.$row["cmp_version"].' </span> </td>
            <td>'.$row["cmp_type"].' </span> </td>
            <td>'.$row["app_status"].' </span> </td>
            <td>'.$row["cmp_status"].' </span> </td>
            <td>'.$row["request_id"].' </span> </td>
            <td>'.$row["request_date"].' </span> </td>
            <td>'.$row["request_status"].' </span> </td>
            <td>'.$row["request_step"].' </span> </td>
            <td>'.$row["notes"].' </span> </td>
            </tr>';
            array_push($appArray,$row["app_id"]);
            array_push($cmpArray,$row["cmp_id"]);
            $count++;
          }
        }
        else {
          echo "0 results";
        }//end else
      $appRes->close();
      
      $sql =  "SELECT app_id,app_name,app_version,cmp_id,cmp_name,cmp_status,cmp_type,app_status,notes,cmp_version FROM sbom ORDER BY app_id,app_name,app_version,cmp_id,cmp_name,cmp_version ASC;";
      //$sql =  "SELECT * FROM sbom ORDER BY row_id ASC;";
          $result = $db->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
              while($row = $result->fetch_assoc()) {
                if($pid != $row["app_id"] && !in_array($row["app_id"],$cmpArray)){ //creates a new app node if the app_id is not a component
                  echo '<tr data-tt-id="'.$row["app_id"].'">
                          <td>'.$row["app_name"].' '.$row["app_version"].'</td>
                          <td>'.$row["cmp_status"].' </span> </td>
                          <td>'.$row["cmp_type"].' </span> </td>
                          <td>'.$row["app_status"].' </span> </td>
                          <td>'.$row["notes"].' </span> </td></tr>';       
                  $pid = $row["app_id"];
                }
                if(in_array($row["cmp_id"],$appArray)){ //if the component is a child application,
                                                        // it pulls the child components of that application
                  echo'<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
                      <td>'.$row["cmp_name"].' '.$row["cmp_version"].'</td>
                      <td>'.$row["cmp_status"].' </span> </td>
                      <td>'.$row["cmp_type"].' </span> </td>
                      <td>'.$row["app_status"].' </span> </td>
                      <td>'.$row["notes"].' </span> </td></tr>';
                  $count = 0;
                  while(array_key_exists($row["cmp_id"].$count,$nodeArray)){
                    echo $nodeArray[$row["cmp_id"].$count];
                    $count++;
                  }
                }elseif(!in_array($row["app_id"],$cmpArray)){ //if the component is not also an application and it's also not a 
                                                              //component of a child application, it's set as a child of it's application
                  echo'<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
                      <td>'.$row["cmp_name"].' '.$row["cmp_version"].'</td>
                      <td>'.$row["cmp_status"].' </span> </td>
                      <td>'.$row["cmp_type"].' </span> </td>
                      <td>'.$row["app_status"].' </span> </td>
                      <td>'.$row["notes"].' </span> </td></tr>';
                }
                  
              }//end while
          }//end if
          else {
              echo "0 results";
          }//end else
       $result->close();
      ?>

      </table>

    </div>
</div>

<link href="jquery.treetable.css" rel="stylesheet" type="text/css" />
<link href="jquery.treetable.theme.default.css" rel="stylesheet" type="text/css" />
<script src="jquery.treetable.js"></script>

<script>
var tree = $("#sbomTable").treetable({expandable: true, initialState: "collapsed"});
$("#expandAll").click(function() {
   tree.treetable('destroy');
   tree.find(".indenter").remove();
   tree.treetable({expandable: true, initialState: "expanded"});
});
$("#collapseAll").click(function() {
   tree.treetable('destroy');
   tree.find(".indenter").remove();
   tree.treetable({expandable: true, initialState: "collapsed"});
});
</script>

<?php include("./footer.php"); ?>
