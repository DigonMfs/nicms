<?php 
class User extends Dbh {

    protected function login($username, $password) {
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

    protected function getCurUser($oldPassword) {
        $id = $_SESSION["userID"];
        $sql = "SELECT * FROM user WHERE row_id=$id AND password='$oldPassword'";
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

}//UserContr.

?>