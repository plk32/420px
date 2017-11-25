<?php

class Filters
{
    public function ApplyFilter($filter, $path) {
        switch ($filter) {
            case 'c+':
                $this->Contrast($path, -10);
                break;

            case 'c-':
                $this->Contrast($path, 10);
                break;

            case 'l+':
                $this->Luminosity($path, 10);
                break;

            case 'l-':
                $this->Luminosity($path, -10);
                break;

            case 'sepia':
                $this->Sepia($path);
                break;

            case 'sepia':
                $this->Sepia($path);
                break;

            case 'gray':
                $this->Grayscale($path);
                break;

            case 'gauss':
                $this->Gauss($path);
                break;

            case 'edge':
                $this->Edge($path);
                break;

            default:
                break;
        }
    }

    public function Contrast($path, $val)
    {
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_CONTRAST, $val);
        imagepng($img, $path);
        imagedestroy($img);
    }

    public function Luminosity($path, $val)
    {
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_BRIGHTNESS, $val);
        imagepng($img, $path);
        imagedestroy($img);
    }

    public function Sepia($path)
    {
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_GRAYSCALE);
        imagefilter($img, IMG_FILTER_COLORIZE, 100, 50, 0);
        imagepng($img, $path);
        imagedestroy($img);
    }

    public function Grayscale($path)
    {
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_GRAYSCALE);
        imagepng($img, $path);
        imagedestroy($img);
    }

    public function Gauss($path)
    {
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_GAUSSIAN_BLUR);
        imagepng($img, $path);
        imagedestroy($img);
    }

    public function Edge($path)
    {
        $img = imagecreatefrompng($path);
        imagefilter($img, IMG_FILTER_EDGEDETECT);
        imagepng($img, $path);
        imagedestroy($img);
    }
}