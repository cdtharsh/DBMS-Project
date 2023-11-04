<?php

include("classes/image.php");
class Post
{
    
    public function create_post($userid, $data, $files)
{
    $error = '';

    if (!empty($data['post']) || !empty($files['file']['name'])) {
        $post = !empty($data['post']) ? addslashes($data['post']) : '';
        $myimage = '';
        $has_image = 0;

        if (!empty($files["file"]["name"])) {
            $image_class = new Image();
            $folder = "uploads/" . $userid . "/";

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $myimage = $folder . $image_class->generate_file_name(15);

            if (move_uploaded_file($files['file']['tmp_name'], $myimage)) {
                $image_class->crop_image($myimage, $myimage, 1500, 1500);
                $has_image = 1;
            } else {
                $error .= "Failed to upload the image. ";
            }
        }

        $postid = $this->create_postid();

        $DB = new Database("localhost", "root", "", "chatbook_db");

        // WARNING: Below is not recommended for production use due to SQL injection risk
        $query = "INSERT INTO posts (postid, userid, post, post_image, has_image) VALUES ('$postid', '$userid', '$post', '$myimage', '$has_image')";

        if ($DB->save($query)) {
            $error = ''; // No error
        } else {
            $error .= "Failed to insert the post into the database. ";
        }
    } else {
        $error .= "Please type something or upload an image. ";
    }

    return $error;
}


    public function get_posts($id)
    {
        $query = "SELECT * FROM posts WHERE userid = '$id' order by id desc limit 20";

        $DB = new Database("localhost", "root", "", "chatbook_db");
        $result = $DB->read($query);

        if($result)
        {
            return $result;
        }
        else{
            return false;
        }
    }


    public function get_one_post($postid)
    {
        if(!is_numeric($postid))
        {
            return false;
        }
        $query = "SELECT * FROM posts WHERE postid = '$postid' limit 1";

        $DB = new Database("localhost", "root", "", "chatbook_db");
        $result = $DB->read($query);

        if($result)
        {
            return $result[0];
        }
        else{
            return false;
        }
    }

    public function delete_post($postid)
    {
        if(!is_numeric($postid))
        {
            return false;
        }
        $query = "DELETE FROM posts WHERE postid = '$postid' limit 1";

        $DB = new Database("localhost", "root", "", "chatbook_db");
        $DB->save($query);
    }

    public function i_own_post($postid,$chatbook_userid)
    {
        if(!is_numeric($postid))
        {
            return false;
        }
        $query = "SELECT * FROM posts WHERE postid = '$postid' limit 1";

        $DB = new Database("localhost", "root", "", "chatbook_db");
        $result = $DB->read($query);

        if(is_array($result))
        {
            if($result[0]['userid']==$chatbook_userid)
            {
                return true;
            }
        }
        return false;
    }
    private function create_postid()
    {
        $length = rand(4,19);
        $number = "";
        for ($i=1; $i < $length; $i++) { 
            # code...
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }

        return $number;
    }

    public function like_post($id, $type, $chatbook_userid)
    {
        if ($type == "post") {
            $DB = new Database("localhost", "root", "", "chatbook_db");

            // Check if the user has already liked the post
            $sql = "SELECT likes FROM likes WHERE type = 'post' AND contentid = '$id' LIMIT 1";
            $result = $DB->read($sql);

            if (is_array($result[0])) {
                $likes = json_decode($result[0]['likes'], true);

                $user_ids = array_column($likes, 'userid');

                if (!in_array($chatbook_userid, $user_ids)) {
                    // User hasn't liked the post, so increment likes
                    $sql = "UPDATE posts SET likes = likes + 1 WHERE postid = '$id' LIMIT 1";
                    $DB->save($sql);

                    // Add the user to the list of likers
                    $arr["userid"] = $chatbook_userid;
                    $arr["date"] = date("Y-m-d H:i:s");
                    $likes[] = $arr;
                    $likes_string = json_encode($likes);

                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type = 'post' AND contentid = '$id' LIMIT 1";
                    $DB->save($sql);
                }
                else
                {
                    $key = array_search($chatbook_userid, $user_ids);
                    unset($likes[$key]);

                    $likes_string = json_encode($likes);

                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type = 'post' AND contentid = '$id' LIMIT 1";
                    $DB->save($sql);
                    //user unliked the post
                    $sql = "UPDATE posts SET likes = likes - 1 WHERE postid = '$id' LIMIT 1";
                    $DB->save($sql);
                }
            } else {
                // User hasn't liked the post, so increment likes and create a new record in likes table
                $sql = "UPDATE posts SET likes = likes + 1 WHERE postid = '$id' LIMIT 1";
                $DB->save($sql);

                $arr["userid"] = $chatbook_userid;
                $arr["date"] = date("Y-m-d H:i:s");
                $arr2[] = $arr;
                $likes = json_encode($arr2);

                $sql = "INSERT INTO likes (type, contentid, likes) VALUES ('$type', '$id', '$likes')";
                $DB->save($sql);
            }
        }
    }

    public function get_likes($id,$type)
    {            
        $DB = new Database("localhost", "root", "", "chatbook_db");

        if ($type == "post" && is_numeric($id))
        {

            // Check if the user has already liked the post
            $sql = "SELECT likes FROM likes WHERE type = 'post' AND contentid = '$id' LIMIT 1";
            $result = $DB->read($sql);

            if (is_array($result[0])) 
            {
                $likes = json_decode($result[0]['likes'], true);
                return $likes;
            }
        }
        
        return false;
    }

    public function edit_post($data, $files)
    {
        $error="";
        if(!empty($data['post']) || !empty($files['file']['name']))
        {
            $myimage = "";
            $has_image = 0;
            $userid = $_SESSION['chatbook_userid'];
            
            if(!empty($files["file"]["name"]))
            {
                $image_class = new Image();
                //naming
                $folder = "uploads/" . $userid. "/";

                //create folder
                if(!file_exists($folder))
                {
                    mkdir($folder,0777,true);
                }

                $myimage = $folder . $image_class->generate_file_name(15);
                move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                $image_class->crop_image($myimage, $myimage, 1500, 1500);
                $has_image = 1;

                $post = addslashes($data['post']);
                $postid = $data['postid'];

                if($has_image)
                {
                    $query = "update posts set post = '$post', image = '$myimage' where postid = '$postid' limit 1 ";
                }
                else
                {
                $query = "update posts set post = '$post', where postid = '$postid' limit 1 ";
                }
                $DB = new Database("localhost", "root", "", "chatbook_db");
                $DB->save($query);

            }

        }else
        {
            $this->error .= "please type something ! <br>";
        }
        return $error;
    }

    public function like_profile($user_id, $profile_id) {
        $DB = new Database("localhost", "root", "", "chatbook_db");
    
        // Check if the user has already liked the profile
        $sql = "SELECT likes FROM users WHERE userid = '$profile_id' LIMIT 1";
        $result = $DB->read($sql);
    
        if (is_array($result[0])) {
            $likes = json_decode($result[0]['likes'], true);
    
            if (!in_array($user_id, $likes)) {
                // User hasn't liked the profile, so increment likes
                $likes[] = $user_id;
                $likes_string = json_encode($likes);
    
                $sql = "UPDATE profiles SET likes = '$likes_string' WHERE userid = '$profile_id' LIMIT 1";
                $DB->save($sql);
            }
        } else {
            // User hasn't liked the profile, so increment likes and create a new record in the database
            $likes = [$user_id];
            $likes_string = json_encode($likes);
    
            $sql = "UPDATE profiles SET likes = '$likes_string' WHERE userid = '$profile_id' LIMIT 1";
            $DB->save($sql);
        }
    }
    
}

