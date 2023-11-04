<div class="post">
    <div>
        <?php
            $image = "";
            if($ROW_USER['gender'] == "Male")
            {
                $image = "social images/user_male.jpg";
            }
            else
            {
                $image = "social images/user_female.jpg";
            }
            if(file_exists($ROW_USER['profile_image']))
            {
                $image = $ROW_USER['profile_image'];
            }
        ?>
        <img src="<?php echo $image ?>" style="width: 75px; margin-left: 4px;">
    </div>
    <div>
        <div class="btxt">
            <?php echo $ROW_USER['first_name']." ".$ROW_USER['last_name']; ?>
        </div>
        <?php echo $ROW['post'] ?>

        <br><br>
        <?php 
        if(file_exists($ROW['post_image']))
        {
            $post_image = $ROW['post_image'];
            echo "<img src='$post_image' style='width: 100%'/>"; 
        }
        ?>
        <br><br>
    </div>
</div>