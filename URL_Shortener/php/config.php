<?php
    $conn = mysqli_connect("localhost", "root", "8Wz&9Pp$", "urlShortener");

    if(!$conn)
    {
        echo "Database connection error".mysqli_connect_error();
    }
?>