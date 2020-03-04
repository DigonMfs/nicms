<?php 
    //Database class.
    class Dbh {

        //Declare variables.
        private $servername = "localhost";
        private $username = "root";
        private $password = "root";
        private $dbname = "nicms";

        //Connection method.
        protected function connect() {
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            return $conn;
        }//Connect method.

    }//Db class.

?>