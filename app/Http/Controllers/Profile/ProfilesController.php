<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\User;
use App\Cities;
use Validator;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        $cities = Cities::where('country_id', '=', 1)->limit(300)->get();

        $cityList = [];
        foreach ($cities as $key => $value) {
            $cityList[$value->id] = $value->city;
        }

        return view()->make('user.profile', array('user' => $user, 'cityList' => $cityList));
    }

    public function saveProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'city_id' => 'required',
            'birth_date' => 'required|date',
            'ava' => 'mimes:png,jpeg'
        ]);

        $user = User::find($request->user()->id);

        $user->name = $request->input('name');

        $user->last_name = $request->input('last_name');

        $user->city_id = $request->input('city_id');

        $user->status = ($request->input('status') == null ? "disable" : "enable");

        $user->birth_date = $request->input('birth_date');

        $user->about = $request->input('about');

        $user->skype = $request->input('skype');

        $user->vk = $request->input('vk');

        if ($request->file('ava') <> null) {

            $imageName = $user->id . '.' .
                $request->file('ava')->getClientOriginalExtension();

            $user->ava = $imageName;

            $request->file('ava')->move(
                base_path() . '/public/upload/', $imageName
            );

        }
        $user->save();

        return redirect()->back()->with('error', 0)->with('message', 'Профиль успешно обновлен.');

    }


}


?>