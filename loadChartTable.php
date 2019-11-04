<?php
    require_once('database.php');
  
    $db = db_connect();
    $errors = array();
    $config = array();
    $chart = $_POST["targetChart"];
    $slice = $_POST["targetSliceName"];
    $dbTableName = "sbom";
    // Populate table headers.
    $sql = "SHOW columns FROM " . $dbTableName . ";";
    $result = $db->query($sql);
    echo "<table class='table table-bordered'>";
    if($result->num_rows > 0){
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        while($row = $result->fetch_assoc()){
            
            echo "<th scope='col'>" . $row['Field'] . "</th>";
            
        }
        echo "</tr>";
        echo "</thead>";
    }
    // Populate table body.
    $sql = "SELECT * FROM sbom WHERE " . $chart . " = '" . $slice . "';";
    $result = $db->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr scope='row'>";
            foreach($row as $rowItem){
                echo "<td>" . $rowItem . "</td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
    
    mysqli_close($db);
?>
