<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VkAuthController extends Controller
{

    private function make_auth_url(Request $request, $type)
    {
        $data = json_decode(file_get_contents(base_path("client_secret2.json")));
        $client_id = $data->vkAppId;
        if ($type == 1) {
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/vk_callback';
            $request = "https://oauth.vk.com/authorize?client_id=$client_id&display=page&scope=offline,wall&response_type=code&v=5.40";
            return $request;
        } else {
            $authCode = $request->input('code');
            $client_secret = $data->vkKey;
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/vk_callback';
            $request = "https://oauth.vk.com/access_token?client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect_uri&code=$authCode";
            return $request;
        }
    }

    public function getHiddenLink(Request $request)
    {
        if ($request->user()->id == 1) {
            return view()->make('vk_hidden');
        }
    }

    public function clearWall(Request $request)
    {

        $authUrl = $this->make_auth_url($request, 1);
        return Response::make('', 302)->header('Location', filter_var($authUrl, FILTER_SANITIZE_URL));
    }


    public function getVkAuth(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//https://oauth.vk.com/authorize?client_id=5178304&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=offline,wall&response_type=token
//094cdf31fa10268029f6e192f06148e552a6aa65815dec483e6a1646a9d75878557eabf12a5d354edffdd
        if (!$request->session()->get('access_token_vk')) {
            $token = '094cdf31fa10268029f6e192f06148e552a6aa65815dec483e6a1646a9d75878557eabf12a5d354edffdd';
            $request->session()->put('access_token_vk', $token->access_token);
        } else {
            $token = $request->session()->get('access_token_vk');
            $token = '094cdf31fa10268029f6e192f06148e552a6aa65815dec483e6a1646a9d75878557eabf12a5d354edffdd';
            $url = "https://api.vk.com/method/users.getNearby?user_id=4244432&offset=0&count=100&v=5.40&access_token=$token";
            curl_setopt($ch, CURLOPT_URL, $url);





        }
        curl_close($ch);
    }
}
