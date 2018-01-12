<?php

namespace App\Controllers\CustomClasses;

// use App\CustomClasses\Paginator;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

/**
* Guzzle HTTP Requests all round.
*/
class GuzzleWrapper
{
public $url;
public $vendorId;
public $apiKey;
public $defaultHeader;
	function __construct($url = null, $vendorId = null, $apiKey = null)
	{
		$this->url = $url;
		$this->vendorId = $vendorId;
		$this->apiKey = $apiKey;
		$this->defaultHeader = ['Content-Type' => 'application/json'];
	}
//get data from the api
	public function getData()
	{
		$client = new Client();
        $request = $client->get($this->url,[
    	'headers' => [
    		'Content-Type' => 'application/json',
			'vendorId' => $this->vendorId,
			'apiKey' => $this->apiKey
        ],
        ]);
        $response = $request->getBody();
        return $data = json_decode($response, true);
	}

// post data to the api
	public function postData($data,$url='')//json data
	{
        $this->url = (empty($url))?$this->url:$url;
        // Log::info('Sending Headers'.json_encode($headers)."---Data ".json_encode($data)."--to URL: ".$this->url);
	    $this->url = (empty($url))?$this->url:$url;
		$client = new Client();
		// for uniwallet pass the data into the body; json encoded data
		$data = json_encode($data);
        $request = $client->post($this->url, [
        	// 'headers' => array_merge($this->defaultHeader,$headers),
        	'body'=>$data,
            ]);
        //request status messages
        $response = $request->getBody();

        $response = json_decode($response, true);
        return $response;
	}

    public function doGet($headers=array(),$url)
    {
        $client = new Client();
        $this->url = (empty($url))?$this->url:$url;
        Log::info('Sending Headers'.json_encode($headers)."--to URL: ".$this->url);
        $request = $client->get($this->url, [
                'headers' => array_merge($this->defaultHeader,$headers)
            ]);
        $response = $request->getBody();
        return $data = json_decode($response, true);
    }

    public function post($data,$headers=array(),$url='')//json data
	{
	    $this->url = ($url)?$this->url:$url;
		$client = new Client();
		// for uniwallet pass the data into the body; json encoded data
		// $data = json_encode($data);
		// $data = base64_encode($data)
        $request = $client->post($this->url, [
        	'headers' => $this->defaultHeaders,
        	'body'=>$data,
            ]);
        //request status messages
        $response = $request->getBody();
        $response = json_decode($response, true);
        return $response;
	}
    public function postToFirebase($data,$headers=array(),$url='https://testprojectgen.firebaseio.com/AvailableBillers.json')//json data
    {
        //if you dont pass the url in the constructor, use the one passed in the method.
        $this->url = (empty($url))?$this->url:$url;
        Log::info('Sending Headers'.json_encode($headers)."---Data ".json_encode($data)."--to URL: ".$this->url);
        $this->url = (empty($url))?$this->url:$url;


        // $client = new Client([
        //     // Base URI is used with relative requests
        //     'base_uri' => 'https://[YOUR_FIREBASE_SECRET].firebaseio.com/',
        //     // You can set any number of default request options.
        //     'timeout'  => 2.0, // optional
        //     'verify'=> false,
        //     'debug' => true, // optional
        // ]);
$client = new Client();
        // data must be json for firebase.
        $data = json_encode($data);
        $request = $client->post($this->url, [
            // 'headers' => array_merge($this->defaultHeader,$headers),
            'json'=>$data,
            ]);
        //request status messages
        $response = $request->getBody();

        $response = json_decode($response, true);
        return $response;
    }
}
