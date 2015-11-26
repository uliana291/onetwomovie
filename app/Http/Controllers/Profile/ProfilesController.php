<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Messages;
use App\Seances;
use App\User;
use App\Cities;
use App\Helper;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Http\Request;
use DataTime;
use DateInterval;
use Image;
use Illuminate\Support\Facades\DB;
use \Google_Client;
use \Google_Service_Calendar;
use Illuminate\Support\Facades\Response;
use Google_Service_Calendar_Event;
use DateTime;

define('CREDENTIALS_PATH', '~/.credentials/calendar-php-credentials.json');
define('CLIENT_SECRET_PATH', base_path('client_secret.json'));
define('SCOPES', implode(' ', array(
        Google_Service_Calendar::CALENDAR)
));

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

    public function sendMessage(Request $request, $dialog)
    {
        $msg = [];
        $msg ['message'] = $request->input('messageArea');
        $msg ['user_id_sent'] = $request->user()->id;
        $msg ['user_id_received'] = $request->input('userHidden');
        $msg ['dialog_num'] = $dialog;
        Messages::create($msg);
        return redirect()->back();
    }

    public function showSeanceInfo(Request $request, $dialog, $id)
    {
        $seance = Seances::where('id', $id)->with('getCinema')->with('getMovie')->first();

        return view()->make('user.seance_info', ['seance' => $seance]);
    }


    public function addToCalendar(Request $request, $dialog, $id)
    {

        $client = new Google_Client();
        $client->setScopes(SCOPES);
        $client->setAuthConfigFile(CLIENT_SECRET_PATH);
        //$client->setAccessType('offline');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google_calendar_callback');
        $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);

        $request->session()->put('dialog',$dialog);
        $request->session()->put('seance',$id);

        // Request authorization from the user.
        if (file_exists($credentialsPath)) {
            $accessToken = file_get_contents($credentialsPath);
            $client->setAccessToken($accessToken);

            // Refresh the token if it's expired.
            if ($client->isAccessTokenExpired()) {
                $client->refreshToken($client->getRefreshToken());
                file_put_contents($credentialsPath, $client->getAccessToken());
            }
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            return Response::make('', 302)->header('Location', filter_var($authUrl, FILTER_SANITIZE_URL));
        }

        $d = Messages::where('dialog_num', $dialog)->first();
        $user = User::where('id', ($d->user_id_received == $request->user()->id ? $d->user_id_sent : $d->user_id_received))
            ->first();
        $seance = Seances::where('id', $id)->with('getCinema')->with('getMovie')->first();
        $service = new Google_Service_Calendar($client);

        $start_date = new DateTime($seance->start_time);
        $start_date->sub(new DateInterval('PT3H'));
        $end_date = new DateTime($seance->start_time);

        $end_date->add(new DateInterval('PT' . $seance->getMovie->duration . 'M'));
        $end_date->sub(new DateInterval('PT3H'));

        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Поход в кино',
            'location' => Cities::find($seance->getCinema->city_id)->first()->city . ", " . $seance->getCinema->address,
            'description' => $seance->getMovie->title,
            'start' => array(
                'dateTime' => $start_date->format('Y-m-d\TH:i:sP'),
                'timeZone' => 'Europe/Moscow',
            ),
            'end' => array(
                'dateTime' => $end_date->format('Y-m-d\TH:i:sP'),
                'timeZone' => 'Europe/Moscow',
            ),
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=1'
            ),
            'attendees' => array(
                array('email' => $user->email)
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));
        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);

        return Response::make('', 302)->header('Location', filter_var($event->htmlLink, FILTER_SANITIZE_URL));

    }


    private function expandHomeDirectory($path)
    {
        $homeDirectory = getenv('HOMEDRIVE');

        if (empty($homeDirectory)) {
            $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
        }

        return str_replace('~', realpath($homeDirectory), $path);
    }

    public function getGoogleAuth(Request $request)
    {

        $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
        $client = new Google_Client();
        $client->setScopes(SCOPES);
        $client->setAuthConfigFile(CLIENT_SECRET_PATH);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google_calendar_callback');


        $authCode = $request->input('code');

        $accessToken = $client->authenticate($authCode);


        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, $accessToken);


        $client->setAccessToken($accessToken);


        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, $client->getAccessToken());
        }


        return redirect()->route('calendar_back', [$request->session()->get('dialog'), $request->session()->get('seance')], 302);

    }

}

?>