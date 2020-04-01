<?php 
class User extends Dbh {

    protected function login($username) {
        $sql = "SELECT * FROM user WHERE username='$username'";
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

    protected function getCurUser($id) {
        $sql = "SELECT * FROM user WHERE row_id=$id";
        $result = $this->connect()->query($sql);
        return $result;
    }//Method getUser.

    protected function reSetPassword($newPassword,$id) {
        $sql = "UPDATE user SET password='$newPassword' WHERE row_id=$id";
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

}//UserContr.

?>