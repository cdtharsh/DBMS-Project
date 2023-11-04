<?php

session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");


$login = new Login();
$user_data = $login->check_login($_SESSION['chatbook_userid']);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if(isset($_FILES['profile_img']['name']) && $_FILES['profile_img']['name'] != "")
    {  
        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";

        if($_FILES['profile_img']['type'] == "image/jpeg")
        {
            $allowed_size = (1024 * 1024) * 3;
            if($_FILES['profile_img']['size'] < $allowed_size)
            {
                //naming
                $folder = "uploads/" . $user_data['userid']. "/";

                //create folder
                if(!file_exists($folder))
                {
                    mkdir($folder,0777,true);
                }

                $image = new Image();
                $filename = $folder . $image->generate_file_name(15);
                move_uploaded_file($_FILES['profile_img']['tmp_name'], $filename);
                
                $change = "profile";
                if(isset($_GET['change']))
                {
                    $change = $_GET['change'];
                }


                $image = new Image();
                if($change == "cover")
                    {
                        if(file_exists($user_data['cover_image']))
                        {
                            unlink($user_data['cover_image']);
                        }
                        $image->crop_image($filename,$filename,1366,488);
                    }
                    else
                    {
                        if(file_exists($user_data['profile_image']))
                        {
                            unlink($user_data['profile_image']);
                        }
                        $image->crop_image($filename,$filename,800,800);
                    }

                if(file_exists($filename))
                {
                    $userid = $user_data['userid'];
                    if($change == "cover")
                    {
                        $query = "UPDATE users SET cover_image = '$filename' WHERE userid = '$userid' limit 1";
                    }
                    else
                    {
                        $query = "UPDATE users SET profile_image = '$filename' WHERE userid = '$userid' limit 1";
                    }

                    $DB = new Database("locahost","root","","chatbook_db");
                    $DB->save($query);

                    header("Location: profile.php");
                    die;
                }
            }
            else
            {
                echo "<div style='text-align:center; font: size 20px; color:white; background-color:grey;'>";
                echo "The Following Errors Occured<br>";
                echo "please upload valid file";
                echo "</div>";
            }
        }
        else
        {
            echo "<div style='text-align:center; font: size 20px; color:white; background-color:grey;'>";
            echo "The Following Errors Occured<br>";
            echo "please upload valid file";
            echo "</div>";
        }

        
        
    }
    else
    {
        echo "<div style='text-align:center; font: size 20px; color:white; background-color:grey;'>";
        echo "The Following Errors Occured<br>";
        echo "please upload valid file";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <?php include("header.php"); ?>
    <!--Posts Area-->
    <form method="post" enctype="multipart/form-data" >
    <div class="box2">
        <div class="postxt">
            <input type="file" name="profile_img">
            <br><input type="submit" value="Post" class="pstbtn"><br>
            <br><br>
            <div style="text-align: center">
            <?php
            // Check for the 'change' parameter in the URL
            if (isset($_GET['change']) && $_GET['change'] == "cover") {
                $change = "cover";
                echo "<img src='" . $user_data['cover_image'] . "' style='max-width: 500px;'>";
            } else {
                echo "<img src='" . $user_data['profile_image'] . "' style='max-width: 500px;'>";
            }
            ?>
            </div>
        </div>
    </div>
    </form>
</body>
</html>