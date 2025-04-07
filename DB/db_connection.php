<?php
    class db_connection{
        public $connect;

        var $host = "localhost";
        var $dbname = "secur_it";
        var $username = "root";
        var $password = "";

        public function databaseConnect(){
            $con = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
            if(!$con){
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $this->connect = $con;
            }
        }

        public function close(){
            mysqli_close($this->connect);
        }

        public function wQueryToFile($query)
        {
            //Linux:
            $myfile = fopen("/opt/lampp/htdocs/github/secur-it/DB/testfile.txt", "a") or die("Unable to open file!");

            //Windows:
            // $myfile = fopen("C:/xampp/htdocs/dashboard/Strony Internetowe/secur-it/DB/testfile.txt", "a") or die("Unable to open file!");
            fwrite($myfile, $query."\n\n");
            fclose($myfile);
        }
    }
?>