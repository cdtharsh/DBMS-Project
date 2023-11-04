<?php
    session_start();
    include("classes/autoload.php") ;

    $login = new Login();
    $user_data = $login->check_login($_SESSION['chatbook_userid']);

    $Post = new Post();
    $likes = false;
    $ERROR = "";
    if(isset($_GET['id']) && isset($_GET['type']))
    {
        $likes = $Post->get_likes($_GET['id'],$_GET['type']);
    }
    else
    {
        $ERROR = "NO SUCH INFO FOUND!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <?php include("header.php"); ?>
    <!--below cover-->
    <div class="part">
        <!--Posts Area-->
        <div class="box2">
            <div class="postxt">

            <?php

            $User = new User();
                if(is_array($likes))
                {
                    foreach($likes as $row)
                    {
                        $FRIEND_ROW = $User->get_user($row['userid']);
                        include("user.php");
                    }
                }
            ?>
            <br style="clear: both;">
            </div>
        </div>
    </div>
</body>
</html>