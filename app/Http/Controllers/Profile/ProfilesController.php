<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Messages;
use App\Seances;
use App\User;
use App\Cities;
use App\Helper;
use Validator;
use Illuminate\Http\Request;
use DataTime;
use Image;
use Illuminate\Support\Facades\DB;


class ProfilesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function sendEmailReminder(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
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


            if ($user->ava <> 'noava.jpeg') {
                $img = $user->ava;
                $user->ava = '/upload/' . $img;
            } else
                $user->ava = '/images/noava.jpeg';

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

        $arrayData = array_only($request->all(), ['name', 'last_name', 'gender', 'city_id', 'status', 'birth_date', 'about', 'skype', 'vk', 'mobile_number']);

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

        User::where("id", $request->user()->id)->update($arrayData);

        return redirect()->back()->with('error', 0)->with('message', 'Профиль успешно обновлен.');

    }

    public function showMessages(Request $request)
    {
        $id = $request->user()->id;
        $sql = DB::select(DB::raw("select * from (select * from `messages` where `user_id_received` = " . $id . " or `user_id_sent` = " . $id . " order by `created_at` desc) as `messages` group by `dialog_num`"));

        $ids = [];
        foreach ($sql as $item) {
            $ids[] = $item->id;
        }
        $msgs = Messages::whereIn("id", $ids)
            ->with('getSender')
            ->with('getReceiver')
            ->orderBy("created_at", "DESC")
            ->get();

        return view()->make('user.messages', array('messages' => $msgs, 'id' => $id));
    }

    public function showDialog(Request $request, $dialog)
    {
        $id = $request->user()->id;
        $msgs = Messages::where("dialog_num", $dialog)->orderBy("created_at",
            "ASC")->with('getSender')->with('getReceiver')->with('getSeance')->get();
        $any_msg = $msgs->first();
        $dialog_with = ($any_msg->getReceiver->id == $id ? $any_msg->getSender : $any_msg->getReceiver);
        foreach ($msgs as $msg) {
            if ($msg->getReceiver->id == $id) {
                $msg->read = 1;
                $msg->update();
            }
        }


        return view()->make('user.dialog', array('messages' => $msgs, 'id' => $id, 'dialog_with' => $dialog_with));
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request,
            array('messageArea' => 'required'),
            array(
                'messageArea.required' => 'Сообщение не должно быть пустым'
            ));

        $msg = [];
        $msg ['message'] = $request->input('messageArea');
        $msg ['user_id_sent'] = $request->user()->id;
        $msg ['user_id_received'] = $request->input('userHidden');
        $ids = [$msg['user_id_sent'], $msg['user_id_received']];
        $b = $msg['user_id_sent'] == $msg['user_id_received'];
        if ($b)
            $res = Messages::whereIn('user_id_sent', $ids)->whereIn('user_id_received', $ids)->first();
        else
            $res = Messages::whereIn('user_id_sent', $ids)->whereIn('user_id_received', $ids)->whereRaw('user_id_received <> user_id_sent')->first();

        if (count($res) == 0)
            if (Messages::count() <> 0)
                $msg['dialog_num'] = Messages::orderBy('dialog_num', 'DESC')->first()->dialog_num + 1;
            else
                $msg['dialog_num'] = 1;
        else
            $msg['dialog_num'] = $res->dialog_num;
        Messages::create($msg);
        return redirect()->back();
    }

    public function showSeanceInfo(Request $request, $dialog, $id)
    {
        $seance = Seances::where('id', $id)->with('getCinema')->with('getMovie')->first();

        return view()->make('user.seance_info', ['seance' => $seance]);
    }


}

?>