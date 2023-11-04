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
        <?php
            $likes = ($ROW['likes'] > 0) ? "(".$ROW['likes'].")" : "";
        ?>
        <a href="like.php?type=post&id=<?php echo $ROW['postid'] ?>">Like<?php echo $likes?></a> . <a></a>
        <span style="color: #999;" >
            <?php echo $ROW['date']?>
        </span>
        <span>
        <div style="color:#999; float: right;">
        <?php
            $post = new Post();

            if($post->i_own_post($ROW['postid'],$_SESSION['chatbook_userid']))
            {
                echo "
                <a href='edit.php?id=$ROW[postid]'>
                    Edit
                </a>.
                
                <a href='delete.php?id=$ROW[postid]'>
                    Delete
                </a>";
            }
        ?>
        </div>
        </span>
        <?php
                $i_liked = false;
            if(isset($_SESSION["chatbook_userid"]))
            {
                $DB =  new Database("localhost","root","","chatbook_db");
                
                // Check if the user has already liked the post
                $sql = "SELECT likes FROM likes WHERE type = 'post' AND contentid = '$ROW[postid]' LIMIT 1";
                $result = $DB->read($sql);
                if (is_array($result[0])) 
                {
                    $likes = json_decode($result[0]['likes'], true);

                    $user_ids = array_column($likes, 'userid');

                    if (in_array($_SESSION['chatbook_userid'], $user_ids))
                    {
                        $i_liked = true;
                    }
                }
            }
            if($ROW['likes'] > 0)
            {
                echo "<br>";
                echo "<a href='showlike.php?type=post&id=$ROW[postid]'>";
                if($ROW['likes'] == 1)
                {
                    if($i_liked)
                    {
                        echo "<div style='text-align:left;'> You liked your post </div>";
                    }
                    else
                    {
                        echo "<div style='text-align:left;'> 1 other liked your post </div>";
                    }
                }
                else
                {
                    if($i_liked)
                    {
                        echo "<div style='text-align:left;'> You and " . ($ROW['likes'] - 1) . " other's liked your post </div>";
                    }
                    else
                    {
                        echo "<div style='text-align:left;'>" . $ROW['likes'] . " other's liked your post </div>";
                    }
                }

                echo "</a>";
            }
        ?>
    </div>
</div>