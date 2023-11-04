<!--top bar-->
<?php
    
    $corner_image = "";
    if(isset($USER))
    {
        if($USER['gender'] == "Male")
        {
            if(file_exists($USER['profile_image']))
            {
                $corner_image = $USER['profile_image'];
            }
            else
            {
                $corner_image = "social images\user_male.jpg";
            }
        }
        else
        {
    
            $corner_image = "social images\user_female.jpg";
    
        }
    }
?>
<div class="bar">
        <div class="barlogo">
            <a href="index.php" style="color: white:" >ChatBook</a>  
            &nbsp; &nbsp; <input type="text" class="srchbx" placeholder="Search">
            <a href="profile.php"><img src="<?php echo $corner_image; ?>" class="selfie"></a>
            <a href="logout.php">
            <span style="color:white; font-size: 11px; float: right; margin: 10px;" >Logout</span>
            </a>
        </div>
    </div>