<?php
    include("classes/connect.php");
    include("classes/signup.php");

    $first_name="";
    $last_name="";
    $gender="";
    $email="";  
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $signup = new Signup();
        $result = $signup->evaluate($_POST);
        
        if($result != "")
        {
            echo "<div style='text-align:center; font: size 20px; color:white; background-color:grey;'>";
            echo "The Following Errors Occured<br>";
            echo $result;
            echo "</div>";
        }
        else
        {
            header("Location: login.php");
            die;
        }
        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];
        $gender=$_POST['gender'];
        $email=$_POST['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBook</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo">
        <div>ChatBook</div>
        <div class="signup">Signup</div>
    </div>

    <div class="formbg">
        <div class='logintext'>Sign up to ChatBook <br><br>
            <form method="post" action="">
            <input value="<?php echo $first_name ?>" type="text" name="first_name" class="uname" placeholder="First Name"><br><br>
            <input value="<?php echo $last_name ?>" type="text" name="last_name" class="uname" placeholder="Last Name"><br><br>
            <span>Gender: </span> <br>
            <select name="gender" class="uname">
                <option value="<?php echo $gender ?>"></option>
                <option> Male </option>
                <option> Female </option>
            </select><br><br>
            <input value="<?php echo $email ?>" type="text" name="email" class="uname" placeholder="Email"><br><br>
            <input type="password" name="password" class="pass" placeholder="Enter Password"><br><br>
            <input type="password" name="password2" class="pass" placeholder="Retype Password"><br><br>
            <input type="submit" value="SignUp" class="btn"><br>
            </form>
        </div>
    </div>
</body>
</html>