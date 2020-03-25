<?php 
    //Category Class.
    class WriteView extends Write {

        //Show all media channels.
        public function showMediaChannels() {
            //Execute sql.
            $result = $this->getMediaChannels();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="custom-control custom-checkbox">';
                    echo '<input type="checkbox" class="custom-control-input" id="'.$row["name"].'">';
                    echo '<label class="custom-control-label" for="'.$row["name"].'">'.$row["name"].'</label>';
                    echo '</div>';
                }
            }
        }//showMediaChannels.

    }//Class WriteView.

?>