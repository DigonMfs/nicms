<?php 
    Class Channel extends Dbh {

        //Get all media channels.
        protected function getMediaChannels() {
            $sql = "SELECT * FROM channel";
            $result = $this->connect()->query($sql);
            return $result;
        }//GetMediaChannels.

        protected function setChannel($name,$canUnpublish,$type) {
            $sql = "INSERT INTO channel (name, can_unpublish, type)
            VALUES ('$name', '$canUnpublish', '$type')";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method setChannel.

        protected function unSetChannel($channelID) {
            $sql = "DELETE FROM channel WHERE row_id=$channelID";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetchannel.

    }//Channel.
?>