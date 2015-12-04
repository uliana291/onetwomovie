<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Messages;
use App\User;
use App\Cities;
use App\Helper;
use Validator;
use DB;
use App\Cinemas;
use Illuminate\Http\Request;
use App\Movies;
use App\Seances;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request, $id = null)
    {

        if ($id <> null) {
            $s = Seances::find($id);
            $c = Cinemas::find($s->cinema_id);
            $city_id = $c->city_id;
        } else
            $city_id = $request->input('city_id');

        $users = new User();
        if ($request->input('gender')) {
            $users = $users->where("gender", '=', $request->input('gender'));
        }
        if ($request->input('city_id') <> 0) {
            $users = $users->where("city_id", '=', $city_id);
        }

        if ($request->input('age_from') <> 0) {
            $users = $users->where(DB::raw("TIMESTAMPDIFF(YEAR,birth_date,CURDATE())"), '>=', $request->input('age_from'));
        }

        if ($request->input('age_to') <> 0) {
            $users = $users->where(DB::raw("TIMESTAMPDIFF(YEAR,birth_date,CURDATE())"), '<=', $request->input('age_to'));
        }

        $users = $users->where("status", "enable");

        $users = $users->where("id", '<>', $request->user()->id);

        $users = $users->get();

        $cities = Cities::orderBy('city')->get();

        $cityList = [];
        $cityList[0] = 'Любой';
        foreach ($cities as $key => $value) {
            $cityList[$value->id] = $value->city;
        }

        foreach ($users as $key => $user) {
            if ($user->ava <> null) {
                $img = $user->ava;
                $users[$key]->ava = '/upload/' . $img;
            }

            $age = Helper::ageCalculator($user->birth_date);
            $users[$key]->age = ($age == null ? " " : $age);
            if ($user->city_id <> '0')
                $users[$key]->city = Cities::find($user->city_id)->city;
            else
                $users[$key]->city = " ";
        }


        return view()->make('search.user_filter', array('users' => $users, 'cityList' => $cityList, 'city_id' => $city_id,
            'age_from' => ($request->input('age_from')? $request->input('age_from') : 0),
            'age_to' => ($request->input('age_to')? $request->input('age_to') : 0),
            'gender' => $request->input('gender'),
            'id' => $id));

    }

    public
    function getMovies(Request $request)
    {

        date_default_timezone_set('Europe/Moscow');

        if ($request->input('city_id') == null)
            $city = $request->user()->city_id;
        else
            $city = $request->input('city_id');

        $cities = Cities::orderBy('city')->get();

        $cityList = [];
        foreach ($cities as $key => $value) {
            $cityList[$value->id] = $value->city;
        }
        $cinemas = Cinemas::where("city_id", $city)->orderBy("title")->get();
        $cinemasIds = array_pluck($cinemas, "id");
        $seances = \App\Seances::whereIn("cinema_id", $cinemasIds)->where("start_time", '>', date("Y-m-d H:i:s"))->groupBy("movie_id")->with('getMovie')->get();
        $movies = [];
        foreach ($seances as $item) {
            $movie = $item->getMovie->getAttributes();
            $poster = json_decode($item->getMovie->poster)->name;
            $movie['poster'] = $poster; //Helper::getPosterLink($poster);
            $movies[] = $movie;
        }
        return view()->make('search.movies_filter', array('movies' => $movies, 'cityList' => $cityList, 'city' => $city));

    }


    public
    function getCinemas($id, $city_id)
    {
        date_default_timezone_set('Europe/Moscow');


        $cinemas = Cinemas::where("city_id", $city_id)->with(["getSeances" => function ($q) use ($id) {
            $q->where("movie_id", $id);
            $q->orderBy("start_time", "ASC");
            $q->where("start_time", '>', date("Y-m-d H:i:s"));
        }])->get();
        $data = [];
        foreach ($cinemas as $value) {
            foreach ($value->getSeances as $item) {
                $data[$value->id][$item->date][] = $item;
            }
        }
        //$cinemasIds = array_pluck($cinemas,"id");
        //$seances = \App\Seances::whereIn("cinema_id",$cinemasIds)->where("movie_id",$id)->with('getCinema')->where("start_time",'>',date("Y-m-d H:i:s"))->get();

        $cinemasNames = [];
        foreach ($cinemas as $value) {
            $cinemasNames[$value->id] = $value->title;
        }


        return view()->make('search.seances', array('cinemas' => $data, 'names' => $cinemasNames));

    }

    public
    function getMovieInfo($id)
    {
        $movie = Movies::where('id', $id)->with('getGenres')->first();
        $genres = $movie->getGenres;

        $movie_genres = [];
        foreach ($genres as $genre) {
            $movie_genres[] = $genre->getGenre->name;
        }

        $poster = json_decode($movie->poster)->name;
        $movie->poster = $poster;


        $images = json_decode($movie->images);

        $movie_images = [];

        foreach ($images as $image) {
            if ($image->name <> null) {
                $movie_images[] = $image->name;
            }
        }

        return view()->make('search.movie', ['movie' => $movie, 'genres' => $movie_genres, 'images' => $movie_images]);

    }

    public
    function getCinemaInfo($id)
    {
        $cinema = Cinemas::find($id);

        return view()->make('search.cinema', ['cinema' => $cinema]);
    }

    public function saveMessage(Request $request)
    {
        $message = [];
        $message['seance_id'] = $request->input('seanceHidden');
        $message['user_id_received'] = $request->input('userHidden');
        $message['user_id_sent'] = $request->user()->id;
        $message['message'] = $request->input('textArea');
        $ids = [$message['user_id_sent'], $message['user_id_received']];
        $b = $message['user_id_sent'] == $message['user_id_received'];
        if ($b)
            $res = Messages::whereIn('user_id_sent', $ids)->whereIn('user_id_received', $ids)->first();
        else
            $res = Messages::whereIn('user_id_sent', $ids)->whereIn('user_id_received', $ids)->whereRaw('user_id_received <> user_id_sent')->first();

        if (count($res) == 0)
            $message['dialog_num'] = Messages::orderBy('dialog_num', 'DESC')->first()->dialog_num + 1;
        else
            $message['dialog_num'] = $res->dialog_num;

        Messages::create($message);
        return redirect()->back()->with('error', 0)->with('message', 'Сообщение отправлено.');
    }


}


?>