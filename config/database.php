<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "crud_php_basic";

    $conn = mysqli_connect($hostname, $username, $password, $db);

    if ($conn == false) {
        die("connection error");
    } else {
        // echo "successfully";
    }

?>