<?php
session_start();

$errors = array();

if (isset($_SESSION["user"])) {
    header("Location: ../URL_Shortener/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style9.css">
</head>

<body>
    <audio id="bSound">
        <source src="./music/cameraVideoButtonPress.mp3" type="audio/mpeg">
    </audio>

    <div class="bun">
        <strong>☀️</strong>
        <strong>🌙</strong>
    </div>

    <div class="container">
        <?php
        if (isset($_POST["submit"])) {

            sleep(2);
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);


            if (strlen(trim($fullName)) === 0 || strlen(trim($email)) === 0 || strlen($password) === 0 || strlen($passwordRepeat) === 0) {
                array_push($errors, "All fields are required.");
            }


            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }

            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }

            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }

            require_once("database.php");
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);

            $rowCount = mysqli_num_rows($result);

            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }

            if (count($errors) > 0 && in_array("All fields are required.", $errors)) {
                echo "<div id='all-fields-req' class='alert alert-danger'>All fields are required.</div>";
            } else {
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You have registered successfully.</div>";

                    // Redirect the user to index.php after successful registration
                    header("Location: ../URL_Shortener/index.php");
                    exit(); // Make sure to exit after redirection
                } else {
                    die("Something went wrong.");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" name="fullname" placeholder="Full Name:" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email:" autocomplete="off">
                <?php
                if (in_array("Email already exists!", $errors)) {
                    echo "<div id='email-exists-error' class='alert alert-danger'>Email already exists!</div>";
                } else if (in_array("Email is not valid", $errors)) {
                    echo "<div id='email-invalid-error' class='alert alert-danger'>Email is not valid</div>";
                }
                ?>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password:">
                <?php
                if (in_array("Password must be at least 8 characters long", $errors)) {
                    echo "<div id='password-length-error' class='alert alert-danger'>Password must be at least 8 characters long.</div>";
                }
                ?>
            </div>
            <div class="form-group">
                <input type="password" name="repeat_password" placeholder="Repeat Password:">
                <?php
                if (in_array("Password does not match", $errors)) {
                    echo "<div id='password-match-error' class='alert alert-danger'>Password does not match</div>";
                }
                ?>
            </div>
            <div class="inputButton">
                <input class="registerBtn" type="submit" value="Register" name="submit">
            </div>
        </form>
        <div class="loginText">
            <p>Already Registered ?? <a class="logi" href="login.php">Login Here.</a></p>
        </div>
    </div>

    <script src="index12.js"></script>
</body>

</html>