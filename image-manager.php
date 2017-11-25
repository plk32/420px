<?php

require('vendor/autoload.php');

use ColorThief\ColorThief;

class ImageManager
{
    public function Upload($upload_path, $file, $sql, $user_id)
    {
        if (file_exists($upload_path)) {
            echo "Sorry, file already exists.";
        }
        else {
            $imageFileType = pathinfo($upload_path, PATHINFO_EXTENSION);
            switch ($imageFileType) {
                case "jpg":
                    $img = imagecreatefromjpeg($file);
                    break;

                case "png":
                    $img = imagecreatefrompng($file);
                    break;

                case "gif":
                    $img = imagecreatefromgif($file);
                    break;

                default:
                    echo "Sorry, only JPG, PNG, GIF files are allowed";
            }
            if (isset($img)) {
                $scaled = imagescale($img, 420, 420);
                imagepng($scaled, $upload_path);

                $sql->InsertImage($upload_path, $user_id);
            }
        }
    }

    public function SetColor($upload_path, $sql, $user_id)
    {
        $color = ColorThief::getColor($upload_path);

        $red = $color[0];
        $green = $color[1];
        $blue = $color[2];

        if ($red > $green && $red > $blue)
            $main = 'R';
        else if ($green > $blue && $green > $blue)
            $main = 'G';
        else if ($blue > $green && $blue > $red)
            $main = 'B';
        else
            $main = 'NONE';

        $sql->UpdateImageWithColor($upload_path, $user_id, $main);
    }
}