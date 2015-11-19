<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\User;
use App\Cities;
use App\Helper;
use Validator;
use DB;
use App\Cinemas;
use Illuminate\Http\Request;
use App\Movies;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request, $id = null)
    {

        $users = new User();
        if ($request->input('gender')) {
            $users = $users->where("gender", '=', $request->input('gender'));
        }
        if ($request->input('city_id')) {
            $users = $users->where("city_id", '=', $request->input('city_id'));
        }

        if ($request->input('age_from')) {
            $users = $users->where(DB::raw("TIMESTAMPDIFF(YEAR,birth_date,CURDATE())"), '>=', $request->input('age_from'));
        }

        if ($request->input('age_to')) {
            $users = $users->where(DB::raw("TIMESTAMPDIFF(YEAR,birth_date,CURDATE())"), '<=', $request->input('age_to'));
        }

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

            $users[$key]->age = Helper::ageCalculator($user->birth_date);
            if ($user->city_id <> '0')
                $users[$key]->city = Cities::find($user->city_id)->city;
            else
                $users[$key]->city = "";
        }


        return view()->make('search.user_filter', array('users' => $users, 'cityList' => $cityList, 'city_id' => $request->input('city_id'),
            'age_from' => $request->input('age_from'),
            'age_to' => $request->input('age_to'),
            'gender' => $request->input('gender')));
    }

    public function getMovies(Request $request) {
        $city = $request->user()->city_id;
        $city = 1;
        $cinemas = Cinemas::where("city_id",$city)->orderBy("title")->get();
        $cinemasIds = array_pluck($cinemas,"id");
        $seances = \App\Seances::whereIn("cinema_id",$cinemasIds)->where("start_time",'>',date("Y-m-d H:i:s"))->groupBy("movie_id")->with('getMovie')->get();
        $movies = [];
        foreach($seances as $item)
        {
            $movie = $item->getMovie->getAttributes();
            $poster = json_decode($item->getMovie->poster)->name;
            $movie['poster'] = $poster; //Helper::getPosterLink($poster);
            $movies[] = $movie;
        }
        return view()->make('search.movies_filter',array('movies' => $movies));

    }


    public function getCinemas(Request $request, $id) {
        date_default_timezone_set( 'Europe/Moscow' );

        $city_id = $request->user()->city_id;
        $city_id = 1;

        $cinemas = Cinemas::where("city_id",$city_id)->with(["getSeances" => function($q) use ($id) {
            $q->where("movie_id",$id);
            $q->orderBy("start_time","ASC");
            $q->where("start_time",'>',date("Y-m-d H:i:s"));
        }])->get();
        $data = [];
        foreach($cinemas as $value){
            foreach ($value->getSeances as $item) {
                $data[$value->id][$item->date][] = $item;
            }
        }
        //$cinemasIds = array_pluck($cinemas,"id");
        //$seances = \App\Seances::whereIn("cinema_id",$cinemasIds)->where("movie_id",$id)->with('getCinema')->where("start_time",'>',date("Y-m-d H:i:s"))->get();

        $cinemasNames = [];
        foreach($cinemas as $value){
            $cinemasNames[$value->id] = $value->title;
        }


        return view()->make('search.seances',array('cinemas' => $data, 'names'=>$cinemasNames));

    }

    public function getMovieInfo($id) {
        $movie = Movies::find($id);
        dd($movie);
    }

    public function getCinemaInfo($id) {
        $cinema = Cinemas::find($id);

        return view()->make('search.cinema',['cinema' => $cinema]);
    }


}


?>