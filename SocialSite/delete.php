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
        $Post->delete_post($_POST["postid"]);
        header("Location: profile.php");
        die;
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
                <form method="post">
                    
                        <?php
                        if($ERROR != "")
                        {
                            echo $ERROR;
                        }
                        else
                        {
                            echo 
                            "Are you sure you want to delete this post??<br><br>"; 
                            $user = new User();
                            $ROW_USER = $user->get_user($ROW['userid']);
                            include("delete_post.php");
                            echo "<input type='hidden' value='$ROW[postid]' name='postid'>";
                            echo "<input type='submit' value='Delete' class='pstbtn'>";
                
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