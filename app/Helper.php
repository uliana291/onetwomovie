<?php

namespace App;

use Illuminate\Http\Response;
use Image;

class Helper
{
    public static function ageCalculator($dob)
    {
        if (!empty($dob)) {
            $birthdate = new \DateTime($dob);
            $today = new \DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        } else {
            return 0;
        }
    }

    public static function getPosterLink($poster)
    {
        $twoChars = substr($poster,0,2);
        $twoChars2 = substr($poster,2,2);
        return "http://www.kinohod.ru/o/".$twoChars."/".$twoChars2."/".$poster;
    }



    public static function getImage($link, $width, $height)
    {
        $img = Image::make($link);

        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->crop($width, $height, 0, 0);

        $response = response()->make($img->encode('jpg'));
        $response->header('Content-Type', 'image/jpg');

        return $response;
    }

}
