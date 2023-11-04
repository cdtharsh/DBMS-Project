
<div class="frnds">
    <?php
        $image = "";
        if($FRIEND_ROW['gender'] == "Male")
        {
            $image = "social images/user_male.jpg";
        }
        else
        {
            $image = "social images/user_female.jpg";
        }
        if(file_exists($FRIEND_ROW['profile_image']))
        {
            $image = $FRIEND_ROW['profile_image'];
        }

    ?>
    <a href="profile.php?id=<?php echo $FRIEND_ROW['userid'];?>">
    <img src="<?php echo $image ?>" class="frndsimg"><br>
    <?php echo $FRIEND_ROW['first_name']." ".$FRIEND_ROW['last_name']; ?>
    </a>
</div>