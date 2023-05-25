<?php 

    $host="172.24.0.1:3306";
    $bd="dbname";
    $user="root";
    $password="test";

    /*$servername = "mysql:8183";
    $dbname = "dbname";
    $username = "root";
    $password = "test";*/


    try {
        //$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
        $conection = mysqli_connect($host, $user, $password, $bd);
        //if($conection){ echo "Conectado.... a sistema ";}
    } catch (Exception $ex) {

        echo $ex->getMessage();    
    }

?>