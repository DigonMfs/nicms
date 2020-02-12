<?php 
    //no connection with the database necessary,because 
    //this page is included in categories.php

    //Check if connection is set
    if ($conn) {
        
        //Select all categories
        $sql = " SELECT * FROM category WHERE parent_id = 0";
        $result = $conn->query($sql);
        
        //go through all the records
        if ($result->num_rows > 0) {     
            while($row = $result->fetch_assoc()) {
                
                //Show all the categories
                echo $row['category']."<br>";
                
                //Select all the subcategories of the category
                $sql2 = " SELECT * FROM category WHERE parent_id =".$row["row_id"];
                $result2 = $conn->query($sql2);
                
                //Go through all the records
                 if ($result2->num_rows > 0) {     
                    while($row2 = $result2->fetch_assoc()) {
                        //Show the subcategories on the screen
                        echo "--".$row2['category']."<br>";
                    }//while
                 }//if 
            }//while
            
        } else {
            echo "0 results";
        }//if
        
    } else {
        echo "<p class='alert alert-danger' role='alert'>No connection with the database</p>";
        die();
    }//if $connection

?>