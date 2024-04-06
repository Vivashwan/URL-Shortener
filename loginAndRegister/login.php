<?php
    session_start();
    
    if (isset($_SESSION["user"]))
    {
        header("Location: ../URL_Shortener/index.php");
    }
    // exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link rel="stylesheet" href="style19.css">
</head>
<body>
    <audio id="formBtnSound">
        <source src="./music/keyPressSound1.mp3" type="audio/mpeg">
    </audio>

    <audio id="aSound">
        <source src="./music/cameraVideoButtonPress.mp3" type="audio/mpeg">
    </audio>

    <div class="bun">
        <strong>☀️</strong>
        <strong>🌙</strong>
    </div>
    
    <div class="container">
        <?php
            if(isset($_POST["login"]))
            {
                sleep(2);
                $email = $_POST["email"];
                $password = $_POST["password"];

                require_once("database.php");

                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);

                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                if($user)
                {
                    if(password_verify($password, $user["password"]))
                    {
                        session_start();
                        $_SESSION["user"] = "yes";
                        $_SESSION["user_email"] = $email;
                        header("Location: ../URL_Shortener/index.php");
                         echo "<script>
                                setTimeout(function() {
                                    window.location.href = '../URL_Shortener/index.php';
                                }, 3000); // 1000 milliseconds = 1 second
                              </script>";
                        die();
                    }
                    else
                    {
                        echo "<div id='passwordError' class='alert alert-danger'>Password does not match.</div>";
                    }
                }
                else
                {
                    echo "<div id='emailError' class='alert alert-danger'>Email does not match.</div>";
                }
            }
        ?>

        <form id="loginForm" action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" required autocomplete="off">
                <div id="emailError" class="error-message"></div>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
                <div id="passwordError" class="error-message"></div>
            </div>
            <div class="formBtn">
                <input type="submit" value="Login" name="login" class="btn formB" id="loginB">
            </div>
        </form>
        <div class="registerText"><p>Not Registered yet ?? <a class="reg" href="registration.php">Register Here.</a></p></div>
    </div>
    <script src="index9.js"></script>
</body>
</html> 