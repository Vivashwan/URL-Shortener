<?php
    include "config.php";
    $og_url = mysqli_real_escape_string($conn, $_POST['shorten_url']);
    $full_url = str_replace(' ', '', $og_url);
    $hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);

    if(!empty($full_url)){
        // $domain = "localhost";

        if(preg_match("/\//i", $full_url)){
            $explodeURL = explode('/', $full_url);
            $short_url = end($explodeURL);
            if($short_url != ""){
                $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$short_url}' && shorten_url != '{$hidden_url}'");
                if(mysqli_num_rows($sql) == 0){
                    $sql2 = mysqli_query($conn, "UPDATE url SET shorten_url = '{$short_url}' WHERE shorten_url = '{$hidden_url}'");
                    if($sql2){
                        echo "success";
                    }else{
                        echo "Error - Failed to update link!";
                    }
                }else{
                    echo "The short url that you've entered already exist. Please enter another one!";
                }
            }else{
                echo "Required - You have to enter short url!";
            }
        }else{
            echo "Invalid URL - You can't edit domain name!";
        }
    }else{
        echo "Error - You have to enter short url!";
    }
?>