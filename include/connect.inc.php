<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "controlstudent";

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!$conn){
        echo mysqli_connect_error();
    }
?>