<?php 
class UserContr extends User {

    public function loginContr($username,$password) {
        $FunctionsObj = new Functions();

        //Check if values are alphanumeric.
        if(!$FunctionsObj->validateLength($username,3,30) || !$FunctionsObj->validateLength($password,3,30)) {
            echo $FunctionsObj->outcomeMessage("error","The length is too long/short.");
            return false;
        }//If validateLength.
        if(!$FunctionsObj->isAlphanumeric(str_replace(' ','',$username)) || !$FunctionsObj->isAlphanumeric(str_replace(' ','',$password))) {
            echo $FunctionsObj->outcomeMessage("error","Username and or password are not alphanumeric.");
            return false;
        }//If alphanumeric.

        //Login.
        $result = $this->login($username,$FunctionsObj->encrypt($password));
        if ($result->num_rows > 0) {
            $_SESSION["userID"] = "Test";
        } else {
            echo $FunctionsObj->outcomeMessage('error','Username and or password are incorrect.');
        }
    }//Method login.

    public function logout() {
        session_unset();
        session_destroy();
    }

}//UserContr.

?>