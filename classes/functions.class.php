<?php 

    class Functions {

        public function isAlphanumeric($value) {
            return ctype_alnum($value);
        }//Method isAlphanumeric.

        public function stripAlphaNumeric($value) {
            return str_replace(array('.','/','_'), '',$value);
        }//Method stripAlphaNumeric.

        public function stripSpaces($value) {
            return str_replace(' ', '', $value);
        }//Method stripSpaces.

        public function stripUnderscores($value) {
            return str_replace('_', '', $value);
        }//Method stripUnderscores.
        
        public function validateLength($value,$min,$max) {
            if (strlen($value) < $min || strlen($value) > $max) {
                return false;
            } else {
                return true;
            }//If.
        }//Method validateLength.
        
        public function isInteger($value) {
           return is_int($value);
        }//Method isInteger.

        public function path($value) {
            return "../". str_replace(',', '/', $value);
        }//Method path.

        public function outcomeMessage($outcome,$message) {
            if ($outcome === "success") {
               echo "<p class='alert alert-success' role='alert'>".$message."</p>";
            } else if($outcome === "error") {
                echo "<p class='alert alert-danger' role='alert'>".$message."</p>";
            } else {
                echo "<p class='alert alert-warning' role='alert'>".$message."</p>";
            }
        }//Method outcomeMessage.

        public function encrypt($password) {
            $passwordEncrypt = '';

            if (!$this->isAlphanumeric($password)) {
                echo "Password is not alphanumeric.";
                return false;
            }

            $aAlphabet = array (
                array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'),
                array('b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a'),
                array('c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b'),
                array('d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c'),
                array('e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d'),
                array('f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e'),
                array('g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f'),
                array('h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g'),
                array('i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h'),
                array('j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i'),
                array('k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j'),
                array('l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k'),
                array('m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l'),
                array('n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m'),
                array('o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n'),
                array('p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o'),
                array('q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p'),
                array('r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q'),
                array('s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r'),
                array('t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s'),
                array('u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t'),
                array('v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u'),
                array('w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v'),
                array('x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w'),
                array('y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x'),
                array('z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y')
            );

            //Move last char of string to the first.
            $passwordRev = $password[strlen($password)-1] . substr_replace($password ,"", -1);

            for ($i=0; $i < strlen($password); $i++) { 

                $asciPassLetter = ord($password[$i]);
                $ascipassRevLetter = ord($passwordRev[$i]);
                
                //Get int value of password letter per letter.
                if ($asciPassLetter >= 97 && $asciPassLetter <= 122) {
                    $asciPassLetter = $asciPassLetter - 97;
                } else if ($asciPassLetter >= 65 && $asciPassLetter <= 90) {
                    $asciPassLetter = $asciPassLetter - 64;
                    if ($asciPassLetter > 25) {
                        $asciPassLetter = 0;
                    }
                } else if ($asciPassLetter >= 48 && $asciPassLetter <= 57){
                    $asciPassLetter = $asciPassLetter - 48;
                } else {
                    $asciPassLetter = 0;
                }//If.

                //Get int value of password reverse letter per letter
                if ($ascipassRevLetter >= 97 && $ascipassRevLetter <= 122) {
                    $ascipassRevLetter = $ascipassRevLetter - 97;
                } else if ($ascipassRevLetter >= 65 && $ascipassRevLetter <= 90) {
                    $ascipassRevLetter = $ascipassRevLetter - 64;
                    if ($ascipassRevLetter > 25) {
                        $ascipassRevLetter = 0;
                    }
                } else if ($ascipassRevLetter >= 48 && $ascipassRevLetter <= 57){
                    $ascipassRevLetter = $ascipassRevLetter - 48;
                } else {
                    $ascipassRevLetter = 0;
                }//If.

                //Construct encrypted password.
                $passwordEncrypt .= $aAlphabet[$asciPassLetter][$ascipassRevLetter];

            }
            return $passwordEncrypt;
        }//Method encrypt.

    }//Functions.
?>