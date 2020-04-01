<?php 
    Class ChannelView extends channel{
         //Show all media channels.
         public function showMediaChannels() {
            //Execute sql.
            $result = $this->getMediaChannels();
            if ($result->num_rows > 0) {
                echo "<tr>";
                echo " <th>#</th>";
                echo "<th>Channel</th>";
                echo "<th>unpublish</th>";
                echo "<th>Type</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['row_id']."</td>";
                    echo "<td>".$row['name']."</td>";

                    if ($row["can_unpublish"] == 1)
                        echo "<td><span class='badge badge-success'>Yes</span></td>";
                    else
                        echo "<td><span class='badge badge-danger'>No</span></td>";
                    
                    if ($row['type'] == 0) 
                        echo " <td><span class='badge badge-warning'>Other</span></td>";
                    else if ($row['type'] == 1)
                        echo " <td><span class='badge badge-primary'>Social Media</span></td>";
                    else 
                        echo " <td><span class='badge badge-danger'>RSS</span></td>";

                    echo " <td><button class='btn btn-danger btn-sm' onclick='askDeleteChannel(".$row["row_id"].")'>Delete</button></td>";
                    echo "</tr>";
                }
               
            }
        }//showMediaChannels.

    }//ChannelView.
?>