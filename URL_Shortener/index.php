<?php
session_start();

if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
} else {
    header("Location: ../loginAndRegister/login.php");
    exit();
}

?>

<?php
include "php/config.php";
$new_url = "";
if (isset($_GET)) {
    foreach ($_GET as $key => $val) {
        $u = mysqli_real_escape_string($conn, $key);
        $new_url = str_replace('/', '', $u);
    }

    $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
    if (mysqli_num_rows($sql) > 0) {
        $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}' ");
        if ($count_query) {
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:" . $full_url['full_url']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="styling10.css">

</head>

<body>

    <audio id="deleteSound">
        <source src="./music/shootingSound.mp3" type="audio/mpeg">
        <!-- Your browser does not support the audio element. -->
    </audio>

    <audio id="clearSound">
        <source src="./music/fingerSnap.mp3" type="audio/mpeg">
        <!-- Your browser does not support the audio element. -->
    </audio>

    <audio id="btnSound">
        <source src="./music/keyPressSound1.mp3" type="audio/mpeg">
        <!-- Your browser does not support the audio element. -->
    </audio>

    <div class="bun">
        <strong>☀️</strong>
        <strong>🌙</strong>
    </div>

    <a href="../loginAndRegister/logout.php" class="btn btn-warning"><i class="fa-solid fa-right-from-bracket" style="color: #FFD43B;"></i></a>

    <div class="wrapper">
        <form action="#">
            <i class="fa-solid fa-link"></i>
            <input type="text" name="full-url" placeholder="Type or Paste your URL" required autocomplete="off">
            <button><i>Shorten</i></button>
        </form>

        <?php
        $sql2 = mysqli_query($conn, "SELECT * FROM url WHERE users = '$email' ORDER BY id DESC");

        if (mysqli_num_rows($sql2) > 0) {
        ?>
            <div class="count">
                <?php
                $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url where users = '{$email}'");
                $res = mysqli_fetch_assoc($sql3);

                $sql4 = mysqli_query($conn, "SELECT clicks FROM url where users = '{$email}'");
                $total = 0;

                while ($c = mysqli_fetch_assoc($sql4)) {
                    $total = $c['clicks'] + $total;
                }
                ?>

                <span>Total Links: <span>
                        <?php echo end($res); ?>
                    </span> & Total Clicks: <span>
                        <?php echo $total; ?>
                    </span></span>
                <a class="clearBtn" href="php/delete.php?delete=all"><i>Clear All</i></a>
            </div>

            <div class="url-area">

                <div class="title">
                    <li>Shortened URL</li>
                    <li>Original URL</li>
                    <li>Clicks</li>
                    <li>Action</li>
                </div>
                <?php

                while ($row = mysqli_fetch_assoc($sql2)) {
                ?>
                    <div class="data">
                        <li>
                            <a href="http://localhost/URL_Shortener/<?php echo $row['shorten_url'] ?>" target="_blank">
                                <?php
                                if ('localhost/URL_Shortener/' . strlen($row['shorten_url']) > 50) {
                                    echo 'localhost/URL_Shortener/' . substr($row['shorten_url'], 0, 50) . '...';
                                } else {
                                    echo 'localhost/URL_Shortener/' . $row['shorten_url'];
                                }
                                ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $row['full_url'] ?>" target="_blank">
                                <?php
                                if (strlen($row['full_url']) > 65) {
                                    echo substr($row['full_url'], 0, 65) . '...';
                                } else
                                    echo $row['full_url'];
                                ?>
                            </a>
                        </li>
                        <li>
                            <?php echo $row['clicks'] ?>
                        </li>
                        <li>
                            <a class="deleteBtn" href="php/delete.php?id=<?php echo $row['shorten_url'] ?>"><i>Delete</i></a>
                        </li>
                    </div>
            <?php
                }
            }
            ?>
            </div>

    </div>

    <div class="blurEffect">

        <div class="canvasContainer">
            <canvas id="canvas"></canvas>
        </div>

    </div>

    <div class="popup-Box">
        <div class="infoBox">Your short link is ready. You can also edit your short link now but can't edit once you
            saved it.</div>

        <form action="#", autocomplete="off">
            <label>Edit your shorten URL</label>
            <input type="text" class="shorten-url" spellcheck="false" required>
            <i class="fa-regular fa-copy"></i>
            <button>Save</button>
        </form>
    </div>

</body>

<script src="index10.js"></script>
<script src="confetti3.js"></script>

</html>