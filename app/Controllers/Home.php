<?php

namespace App\Controllers;
require 'vendor/autoload.php';
use Bitly\BitlyClient;
class Home extends BaseController
{
	public function index(){
		
		return view('welcome_message');
	}

	public function conventURL(){
		$bitlyClient = new BitlyClient('e9e2d5c823d4050346c6f3a21681e94b21b71d70');
		$options = [
			'longUrl' => $_POST['url']
		];
		$response = $bitlyClient->shorten($options);
		return $response->data->url;
	}
}
