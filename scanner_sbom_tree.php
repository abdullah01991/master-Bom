<?php
  $nav_selected = "SCANNER";
  $left_buttons = "YES";
  $left_selected = "SBOMTREE";
  $blank = "<td> </span> </td>";
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
      <button id="noColor">Color / No Color</button>
      <button id="showRed">Show Red</button>
      <button id="showYellow">Show Yellow</button>
      <button id="showRedYellow">Show Red & Yellow</button>
      <button id="showOutOfSync">Show Out of Sync</button>
      <input type="text" id="whereUsedTextInput" placeholder="e.g. Bingo;2.4" />
      <button id="whereUsedSubmit">Where Used</button>

      <table id="sbomTable" cellpadding="0" cellspacing="0" border="0"
            class="datatable table table-bordered datatable-style "
            width="100%" >
              <thead>
                <div id="table-first-row"> 
                        <th style="width:200px"><strong>App Name</strong></th>
                        <th style="width:30px"><strong>Version</strong></th>
                        <th style="width:30px"><strong>Status</strong></th>
                        <th style="width:30px"><strong>CMP type</strong></th>
                        <th style="width:30px"><strong>Request Status</strong></th>
                        <th style="width:30px"><strong>Request Step</strong></th>
                        <th style="width:30px"><strong>Notes</th>
                </div>
              </thead>
      <?php
      //<th style="width:20px"><strong>App Version</strong></th>
      // <th style="width:30px"><strong>App Name</strong></th>
      //<th style="width:30px"><strong>CMP ID</strong></th>
      //<th style="width:30px"><strong>CMP Name</strong></th>
      //<th style="width:20px"><strong>CMP Version</strong></th>
      //<th style="width:30px"><strong>CMP ID</strong></th>
      //<th style="width:30px"><strong>CMP Name</strong></th>
      //<th style="width:20px"><strong>CMP Version</strong></th>
      $count = 0;
      $cmpArray = array();
      $appArray = array();
      $nodeArray = array();
      $nodeIDArray = array();
      $rootYellow = array();
      $rootRed = array();
      $nodeYellow = array();
      $Child = array();
      $nodes = array();
      $nodeIndex = array();
      $nodeRed = array();
      $appQuery = "SELECT * from sbom ORDER BY request_id ASC;";
        $appRes = $db->query($appQuery);
        $color = "#ecebf0";
        if ($appRes->num_rows > 0) {
          while($row = $appRes->fetch_assoc()) {
            if($pid != $row["app_id"]){
              $count = 0;
              $pid = $row["app_id"];
            }
            
            $nodeIDArray[$row["app_id"].$count] =
            '<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'';
            $nodeArray[$row["app_id"].$count] = 
            '">
            <td class="green" bgcolor = "#57c95c">'.$row["cmp_name"].' </td>
            <td>'.$row["cmp_version"].' </span> </td>
            <td>'.$row["cmp_status"].' </span> </td>
            <td>'.$row["cmp_type"].' </span> </td>
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
      
      $sql =  "SELECT * FROM sbom ORDER BY app_id,app_name,app_version,cmp_id,cmp_name,cmp_version ASC;";
      //$sql =  "SELECT * FROM sbom ORDER BY request_id ASC;";
          $result = $db->query($sql);
	  $color = "#ecebf0";
          if ($result->num_rows > 0) {
          // output data of each row
              while($row = $result->fetch_assoc()) {
                if($pid != $row["app_id"] && !in_array($row["app_id"],$cmpArray)){ //creates a new app node (root) if the app_id is not a component
                  array_push($rootRed, $row["app_id"]);
                  echo '<tr data-tt-id="'.$row["app_id"].'">
                          <td class="red" bgcolor = "#ff6666">'.$row["app_name"].' </td>
                          <td>'.$row["app_version"].' </span> </td>
                          <td>'.$row["app_status"].' </span> </td>'.
                          $blank.
                          '<td>'.$row["request_status"].' </span> </td>
                          <td>'.$row["request_step"].' </span> </td>
                          <td>'.$row["notes"].' </span> </td>
                          </tr>';    
                          //for storing red node data
                  array_push($nodes,'<tr data-tt-id="'.$row["app_id"].'">
                          <td class="red" bgcolor = "#ff6666">'.$row["app_name"].' </td>
                          <td>'.$row["app_version"].' </span> </td>
                          <td>'.$row["app_status"].' </span> </td>'.
                          $blank.
                          '<td>'.$row["request_status"].' </span> </td>
                          <td>'.$row["request_step"].' </span> </td>
                          <td>'.$row["notes"].' </span> </td>
                          </tr>');
                  $pid = $row["app_id"];
                }
                if(in_array($row["cmp_id"],$appArray)){ //if the component is a child application,
                                                        // it pulls the child components of that application
                  
                  array_push($nodeIndex,$row["app_id"]);
                  echo'<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
                      <td class="yellow" bgcolor = "#f5fa69">'.$row["cmp_name"].' </td>
                      <td>'.$row["cmp_version"].' </span> </td>
                      <td>'.$row["cmp_status"].' </span> </td>
                      <td>'.$row["cmp_type"].' </span> </td>
                      <td>'.$row["request_status"].' </span> </td>
                      <td>'.$row["request_step"].' </span> </td>
                      <td>'.$row["notes"].' </span> </td>
                      </tr>';
                  $count = 0;
                  while(array_key_exists($row["cmp_id"].$count,$nodeArray)){
                    echo $nodeIDArray[$row["cmp_id"].$count].$nodeArray[$row["cmp_id"].$count];
                    $count++;
                  }
                  //for root yellow
                  array_push($rootYellow, $row["cmp_id"].'root');
                  $nodeYellow[$row["cmp_id"].'root']='<tr data-tt-id="'.$row["cmp_id"].'root">
                      <td class="yellow" bgcolor = "#f5fa69">'.$row["cmp_name"].' </td>
                      <td>'.$row["cmp_version"].' </span> </td>
                      <td>'.$row["cmp_status"].' </span> </td>
                      <td>'.$row["cmp_type"].' </span> </td>
                      <td>'.$row["request_status"].' </span> </td>
                      <td>'.$row["request_step"].' </span> </td>
                      <td>'.$row["notes"].' </span> </td>
                      </tr>';
                  $count = 0;
                  while(array_key_exists($row["cmp_id"].$count,$nodeArray)){
                    $Child[$row["cmp_id"].'root'.$count] = $nodeIDArray[$row["cmp_id"].$count]."root".$nodeArray[$row["cmp_id"].$count];
                    $count++;
                  }
                  //for storing red node data
                  array_push($nodes, '<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
                  <td class="yellow" bgcolor = "#f5fa69">'.$row["cmp_name"].' </td>
                  <td>'.$row["cmp_version"].' </span> </td>
                  <td>'.$row["cmp_status"].' </span> </td>
                  <td>'.$row["cmp_type"].' </span> </td>
                  <td>'.$row["request_status"].' </span> </td>
                  <td>'.$row["request_step"].' </span> </td>
                  <td>'.$row["notes"].' </span> </td>
                  </tr>');
                  $count = 0;
                  while(array_key_exists($row["cmp_id"].$count,$nodeArray)){
                    array_push($nodes, $nodeIDArray[$row["cmp_id"].$count].$nodeArray[$row["cmp_id"].$count]);
                    $count++;
                  }
                }elseif(!in_array($row["app_id"],$cmpArray)){ //if the component is not also an application and it's also not a 
                                                              //component of a child application, it's set as a child of it's application
                  echo'<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
                      <td class="green" bgcolor = "#57c95c">'.$row["cmp_name"].' </td>
                      <td>'.$row["cmp_version"].' </span> </td>
                      <td>'.$row["cmp_status"].' </span> </td>
                      <td>'.$row["cmp_type"].' </span> </td>
                      <td>'.$row["request_status"].' </span> </td>
                      <td>'.$row["request_step"].' </span> </td>
                      <td>'.$row["notes"].' </span> </td>
                      </tr>';
                      //for storing red node data
                  array_push($nodes, '<tr data-tt-id="'.$row["cmp_id"].'" data-tt-parent-id="'.$row["app_id"].'">
                      <td class="green" bgcolor = "#57c95c">'.$row["cmp_name"].' </td>
                      <td>'.$row["cmp_version"].' </span> </td>
                      <td>'.$row["cmp_status"].' </span> </td>
                      <td>'.$row["cmp_type"].' </span> </td>
                      <td>'.$row["request_status"].' </span> </td>
                      <td>'.$row["request_step"].' </span> </td>
                      <td>'.$row["notes"].' </span> </td>
                      </tr>');
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
$(document).ready(function(){
  $('#info').DataTable( {
            dom: 'lfrtBip'}
        );
  $("#whereUsedTextInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#sbomTable td").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});
// $(document).ready(function(){
//   $("#whereUsedTextInput").on("keyup", function() {
//     var input, filter, table, tr, td, i, txtValue;
//     input = $("#whereUsedTextInput").val().toLowerCase();;
//     filter = input.value.toUpperCase();
//     table = document.getElementById("sbomTable");
//     tr = table.getElementsByTagName("tr");
//     for (i = 0; i < tr.length; i++) {
//       td = tr[i].getElementsByTagName("td")[0];
//       if (td) {
//         txtValue = td.textContent || td.innerText;
//         if (txtValue.toUpperCase().indexOf(filter) > -1) {
//           tr[i].style.display = "";
//         } else {
//           tr[i].style.display = "none";
//         }
//       }       
//     }
//   }
// }
var color = 0;
var showY = 0;
var showR = 1;
var rootCount = 0;
var childCount = 0;
var rootIndex = <?php echo '["' . implode('", "', $nodeIndex) . '"]' ?>;
var nodes = <?php echo json_encode($nodes) ?>;
var rootRed = <?php echo '["' . implode('", "', $rootRed) . '"]' ?>;
var rootYellow = <?php echo '["' . implode('", "', $rootYellow) . '"]' ?>;
var nodeYellow = <?php echo json_encode($nodeYellow) ?>;
var nodeChild = <?php echo json_encode($Child) ?>;
var tree = $("#sbomTable").treetable({expandable: true, initialState: "collapsed"});
$("#expandAll").click(function(expand) {
   tree.treetable('destroy');
   tree.find(".indenter").remove();
   tree.treetable({expandable: true, initialState: "expanded"});
});
$("#collapseAll").click(function(collapse) {
   tree.treetable('destroy');
   tree.find(".indenter").remove();
   tree.treetable({expandable: true, initialState: "collapsed"});
});
$("#showOutOfSync").click(function(showOut){
    while(rootCount < 6){
      $("#sbomTable").treetable('removeNode',rootYellow[rootCount]); 
      rootCount++;
    }
});
$("#showYellow").click(function(showYellow){
  if(showR == 1){
    while(rootCount < rootRed.length){
      $("#sbomTable").treetable('removeNode',rootRed[rootCount]);
      rootCount++;
    }
    showR = 0;
  }
  rootCount = 0;
  if (showY == 0){
    while(rootCount < rootYellow.length){
      $("#sbomTable").treetable('loadBranch',null,nodeYellow[rootYellow[rootCount]]);
      var id =  "".concat(rootYellow[rootCount],childCount);
        while(id in nodeChild){
          $("#sbomTable").treetable('loadBranch',null,nodeChild[id]);
          childCount++;
          id =  "".concat(rootYellow[rootCount],childCount);
        } 
      childCount = 0;
      
      $("#sbomTable").treetable('expandNode',rootYellow[rootCount]);
      //$("#sbomTable").treetable('collapseNode',rootYellow[rootCount]);
      
      rootCount++;
    }
    tree.treetable('destroy');
    tree.find(".indenter").remove();
    tree.treetable({expandable: true, initialState: "collapsed"});
    showY = 1;
    
  }
  rootCount = 0;
})
$("#showRed").click(function(showRed){
  if (showY == 1){
    while(rootCount < rootYellow.length){
      $("#sbomTable").treetable('removeNode',rootYellow[rootCount]); 
      rootCount++;
    }
    showY = 0;
  }
  rootCount = 0;
  if(showR == 0){
    while(rootCount < nodes.length){
      
      $("#sbomTable").treetable('loadBranch',null,nodes[rootCount]);
      
      rootCount++;
    }
      for(index = 0; index < rootRed.length; index++){
        $("#sbomTable").treetable('expandNode',rootRed[index]);
        //$("#sbomTable").treetable('collapseNode',rootRed[index]);
      }
      tree.treetable('destroy');
      tree.find(".indenter").remove();
      tree.treetable({expandable: true, initialState: "collapsed"});
    
  }
  showR = 1;
  rootCount = 0;
  
});
//testing move function
$("#showRedYellow").click(function(showRandY){
  if (showY == 0){
    while(rootCount < rootYellow.length){
      $("#sbomTable").treetable('loadBranch',null,nodeYellow[rootYellow[rootCount]]);
      var id =  "".concat(rootYellow[rootCount],childCount);
        while(id in nodeChild){
          $("#sbomTable").treetable('loadBranch',null,nodeChild[id]);
          childCount++;
          id =  "".concat(rootYellow[rootCount],childCount);
        } 
      childCount = 0;
      $("#sbomTable").treetable('expandNode',rootYellow[rootCount]);
     // $("#sbomTable").treetable('collapseNode',rootYellow[rootCount]);
      
      rootCount++;
    }
    tree.treetable('destroy');
    tree.find(".indenter").remove();
    tree.treetable({expandable: true, initialState: "collapsed"});
    showY = 1;
    
  }
  rootCount = 0;
  if(showR == 0){
    var exists = "";
    while(rootCount < nodes.length){
      
      $("#sbomTable").treetable('loadBranch',null,nodes[rootCount]);
     // if(rootIndex[rootCount].length > 1){
     //   exists = rootIndex[rootCount];
     // }
     // if(rootIndex[(rootCount+1)].length > 1){
     //   $("#sbomTable").treetable('collapseNode',exists);
     //   $("#sbomTable").treetable('expandNode',exists);
     // }
      rootCount++;
    }
    for(index = 0; index < rootRed.length; index++){
        $("#sbomTable").treetable('expandNode',rootRed[index]);
       // $("#sbomTable").treetable('collapseNode',rootRed[index]);
    }
    tree.treetable('destroy');
    tree.find(".indenter").remove();
    tree.treetable({expandable: true, initialState: "collapsed"});
    showR = 1;
  }
  rootCount = 0;
});
$("#noColor").click(function(noColor){
  if (color == 0){
   $('.red').css('background-color', '#f8f7fa');
   $('.yellow').css('background-color', '#f8f7fa');
   $('.green').css('background-color', '#f8f7fa');
   color = 1 ; 
  }
  else {
   $('.red').css('background-color', '#ff6666');
   $('.yellow').css('background-color', '#f5fa69');
   $('.green').css('background-color', '#57c95c');
   color = 0;
  }
  
});
</script>

<script>
<?php include("./footer.php"); ?>
