<?php

session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['chatbook_userid']);

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
    <!--below cover-->
    <div class="part">
        <!--Freinds Area-->
        <div class="box1">
            <div class="timeline">
                <img src="social images\selfie.jpg" class="propictime"><br>
                <div class="nametime"><a href="profile.php" style="text-decoration: none;" ><?php echo $user_data['first_name']."<br>" .$user_data['last_name']; ?></a></div>
            </div>
        </div>
        <!--Posts Area-->
        <div class="box2">
            <div class="postxt">
                <textarea placeholder="Whats in your mind?" class="postbx"></textarea>
                <br><input type="submit" value="Post" class="pstbtn"><br>
            </div>
        <!--post-->
        <div class="postbar">

            <!--post1-->
            <div class="post">
                <div>
                    <img src="social images\user1.jpg" style="width: 75px; margin-left: 4px;" >
                </div>
                <div>
                    <div class="btxt">User1</div>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec scelerisque in dui at feugiat. Aliquam eu egestas erat. Suspendisse dolor mi, molestie id viverra sed, tincidunt sit amet ante. Donec urna felis, venenatis id tristique vitae, commodo porta lorem. In tincidunt odio et venenatis lacinia. Fusce consectetur, mi et gravida consectetur, lectus massa ullamcorper est, eget pretium libero ex quis erat. Nullam at tellus a eros bibendum euismod et at augue.
                    <br><br>
                    <a href="#">Like</a> . <a>Comment</a> . <span> OCT 11 2023</span>
                </div>
            </div>

            <!--post1-->
            <div class="post">
                <div>
                    <img src="social images\user2.jpg" style="width: 75px; margin-left: 4px;" >
                </div>
                <div>
                    <div class="btxt">User2</div>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec scelerisque in dui at feugiat. Aliquam eu egestas erat. Suspendisse dolor mi, molestie id viverra sed, tincidunt sit amet ante. Donec urna felis, venenatis id tristique vitae, commodo porta lorem. In tincidunt odio et venenatis lacinia. Fusce consectetur, mi et gravida consectetur, lectus massa ullamcorper est, eget pretium libero ex quis erat. Nullam at tellus a eros bibendum euismod et at augue.
                    <br><br>
                    <a href="#">Like</a> . <a>Comment</a> . <span> OCT 11 2023</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>