<?php

  $nav_selected = "SCANNER"; 
  $left_buttons = "YES"; 
  $left_selected = "RELEASESGANTT"; 

  include("./nav.php");
  global $db;

  ?>


<div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Scanner -> System Releases Gantt</h3>
         <h3><img src="images/releases_gantt.png" style="max-height: 35px;" />System Releases Gantt</h3>
         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
        
        TODO: Gantt Chart Code

        

 <style>
   tfoot {
     display: table-header-group;
   }
 </style>

  <?php include("./footer.php"); ?>
