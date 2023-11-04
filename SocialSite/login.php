<?php
session_start();

    include("classes/connect.php");
    include("classes/login.php");

    $email="";
    $password="";  
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $login = new Login();
        $result = $login->evaluate($_POST);
        
        if($result != "")
        {
            echo "<div style='text-align:center; font: size 20px; color:white; background-color:grey;'>";
            echo "The Following Errors Occured<br>";
            echo $result;
            echo "</div>";
        }
        else
        {
            header("Location: profile.php");
            die;
        }
        $email=$_POST['email'];
        $password=$_POST['password'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBook | Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo">
        <div>ChatBook</div>
        <a href="signup.php"><div class="signup">Signup</div></a>
    </div>

    <div class="formbg">
        <div class='logintext'>Log in to ChatBook <br><br>
        <form method="post">
            <input name="email" value="<?php echo $email ?>" type="text" class="uname" placeholder="Enter Username"><br><br>
            <input name="password" value="<?php echo $email ?>" type="password" class="pass" placeholder="Enter Password"><br><br>
            <input type="submit" value="Login" class="btn"><br>
        </form>
        </div>
    </div>
</body>
</html>