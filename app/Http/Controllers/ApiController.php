<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Image;
use App\Cities;
use App\Genres;
use App\Cinemas;
use App\Seances;
use App\Movies;

class ApiController extends Controller
{
    public static function getImage($id, $width, $height)
    {
        // TODO: if file not exist make no avatar image
        $user = User::find($id);
       // if(is_null($user)) {

        //}

        $img = Image::make(public_path("upload/" . $user->ava));

        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->crop($width, $height, 0, 0);

        $response = response()->make($img->encode('png'));
        $response->header('Content-Type', 'image/png');
        return $response;
    }



    public static function getStaticValues($type)
    {
        $file = public_path("upload/Tmp" . $type . ".json.gz");
        if ($type == "Cities") {
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/cities.json.gz";
        } else {
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/genres.json.gz";
        }
        file_put_contents($file, fopen($link, 'r'));
        $fp = gzopen($file, "r");
        if ($fp != false) {
            $contents = gzread($fp, 50000000);
            $jsonArray = json_decode($contents, true);
            foreach ($jsonArray as $key => $value) {
                ($type == "Cities" ? Cities::store($value) : Genres::store($value));
            }
            gzclose($fp);
            unlink($file);
        } else
            echo "404 not found";
    }


    public static function getDynamicValues($type)
    {
        $file = public_path("upload/Tmp" . $type . ".json.gz");
        if ($type == "Cinemas") {
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/cinemas.json.gz";
        } elseif ($type == "Seances") {
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/seances/week.json.gz";
        } else
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/running/week.json.gz";
        file_put_contents($file, fopen($link, 'r'));
        $fp = gzopen($file, "r");
        if ($fp != false) {
            $contents = gzread($fp, 50000000);
            $jsonArray = json_decode($contents, true);
            foreach ($jsonArray as $key => $value) {
                if ($type == "Cinemas")
                    Cinemas::store($value);
                elseif ($type == "Seances")
                    Seances::store($value);
                else
                    Movies::store($value);
            }
            gzclose($fp);
            unlink($file);
        } else
            echo "404 not found";
    }

}
