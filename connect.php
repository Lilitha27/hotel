<?php
    require_once 'base.php';

    $conn = new mysqli('localhost','root','root','hotel');

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);  
    }
?>