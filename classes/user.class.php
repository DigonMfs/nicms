<?php 
    //User.
    class User extends Dbh implements LinkUrl {

        protected function login($username,$password) {
            $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method login. 

        public function getUsers() {
            $sql = "SELECT * FROM user";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getUsers.

        public function insertUser($username,$displayname,$password) {
            $sql = "INSERT INTO user (username, password, display_name, function)
            VALUES ('$username', '$password', '$displayname','0')";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method inertUser.

        protected function getCurUser($userID,$password) {
            $sql = "SELECT * FROM user WHERE row_id=$userID AND password='$password'";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getUser.

        protected function reSetPassword($newPassword,$userID) {
            $sql = "UPDATE user SET password='$newPassword' WHERE row_id=$userID";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method reSetPassword.

        protected function reSetUsername($newUsername,$id) {
            $sql = "UPDATE user SET username='$newUsername' WHERE row_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method reSetUsername.

        protected function reSetDisplayname($newDisplayname,$id) {
            $sql = "UPDATE user SET display_name='$newDisplayname' WHERE row_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method reSetDisplayname.

        protected function unSetUser($userID) {
            $sql = "DELETE FROM user WHERE row_id=$userID AND function=0";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetUser.

        protected function getUserName($userID) {
            $sql = "SELECT display_name FROM user WHERE row_id=$userID";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getUserName.

    }//UserContr.

?>