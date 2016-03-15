<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 14/03/16
 * Time: 10:28 AM
 */

namespace Wicket;


use GuzzleHttp\Client;

class Wicket
{
	private $api_key;
	private $api_endpoint  = 'http://localhost:3000/';

	/**
	 * Wicket constructor.
	 * @param $api_key
	 */
	public function __construct($api_key = null)
	{
		$this->api_key = $api_key;
	}

	/**
	 * Make an HTTP GET request - for retrieving data
	 * @param   string  $method   URL of the API request method
	 * @param   array   $args     Assoc array of arguments (usually your data)
	 * @param   int     $timeout  Timeout limit for request in seconds
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function get($method, $args=array(), $timeout=10)
	{
		$client = new Client(['base_url' => $this->api_endpoint]);
		return $client->get($method)->json();
	}

	public function hasWickets($bool = true)
	{
		return $bool;
	}

}