<?php 
class User extends Dbh {

    protected function login($username, $password) {
        $sql = "SELECT row_id FROM user WHERE username='$username' AND password='$password'";
        $result=$this->connect()->query($sql);
        return $result;
    }//Method login. 

}//UserContr.

?>