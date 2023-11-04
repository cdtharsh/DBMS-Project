<?php
class Image
{
    public function generate_file_name($length)
    {
        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $text = "";

        for($x = 0; $x < $length; $x++)
        {
            $random = rand(0,61);
            $text .= $array[$random];
        }
        return $text;
    }
    public function crop_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        if (file_exists($original_file_name)) {
            $original_image = imagecreatefromjpeg($original_file_name);

            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            $new_width = $max_width;
            $new_height = $max_height;

            if ($original_width > $original_height) {
                $new_height = ($original_height / $original_width) * $max_width;
            } else {
                $new_width = ($original_width / $original_height) * $max_height;
            }

            $x = 0;
            $y = 0;

            if ($max_width != $max_height) {
                if ($new_width > $new_height) {
                    $x = round(($new_width - $max_width) / 2);
                } else {
                    $y = round(($new_height - $max_height) / 2);
                }
            }

            $new_image = imagecreatetruecolor($max_width, $max_height);
            imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $max_width, $max_height, $original_width, $original_height);

            imagejpeg($new_image, $cropped_file_name, 90);
            imagedestroy($new_image);
            imagedestroy($original_image);
        }
    }
}
