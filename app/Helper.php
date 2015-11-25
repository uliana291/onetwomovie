<?php

namespace App;


use Illuminate\Http\Request;

use Image;

class Helper
{
    public static function ageCalculator($dob)
    {
        if ($dob != '0000-00-00') {
            $birthdate = new \DateTime($dob);
            $today = new \DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        } else {
            return null;
        }
    }

    public static function getPosterLink($poster)
    {
        $twoChars = substr($poster, 0, 2);
        $twoChars2 = substr($poster, 2, 2);
        return "http://www.kinohod.ru/o/" . $twoChars . "/" . $twoChars2 . "/" . $poster;
    }


    public static function checkUnreadMessages(Request $request)
    {
        $msgs = Messages::where('user_id_received', $request->user()->id)->where('read', 0)->get();
        $count = 0;
        $people = [];
        foreach ($msgs as $msg) {
            if (!in_array($msg->user_id_sent, $people)) {
                $count++;
                $people[] = $msg->user_id_sent;
            }
        }

        return $count;
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

    public static function utf8_substr_replace($original, $replacement, $position, $length = 0)
    {
        if (mb_strlen($original) > $position) {
            if ($length == 0)
                $length = mb_strlen($original) - $position;
            $startString = mb_substr($original, 0, $position, "UTF-8");
            $endString = mb_substr($original, $position + $length, mb_strlen($original), "UTF-8");

            $out = $startString . $replacement . $endString;
        } else
            $out = $original;
        return $out;
    }
}
