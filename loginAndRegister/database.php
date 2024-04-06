<?php
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "8Wz&9Pp$";
    $dbName = "loginregister";
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if (!$conn) {
        die("Something went wrong;");
    }
?>