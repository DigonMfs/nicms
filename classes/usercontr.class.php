<?php 
class UserContr extends User {

     //Make variable $linkUrl accessible in ArticleView.
     protected $linkUrl = '';
     public function __construct($linkUrl) {
         $this->linkUrl = $linkUrl;
     }

    public function loginContr($username,$password) {
        $FunctionsObj = new Functions();

        //Validation.
        if(!$FunctionsObj->validateLength($username,3,30) || !$FunctionsObj->validateLength($password,3,30)) {
            echo $FunctionsObj->outcomeMessage("error","The length is too long/short.");
            return false;
        }
        if(!$FunctionsObj->isAlphanumeric(str_replace(' ','',$username)) || !$FunctionsObj->isAlphanumeric(str_replace(' ','',$password))) {
            echo $FunctionsObj->outcomeMessage("error","Username and or password are not alphanumeric.");
            return false;
        }

        //Real escape string.
        $username = $this->connect()->real_escape_string($username);
        $password = $this->connect()->real_escape_string($password);

        //Execute sql.
        $result = $this->login($username,$FunctionsObj->encrypt($password));
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_SESSION["userID"] = $row["row_id"];
                $_SESSION["userFunction"] = $row["function"];
            }
        } else {
            echo $FunctionsObj->outcomeMessage('error','Username and or password are incorrect.');
        }
    }//Method login.

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function changePassword($oldPassword,$newPassword,$confirmNewPassword) {
        $FunctionsObj = new Functions();

        //Check if user logged in, and thus allowed to execute this method.
        $FunctionsObj->checkUserLoggedIn();
        
        //Real escape string.
        $oldPassword = $this->connect()->real_escape_string($oldPassword);
        $newPassword = $this->connect()->real_escape_string($newPassword);
        $confirmNewPassword = $this->connect()->real_escape_string($confirmNewPassword);
        
        //Valiation
        if (!$FunctionsObj->validateLength($newPassword,3,30) || !$FunctionsObj->isAlphanumeric($newPassword)) {
            //echo $FunctionsObj->outcomeMessage("error","Password is not alphanumeric, or is too long/short.");
            header("Location: ".$this->linkUrl."account/password-alphanumeric");
            return false;
        }
        if ($newPassword != $confirmNewPassword) {
            //echo $FunctionsObj->outcomeMessage("error","New password does not match.");
            header("Location: ".$this->linkUrl."account/password-no-match");
            return false;
        }
        //Check if old password is correct.
        $result = $this->getCurUser($FunctionsObj->encrypt($oldPassword));
        if ($result->num_rows <= 0) {
            //echo $FunctionsObj->outcomeMessage("error","Old password is not correct.");
            header("Location: ".$this->linkUrl."account/pass-wrong");
            return false;
        }
        if ($oldPassword == $newPassword) {
            //echo $FunctionsObj->outcomeMessage("error","New password is the same as the old.");
            header("Location: ".$this->linkUrl."account/newpass-same");
            return false;
        }

        //Execute sql.
        $id = $_SESSION["userID"];
        $result = $this->reSetPassword($FunctionsObj->encrypt($newPassword),$id);
        if ($result === TRUE) {
            //echo $FunctionsObj->outcomeMessage("success","Password has succesfully been changed.");
            header("Location: ".$this->linkUrl."account/pass-change");
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to change password.");
            header("Location: ".$this->linkUrl."account/password-fail");
        }
    }//Method changePassword.

    public function changeUsername($newUsername) {
        $FunctionsObj = new Functions();

        //Check if user logged in, and thus allowed to execute this method.
        $FunctionsObj->checkUserLoggedIn();

        //Validation.
        if (!$FunctionsObj->validateLength($newUsername,3,30) || !$FunctionsObj->isAlphanumeric($newUsername)) {
            //echo $FunctionsObj->outcomeMessage("error","The new username is not alphanumeric, or is too long/short.");
            header("Location: ".$this->linkUrl."account/username-alphanumeric");
            return false;
        }

        //Real escape string.
        $newUsername = $this->connect()->real_escape_string($newUsername);

        //Change username.
        $result = $this->reSetUSername($newUsername,$_SESSION["userID"]);
        if ($result === TRUE) {
            //echo $FunctionsObj->outcomeMessage("success","Username has succesfully been changed.");
            header("Location: ".$this->linkUrl."account/username-change");
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to change username.");
            header("Location: ".$this->linkUrl."account/username-fail");
        }
    }//Method changeUsername.

    public function changeDisplayname($newDisplayname) {
        $FunctionsObj = new Functions();

        //Check if user logged in, and thus allowed to execute this method.
        $FunctionsObj->checkUserLoggedIn();

        //Validation.
        if (!$FunctionsObj->validateLength($newDisplayname,3,30) || !$FunctionsObj->isAlphanumeric($newDisplayname)) {
            //echo $FunctionsObj->outcomeMessage("error","The new displayname is not alphanumeric, or is too long/short.");
            header("Location: ".$this->linkUrl."account/displayname-alphanumeric");
            return false;
        }

        //Real escape string.
        $newDisplayname = $this->connect()->real_escape_string($newDisplayname);

        //Execute sql.
        $result = $this->reSetDisplayname($newDisplayname,$_SESSION["userID"]);
        if ($result === TRUE) {
            //echo $FunctionsObj->outcomeMessage("success","Displayname has succesfully been changed.");
            header("Location: ".$this->linkUrl."account/displayname-change");
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to change displayname.");
            header("Location: ".$this->linkUrl."account/displayname-fail");
        }
    }//Method changeUsername.

    public function addUser($username,$displayname,$password,$confirmPassword) {
        $FunctionsObj = new Functions();

        //Check if user logged in, and thus allowed to execute this method.
        $FunctionsObj->checkUserLoggedIn();

        //Validation.
        if (!$FunctionsObj->validateLength($username,3,30) || !$FunctionsObj->validateLength($displayname,3,30) || !$FunctionsObj->validateLength($password,3,30) || !$FunctionsObj->validateLength($confirmPassword,3,30)) {
            //echo $FunctionsObj->outcomeMessage("error","Values are too long/short.");
            header("Location: ".$this->linkUrl."account/addAccount-length");
            return false;
        }
        if (!$FunctionsObj->isAlphanumeric($username) || !$FunctionsObj->isAlphanumeric($displayname) || !$FunctionsObj->isAlphanumeric($password) || !$FunctionsObj->isAlphanumeric($confirmPassword)) {
            //echo $FunctionsObj->outcomeMessage("error","Not all values are alphanumeric.");
            header("Location: ".$this->linkUrl."account/addAccount-alphanumeric");
            return false;
        }
        //Check if both passwords are the same.
        if($password != $confirmPassword) {
            //echo $FunctionsObj->outcomeMessage("error","Passwords are not the same.");
            header("Location: ".$this->linkUrl."account/addAccount-password");
            return false;
        }

        //Real escape string.
        $username = $this->connect()->real_escape_string($username);
        $displayname = $this->connect()->real_escape_string($displayname);
        $password = $this->connect()->real_escape_string($password);
        $confirmPassword = $this->connect()->real_escape_string($confirmPassword);

        //Execute sql.
        $result = $this->insertUser($username,$displayname,$FunctionsObj->encrypt($password));
        if ($result === TRUE) {
           //echo $FunctionsObj->outcomeMessage("error","Account has successfully been added.");
           header("Location: ".$this->linkUrl."account/addAccount");
           return false;
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to add account.");
            header("Location: ".$this->linkUrl."account/addAccount-fail");
            return false;
        }
    }//Method addAccount.
    
}//UserContr.


?>