<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\User;
use App\Cities;
use App\Helper;
use Validator;
use Illuminate\Http\Request;
use DataTime;
use Image;

class ProfilesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showProfile(Request $request, $id = null)
    {
        $user = User::find(($id != null ? $id : $request->user()->id));

        if ($user <> null) {
            if ($user->city_id <> 0)
                $city = Cities::find($user->city_id);
            else
                $city = null;

            if ($user->birth_date <> "0000-00-00")
                $user->age = Helper::ageCalculator($user->birth_date);


            if ($user->ava <> null) {
                $img = $user->ava;
                $user->ava = '/upload/' . $img;
            }

            if ($user->id == $request->user()->id)
                $user->self = true;
            else
                $user->self = false;

            return view()->make('user.show', array('user' => $user, 'city' => $city));
        } else {
            return view()->make('error.access_denied');
        }
    }


    public function editProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        $cities = Cities::orderBy('city')->get();

        $cityList = [];
        foreach ($cities as $key => $value) {
            $cityList[$value->id] = $value->city;
        }

        return view()->make('user.edit', array('user' => $user, 'cityList' => $cityList));
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

        $arrayData = array_only($request->all(),['name','last_name','gender','city_id','status','birth_date','about','skype','vk','mobile_number']);

        $arrayData['status'] = ($request->input('status') == null ? "disable" : "enable");

        if ($request->file('ava') <> null) {

            $imageName = $request->user()->id . '.' .
                $request->file('ava')->getClientOriginalExtension();

            $arrayData['ava'] = $imageName;

            $request->file('ava')->move(
                base_path() . '/public/upload/', $imageName
            );

            $img = \Image::make(base_path() . '/public/upload/' . $imageName);

            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $img->crop(200, 200, 0, 0)->save();
        }

        User::where("id",$request->user()->id)->update($arrayData);

        return redirect()->back()->with('error', 0)->with('message', 'Профиль успешно обновлен.');

    }

}


?>