<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Image;
use App\Cities;
use App\Genres;
use App\Cinemas;
use App\Seances;
use App\Movies;

define('CREDENTIALS_PATH', '~/.credentials/calendar-php-credentials.json');

class ApiController extends Controller
{

    public static function getImage($id, $width, $height)
    {
        $user = User::find($id);


        $img = Image::make(public_path("upload/" . $user->ava));

        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->crop($width, $height, 0, 0);

        $response = response()->make($img->encode('png'));
        $response->header('Content-Type', 'image/png');
        return $response;
    }

    public static function getPoster($link, $width = 200, $height = 0)
    {

        if (file_exists(base_path() . '/public/upload/' . $link)) {

            $img = Image::make(base_path() . '/public/upload/' . $link);

        } else {
            $original_name = $link;
            $link = \App\Helper::getPosterLink($link);
            $img = Image::make($link);

            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save(base_path() . '/public/upload/' . $original_name);
        }

        $response = response()->make($img->encode('jpg'));
        $response->header('Content-Type', 'image/jpg');

        return $response;
    }


    public static function getMessage(Request $request)
    {
        $name = User::find($request->input('user_id'))->name;
        $my_name = $request->user()->name;
        $seance = Seances::find($request->input('seance'));
        $movie = Movies::find($seance->movie_id)->title;
        $cinema = Cinemas::find($seance->cinema_id)->title;
        $date = $seance->date;
        $time = $seance->time;
        $msg = [];
        $msg[0] = "Привет, " . $name . "! \n\r" .
            "Приглашаю тебя пойти со мной в кино на фильм \"" . $movie .
            "\" в кинотеатр " . $cinema . ". \n\r" .
            "Сеанс, на который предлагаю пойти: " . $date . " в " . $time . ". \n\r" .
            "Очень надеюсь на твой ответ, \n\r" .
            $my_name . ".";
        $msg[1] = "Доброго времени суток, " . $name . "! \n\r" .
            "Приглашаю Вас посетить кинотеатр " . $cinema . " и посмотреть фильм \"" . $movie . "\".\n\r" .
            "Сеанс, на который предлагаю пойти: " . $date . " в " . $time . ". \n\r" .
            "С нетерпением жду Вашего ответа, \n\r" .
            $my_name . ".";
        $fixnum = rand(0, 1);
        $array = array('message' => $msg[$fixnum], 'seance_id' => $request->input('seance'));
        return response()->json($array);

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
        ini_set('memory_limit', '512M');
        ini_set("max_execution_time", "600");
        $file = public_path("upload/Tmp" . $type . ".json.gz");
        if ($type == "Cinemas") {
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/cinemas.json.gz";
        } elseif ($type == "Seances") {
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/seances/week.json.gz";
        } else
            $link = "https://api.kinohod.ru/api/data/1/eed7c723-0b90-3fc9-a3bc-bf235e907b35/running/week.json.gz";
        //dd($link);
        file_put_contents($file, fopen($link, 'r'));
        $fp = gzopen($file, "r");
        if ($fp != false) {
            $contents = gzread($fp, 134217720);
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
