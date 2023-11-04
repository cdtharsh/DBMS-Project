<?php

    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");
    include("classes/profile.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['chatbook_userid']);

    $USER = $user_data;
    if(isset($_GET['id']))
    {
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);

        if(is_array($profile_data))
        {
            $user_data = $profile_data[0];
        }
    }

    //isset($_SESSION['chatbook_userid']);
    //for posting
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        $post = new Post();
        $id = $_SESSION['chatbook_userid'];
        $result = $post->create_post($id, $_POST, $_FILES);

        if($result == "")
        {
            header("Location: profile.php");
            die;
        }
        else
        {
            echo "<div style='text-align:center; font: size 20px; color:white; background-color:grey;'>";
            echo "The Following Errors Occured<br>";
            echo $result;
            echo "</div>";
        }
    }

    //retrive post
    $post = new Post();
    $id = $user_data['userid'];
    $posts = $post->get_posts($id);

    //collect friends
    $user = new User();
    $friends = $user->get_friends($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBook | Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br>
    <?php include("header.php"); ?>
    <!--cover area-->
    <div class="cover">
        <div class="coverdsn">
                <?php
                    $image = "social images\mountain.jpg";

                    if(file_exists($user_data['cover_image']))
                    {
                        $image = $user_data['cover_image'];
                    }
                ?>
            <img src="<?php echo $image; ?>" class="covimg">
            <span>
                <?php
                    $image = "";
                    if($user_data['gender'] == "Male")
                    {
                        $image = "social images\user_male.jpg";
                    }
                    else
                    {
                        $image = "social images\user_female.jpg";
                    }

                    if(file_exists($user_data['profile_image']))
                    {
                        $image = $user_data['profile_image'];
                    }
                ?>
                <img src="<?php echo $image; ?>" class="propic">
                <a href="img_profile.php?change=profile">
                <div>Change Profile</div></a>
                <a href="img_profile.php?change=cover">Change Cover</a>
            </span>
            <br>
            <div style="font-size: 20px;"><?php echo $user_data ['first_name'] . " " . $user_data ['last_name'] ?></div> <br>
            <!--<a href="index.php"><div class="mb">Timeline</div></a>
            <div class="mb">About</div>
            <div class="mb">Friends</div> 
            <div class="mb">Photos</div> 
            <div class="mb">Setings</div>-->
        </div>
    </div>
    <!--below cover-->
    <div class="part">
        <!--Freinds Area-->
        <div class="box1">
            <div class="frndsbar">
                Friends<br>
                <?php
            
                    if($friends)
                    {
                        foreach ($friends as $FRIEND_ROW) 
                        {
                           
                            include("user.php");
                        }
                    }
                ?>


            </div>
        </div>
        <!--Posts Area-->
        <div class="box2">
            <div class="postxt">
                <form method="post" enctype="multipart/form-data">
                    <textarea name="post" placeholder="Whats in your mind?" class="postbx"></textarea>
                    <br>
                    <input type="file" name="file">
                    <input type="submit" value="Post" class="pstbtn"><br>
                </form>
            </div>
        <!--post-->
        <div class="postbar">
            <?php
            
                if($posts)
                {
                    foreach ($posts as $ROW) 
                    {
                        $user = new User();
                        $ROW_USER = $user->get_user($ROW['userid']);
                        include("post.php");
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>