<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Messages;
use App\Seances;
use App\User;
use App\Cities;
use App\Session;
use Validator;
use Illuminate\Http\Request;
use DataTime;
use DateInterval;
use Image;
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

class GoogleAuthController extends Controller
{

    public function addToCalendar(Request $request, $dialog, $id)
    {

        $client = new Google_Client();
        $client->setScopes(SCOPES);
        $client->setAuthConfigFile(CLIENT_SECRET_PATH);
        //$client->setAccessType('offline');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google_calendar_callback');
        //  $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);

        $request->session()->put('dialog', $dialog);
        $request->session()->put('seance', $id);

        // Request authorization from the user.
        if ($request->session()->get('access_token')) {
            $accessToken = $request->session()->get('access_token');
            $client->setAccessToken($accessToken);

            // Refresh the token if it's expired.
            if ($client->isAccessTokenExpired()) {
                $client->refreshToken(Session::find($request->session()->getId()));
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


    public function getGoogleAuth(Request $request)
    {
        $client = new Google_Client();
        $client->setScopes(SCOPES);
        $client->setAuthConfigFile(CLIENT_SECRET_PATH);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google_calendar_callback');


        $authCode = $request->input('code');

        $accessToken = $client->authenticate($authCode);

        $client->setAccessToken($accessToken);

        $request->session()->put('access_token', $client->getAccessToken());

        $authObj = json_decode($accessToken);


        if (isset($authObj->refresh_token)) {
            $session = Session::firstOrNew($request->session()->getId());
            $session->refresh_token = $authObj->refresh_token;
            $session->save();

        }
        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken(Session::find($request->session()->getId()));
        }


        return redirect()->route('calendar_back', [$request->session()->get('dialog'), $request->session()->get('seance')], 302);

    }

}
