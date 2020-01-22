<?php 
    //Select data from the database
    $sql = "SELECT row_id, name FROM channel";
    $result = $conn->query($sql);
    
    //Get data and show it on the screen
    if ($result->num_rows > 0) {
        
        // output data of each row
        while($row = $result->fetch_assoc()) {
            
            echo '
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="'.$row["name"].'">
                    <label class="custom-control-label" for="'.$row["name"].'">'.$row["name"].'</label>
                </div>
            ';
            
        }//while
        
    }//if
?>