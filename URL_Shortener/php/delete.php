<?php
include "config.php";

// Start the session to access session variables
session_start();

// Check if the email is set and not empty in the session
if (!empty($_SESSION['user_email'])) {
    // Retrieve the email from the session
    $user_email = mysqli_real_escape_string($conn, $_SESSION['user_email']);

    // Check if 'id' parameter is set for deleting a specific URL
    if (isset($_GET['id'])) {
        $dlt_id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = mysqli_query($conn, "DELETE FROM url WHERE shorten_url = '$dlt_id' AND users = '$user_email'");
        
        if ($sql) {
            // Redirect or display success message
            header("Location: ../");
            exit;
        } else {
            // Handle SQL error
            echo "Error: " . mysqli_error($conn);
            // Redirect or handle failure
            exit;
        }
    } elseif (isset($_GET['delete'])) { // Check if 'delete' parameter is set for deleting all URLs
        $sql2 = mysqli_query($conn, "DELETE FROM url WHERE users = '$user_email'");
        
        if ($sql2) {
            // Redirect or display success message
            header("Location: ../");
            exit;
        } else {
            // Handle SQL error
            echo "Error: " . mysqli_error($conn);
            // Redirect or handle failure
            exit;
        }
    } else {
        // Handle invalid request
        echo "Invalid request.";
        // Redirect or handle appropriately
        exit;
    }
} else {
    // Handle the case where email is not available
    echo "User email is not set in the session.";
    // Redirect or handle appropriately
    exit;
}
?>