<?php
session_start();

if (isset($_SESSION['chatbook_userid'])) 
{
    unset($_SESSION['chatbook_userid']);
}
session_destroy();

header("Location: login.php");
die;


