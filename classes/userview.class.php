<?php 
    class UserView extends User
    {
        public function showUsers() {

            $result = $this->getUsers();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    //Display data.
                    echo "<tr>";
                    echo "<th scope='row'>".$row["row_id"]."</th>";
                    echo "<td>".$row["username"]."</td>";
                    echo "<td>".$row["display_name"]."</td>";
                    echo "<td>";
                    echo "**********";
                    echo "</td>";

                    //Check if user is admin or moderator to show the correct badge.
                    if ($row["function"] == 1) {
                        echo "<td><span class='badge-danger badge'>Admin</span></td>";
                    } else {
                        echo "<td><span class='badge-success badge'>Moderator</span></td>";
                    }
                    echo "</tr>";
                }
            }

        }//Method Users.
    }
    
?>