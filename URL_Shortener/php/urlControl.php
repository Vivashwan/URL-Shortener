<?php

// Start the session to access session variables
session_start();

// Check if the email is set in the session
if (isset($_SESSION['user_email'])) {
    // Retrieve the email from the session
    $user_email = $_SESSION['user_email'];
    // Now you can use $user_email variable here
} else {
    // Handle the case where email is not available
    echo "User email is not set in the session.";
    // Redirect or handle appropriately
}

include "config.php";
    $full_url = mysqli_real_escape_string($conn, $_POST['full-url']);

if (!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)) {
    $ran_url = substr(md5(microtime()), rand(0, 26), 5);
    $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
    if (mysqli_num_rows($sql) > 0) {
        echo "Something went wrong. Please regenerate url again!";
    } else {
        $sql2 = mysqli_query($conn, "INSERT INTO url (shorten_url, full_url, clicks, users) VALUES ('{$ran_url}', '{$full_url}', '0', '{$user_email}')");
        if ($sql2) {
            $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
            if (mysqli_num_rows($sql3) > 0) {
                $shorten_url = mysqli_fetch_assoc($sql3);
                echo $shorten_url['shorten_url'];
            } else {
                echo "Something went wrong! Please try again.";
            }
        }
    }
} else {
    echo "$full_url - This is not a valid URL!";
}
