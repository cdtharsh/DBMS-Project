<?php
    session_start();
    include("classes/autoload.php") ;

    $login = new Login();
    $user_data = $login->check_login($_SESSION['chatbook_userid']);

    $Post = new Post();

    $ERROR = "";
    if(isset($_GET['id']))
    {

        $ROW = $Post->get_one_post($_GET['id']);

        if(!$ROW)
        {
            $ERROR = "NO SUCH POST FOUND!";
        }
        else
        {
            if($ROW["userid"] != $_SESSION['chatbook_userid'])
            {
                $ERROR = "Access denied! you cant delete this file!";
            }
        }
    }
    else
    {
        $ERROR = "NO SUCH POST FOUND!";
    }

    //if something posed
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $Post->edit_post($_POST,$_FILES);
        //header("Location: profile.php");
        //die;

        print_r($_POST);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
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
                <form method="post" enctype="multipart/form-data">
                    
                        <?php
                        if($ERROR != "")
                        {
                            echo $ERROR;
                        }
                        else
                        {
                            echo 
                            "Edit Post!<br><br>";
                            echo '<textarea name="post" placeholder="Whats in your mind?" class="postbx">'.$ROW['post'].'</textarea>
                            <br>
                            <input type="file" name="file">'; 
                            echo "<input type='hidden' value='$ROW[postid]' name='postid'>";
                            echo "<input type='submit' value='Save' class='pstbtn'>";
                            
                            if(file_exists($ROW['post_image']))
                            {
                                $post_image = $ROW['post_image'];
                                echo "<img src='$post_image' style='width: 100%'/>"; 
                            }
                        }
                        ?>
                    <br>
                <br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>