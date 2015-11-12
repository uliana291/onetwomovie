<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\User;
use App\Cities;
use Validator;
use Illuminate\Http\Request;

class ProfilesController extends Controller {


    public function __construct()
    {
        $this->middleware('auth');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'last_name'=> 'required|max:255',
            'email' => 'required|email|max:255',
            'city_id' => 'required',
            'status' => 'required|in:enable,disable',
            'birth_date' => 'required|date'
        ]);
    }


    public function showProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        $cities = Cities::where('country_id','=',1)->limit(300)->get();

        $cityList = [];
        foreach($cities as $key => $value) {
            $cityList[$value->id] = $value->city;
        }

        return view()->make('user.profile', array('user' => $user, 'cityList' => $cityList));
    }

    public function saveProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        $user->name = $request->input('name');

        $user->last_name = $request->input('last_name');

        $user->city_id = $request->input('city_id');

        $user->status = $request->input('status');

        $user->birth_date = $request->input('birth_date');

        $user->about = $request->input('about');

        $user->skype = $request->input('skype');

        $user->vk = $request->input('vk');

        $user->save();
    }


}


?>