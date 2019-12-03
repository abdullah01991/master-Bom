<?php
    require_once('database.php');
  
    $db = db_connect();
    $errors = array();
    $config = array();
    $chart;
    $slice;
    if(isset($_POST["targetChart"])){
        $chart = $_POST["targetChart"];
    }
    
    if(isset($_POST["targetSliceName"])){
        $slice = $_POST["targetSliceName"];
    }
    
    $dbTableName = "sbom";
    if(isset($_POST["targetChart"]))
    if($chart == "app_status"){
        echo "<table id='info' class='table table-bordered table-hover'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'>app_name</th>";
                    echo "<th scope='col'>app_version</th>";
                    echo "<th scope='col'>app_status</th>";
                echo "</tr>";
            echo "</thead>";
    } elseif($chart == "cmp_status"){
        echo "<table id='info' class='table table-bordered table-hover'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'>cmp_name</th>";
                    echo "<th scope='col'>cmp_version</th>";
                    echo "<th scope='col'>cmp_status</th>";
                    echo "<th scope='col'>cmp_type</th>";
                echo "</tr>";
            echo "</thead>";
    } elseif($chart == "request_status"){
        $sql = "SHOW columns FROM " . $dbTableName . ";";
        $result = $db->query($sql);
        echo "<table id='info' class='table table-bordered table-hover'>";
        if($result->num_rows > 0){
            echo "<thead>";
            echo "<tr>";
            while($row = $result->fetch_assoc()){
                
                echo "<th scope='col'>" . $row['Field'] . "</th>";
                
            }
            echo "</tr>";
            echo "</thead>";
        }
    } elseif($chart == "request_step"){
        $sql = "SHOW columns FROM " . $dbTableName . ";";
        $result = $db->query($sql);
        echo "<table id='info' class='table table-bordered table-hover'>";
        if($result->num_rows > 0){
            echo "<thead>";
            echo "<tr>";
            while($row = $result->fetch_assoc()){
                
                echo "<th scope='col'>" . $row['Field'] . "</th>";
                
            }
            echo "</tr>";
            echo "</thead>";
        }
    }
    /*
    // Old implementation
    // Populate table headers.
    $sql = "SHOW columns FROM " . $dbTableName . ";";
    $result = $db->query($sql);
    echo "<table id='info' class='table table-bordered table-hover'>";
    if($result->num_rows > 0){
        echo "<thead>";
        echo "<tr>";
        while($row = $result->fetch_assoc()){
            
            echo "<th scope='col'>" . $row['Field'] . "</th>";
            
        }
        echo "</tr>";
        echo "</thead>";
    }
    */
    // Populate table body.
    if(isset($_POST["targetChart"])){
    if(isset($chart)) {
        if($chart == "app_status"){
            $sql = "SELECT app_name, app_version, app_status FROM sbom WHERE " . $chart . " = '" . $slice . "';";
        } elseif($chart == "cmp_status"){
            $sql = "SELECT cmp_name, cmp_version, cmp_status, cmp_type FROM sbom WHERE " . $chart . " = '" . $slice . "';";
        } elseif($chart == "request_status"){
            $sql = "SELECT * FROM sbom WHERE " . $chart . " = '" . $slice . "';";
        } elseif($chart == "request_step"){
            $sql = "SELECT * FROM sbom WHERE " . $chart . " = '" . $slice . "';";
        }
    } else {
        if($chart == "app_status"){
            $sql = "SELECT app_name, app_version, app_status FROM sbom;";
        } elseif($chart == "cmp_status"){
            $sql = "SELECT cmp_name, cmp_version, cmp_status, cmp_type FROM sbom;";
        } elseif($chart == "request_status"){
            $sql = "SELECT * FROM sbom;";
        } elseif($chart == "request_step"){
            $sql = "SELECT * FROM sbom;";
        }
    }
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
}
?>

<script type="text/javascript" language="javascript">
    $(document).ready( function () {
        
        $('#info').DataTable( {
            dom: 'lfrtBip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ] }
        );
        $('#info thead tr').clone(true).appendTo( '#info thead' );
        $('#info thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    
        var table = $('#info').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            retrieve: true
        } );
        
    } );
</script>
