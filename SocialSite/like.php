<?php

session_start();
include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");
include("classes/profile.php");



$login = new Login();
$user_data = $login->check_login($_SESSION['chatbook_userid']);

    if(isset($_SERVER['HTTP_REFERER']))
    {
        $return_to = $_SERVER['HTTP_REFERER'];
    }
    else
    {
        $return_to = "profile.php";
    }
    if(isset($_GET['type']) && isset($_GET['id']))
    {
        if(is_numeric($_GET['id']))
        {
            $allowed[]= 'post';
            $allowed[]= 'user';
            $allowed[]= 'comment';
            
            if(in_array($_GET['type'], $allowed))
            {
                $post = new Post();
                $post->like_post($_GET['id'],$_GET['type'],$_SESSION['chatbook_userid']);
            }
        }

    }
    

    header("Location: ". $return_to);
    die;
