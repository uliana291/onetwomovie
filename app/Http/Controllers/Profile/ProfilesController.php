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
            $city = Cities::find($user->city_id);

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

        $cities = Cities::where('country_id', '=', 1)->limit(300)->get();

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

        $user = User::find($request->user()->id);

        $user->name = $request->input('name');

        $user->last_name = $request->input('last_name');

        $user->gender = $request->input('gender');

        $user->city_id = $request->input('city_id');

        $user->status = ($request->input('status') == null ? "disable" : "enable");

        $user->birth_date = $request->input('birth_date');

        $user->about = $request->input('about');

        $user->skype = $request->input('skype');

        $user->vk = $request->input('vk');

        $user->mobile_number = $request->input('mobile_number');

        if ($request->file('ava') <> null) {

            $imageName = $user->id . '.' .
                $request->file('ava')->getClientOriginalExtension();

            $user->ava = $imageName;

            $request->file('ava')->move(
                base_path() . '/public/upload/', $imageName
            );

            $img = \Image::make(base_path() . '/public/upload/' . $imageName);

            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $img->crop(200, 200, 0, 0)->save();


        }
        $user->save();

        return redirect()->back()->with('error', 0)->with('message', 'Профиль успешно обновлен.');

    }

    public static function getImage($id, $width, $height) {
        $user = User::find($id);
        $img = Image::make(public_path("upload/".$user->ava));

        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->crop($width, $height, 0, 0);

        $response = response()->make($img->encode('png'));
        $response->header('Content-Type', 'image/png');
        return $response;
    }


}


?>