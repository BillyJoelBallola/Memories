<?php
    function connection(){

        $host = 'localhost';
        $username = 'root';
        $password = 'billyjoel';
        $database = 'dbmemories';

        $conn = mysqli_connect($host, $username, $password, $database);

        if($conn->connect_error){
            echo $conn->connect_error;
        }else{
            return $conn;
        }
    }
?>