<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\User;
use App\Cities;
use App\Helper;
use Validator;
use DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request)
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
            $users[$key]->city = Cities::find($user->city_id)->city;
        }


        return view()->make('search.user_filter', array('users' => $users, 'cityList' => $cityList, 'city_id' => $request->input('city_id'),
            'age_from' => $request->input('age_from'),
            'age_to' => $request->input('age_to'),
            'gender' => $request->input('gender')));
    }

}


?>