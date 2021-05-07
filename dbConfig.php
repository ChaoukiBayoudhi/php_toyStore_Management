<?php
    class dbConnect
    {
        private $dataSource="mysql:host=localhost;dbname=toystoreDB6";
        private $username="user07";
        private $password="user05";
        private $dbCon;
        function __construct()
        {
            try {
                $this->dbCon=new PDO($this->dataSource,$this->username,$this->password);
                echo "You are now connected to toystorDB6";

            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
                //or 
                //die();
            }
        }

    }
    $con=new dbconnect();
?>