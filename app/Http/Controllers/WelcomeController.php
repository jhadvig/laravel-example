<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$hostname = getenv('HOSTNAME') ?: 'unknown';
		$engine = getenv('DATABASE_ENGINE') ?: 'unknown';
		// $host = getenv('DATABASE_SERVICE_HOST') ?: '';
		// $port = getenv('DATABASE_SERVICE_PORT') ?: '';

		if ($engine == 'unknown') {
			$socket = 'unknown';
		} else {
			$socket = getenv('DATABASE_SERVICE_HOST') . ":" . getenv('DATABASE_SERVICE_PORT');
		}

		$data = array('engine' => $engine, 
					 	'socket' => $socket,
					 	'hostname' => $hostname);

		return view('welcome')->with($data);
	}

}