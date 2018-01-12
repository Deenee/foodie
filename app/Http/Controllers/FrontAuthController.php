<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers\CustomClasses\GuzzleWrapper;
use GuzzleHttp\Client;

class FrontAuthController extends Controller
{

    public function index()
    {
        return view('pages.login');
    }
    
    public function login()
    {
        $url = "http://localhost:8991" . '/api/login';
        $client = new Client();

		// for uniwallet pass the data into the body; json encoded data
        $data = json_encode(request()->except('_token'));
        
            $request = $client->post($url, [
            'body' => $data,
        ]);
        dd('here');
        //request status messages
        $response = $request->getBody();

        $response = json_decode($response, true);
        return $response;

        $client = new GuzzleWrapper($url);
        $client->postData(request()->all());
        return $client;
    }
}
