<?php 

    //Check if value is alphanumeric
    function IsAlphaNumeric($value) {
        return ctype_alnum($value);
    }//function IsAlphanumeric

    function StripAlphaNumeric($value) {
        return str_replace(array('.','/','_'), '',$value);
    }//function StripAlphaNumeric
    
    function StripSpaces($value) {
        return str_replace(' ', '', $value);
    }//stripspaces
    
    function ValidateLength($value,$min,$max) {
         //check if length of the value is correct
        if (strlen($value) < $min || strlen($value) > $max) {
            return false;
        } else {
            return true;
        }//if test length
    }//function validate length
    
    function IsInteger($value) {
       return is_int($value);
    }//function IsInteger

?>