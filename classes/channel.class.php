<?php 
    Class Channel extends Dbh {

        //Get all media channels.
        protected function getNonPublishedChannels($articleID) {
            $sql = "SELECT row_id, name, type FROM channel WHERE NOT EXISTS (
            SELECT NULL
            FROM articlechannel
            WHERE articlechannel.channel_id = channel.row_id AND articlechannel.article_id=$articleID
            )";
            $result = $this->connect()->query($sql);
            return $result;
        }//getNonPublishedChannels.

        protected function getPublishedChannels($articleID) {
            $sql = "SELECT c.row_id AS c_row_id, c.name AS c_name, c.type AS c_type  FROM articlechannel ac
            LEFT JOIN channel c ON ac.channel_id=c.row_id
            WHERE ac.article_id=$articleID AND c.can_unpublish=1";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getPublishedChannels.

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
            $sql = "DELETE FROM channel WHERE row_id=$channelID AND type=2";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetchannel.

    }//Channel.
?>