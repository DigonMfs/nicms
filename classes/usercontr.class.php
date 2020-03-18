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
        
        //Escape the strings to prevent SQL injection.
        $oldPassword = $this->connect()->real_escape_string($oldPassword);
        $newPassword = $this->connect()->real_escape_string($newPassword);
        $confirmNewPassword = $this->connect()->real_escape_string($confirmNewPassword);
        
        //Check if alphanumeric, and between 3 and 30char long.
        if (!$FunctionsObj->validateLength($newPassword,3,30) || !$FunctionsObj->isAlphanumeric($newPassword)) {
            //echo $FunctionsObj->outcomeMessage("error","Password is not alphanumeric, or is too long/short.");
            header("Location: ../pages/account.php?fail=password-alphanumeric");
            return false;
        }

        //Check if new password and confirm new password are the same.
        if ($newPassword != $confirmNewPassword) {
            //echo $FunctionsObj->outcomeMessage("error","New password does not match.");
            header("Location: ../pages/account.php?fail=password-no-match");
            return false;
        }

        //Check if old password is correct.
        $result = $this->getCurUser($FunctionsObj->encrypt($oldPassword));
        if ($result->num_rows <= 0) {
            //echo $FunctionsObj->outcomeMessage("error","Old password is not correct.");
            header("Location: ../pages/account.php?fail=pass-wrong");
            return false;
        }

        //Checkf if new password is the same as the old.
        if ($oldPassword == $newPassword) {
            //echo $FunctionsObj->outcomeMessage("error","New password is the same as the old.");
            header("Location: ../pages/account.php?fail=newpass-same");
            return false;
        }

        //Change the password
        $id = $_SESSION["userID"];
        $result = $this->reSetPassword($FunctionsObj->encrypt($newPassword),$id);
        if ($result === TRUE) {
            //echo $FunctionsObj->outcomeMessage("success","Password has succesfully been changed.");
            header("Location: ../pages/account.php?success=pass-change");
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to change password.");
            header("Location: ../pages/account.php?fail=password-fail");
        }
    }

    public function changeUsername($newUsername) {
        $FunctionsObj = new Functions();

        //Check if username is alphanumeric and is between 3 and 30 chars long.
        if (!$FunctionsObj->validateLength($newUsername,3,30) || !$FunctionsObj->isAlphanumeric($newUsername)) {
            //echo $FunctionsObj->outcomeMessage("error","The new username is not alphanumeric, or is too long/short.");
            header("Location: ../pages/account.php?fail=username-alphanumeric");
            return false;
        }

        //Change username.
        $result = $this->reSetUSername($newUsername,$_SESSION["userID"]);
        if ($result === TRUE) {
            //echo $FunctionsObj->outcomeMessage("success","Username has succesfully been changed.");
            header("Location: ../pages/account.php?success=username-change");
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to change username.");
            header("Location: ../pages/account.php?fail=username-fail");
        }
    }//Method changeUsername.

    public function changeDisplayname($newDisplayname) {
        $FunctionsObj = new Functions();

        //Check if displayname is alphanumeric and is between 3 and 30 chars long.
        if (!$FunctionsObj->validateLength($newDisplayname,3,30) || !$FunctionsObj->isAlphanumeric($newDisplayname)) {
            //echo $FunctionsObj->outcomeMessage("error","The new displayname is not alphanumeric, or is too long/short.");
            header("Location: ../pages/account.php?fail=displayname-alphanumeric");
            return false;
        }

        //Change displayname.
        $result = $this->reSetDisplayname($newDisplayname,$_SESSION["userID"]);
        if ($result === TRUE) {
            //echo $FunctionsObj->outcomeMessage("success","Displayname has succesfully been changed.");
            header("Location: ../pages/account.php?success=displayname-change");
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to change displayname.");
            header("Location: ../pages/account.php?fail=displayname-fail");
        }
    }//Method changeUsername.

    public function addUser($username,$displayname,$password,$confirmPassword) {
        $FunctionsObj = new Functions();

        //Check if all values have a correct length and have a value.
        if (!$FunctionsObj->validateLength($username,3,30) || !$FunctionsObj->validateLength($displayname,3,30) || !$FunctionsObj->validateLength($password,3,30) || !$FunctionsObj->validateLength($confirmPassword,3,30)) {
            //echo $FunctionsObj->outcomeMessage("error","Values are too long/short.");
            header("Location: ../pages/account.php?fail=addAccount-length");
            return false;
        }

        //Checkf if all values are alphanumeric.
        if (!$FunctionsObj->isAlphanumeric($username) || !$FunctionsObj->isAlphanumeric($displayname) || !$FunctionsObj->isAlphanumeric($password) || !$FunctionsObj->isAlphanumeric($confirmPassword)) {
            //echo $FunctionsObj->outcomeMessage("error","Not all values are alphanumeric.");
            header("Location: ../pages/account.php?fail=addAccount-alphanumeric");
            return false;
        }

        //Check if both passwords are the same.
        if($password != $confirmPassword) {
             //echo $FunctionsObj->outcomeMessage("error","Passwords are not the same.");
             header("Location: ../pages/account.php?fail=addAccount-password");
             return false;
        }

        //Add the account.
        $result = $this->insertUser($username,$displayname,$FunctionsObj->encrypt($password));
        if ($result === TRUE) {
           //echo $FunctionsObj->outcomeMessage("error","Account has successfully been added.");
           header("Location: ../pages/account.php?success=addAccount");
           return false;
        } else {
            //echo $FunctionsObj->outcomeMessage("error","Failed to add account.");
            header("Location: ../pages/account.php?fail=addAccount-fail");
            return false;
        }

    }//Method addAccount.
    
}//UserContr.

?>