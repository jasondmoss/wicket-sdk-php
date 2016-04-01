<?php
namespace Wicket;


use GuzzleHttp;
use Psr\Http\Message\ResponseInterface;

class Wicket
{
	private $api_endpoint = 'http://localhost:3000/';
	private $api_key = null;
	private $last_error = null;
	private $last_request = [];
	private $last_response = null;
	private $timeout = 10;

	/**
	 * Wicket constructor.
	 * @param $api_key
	 */
	public function __construct($api_key = null)
	{
		$this->api_key = $api_key;
	}

	/**
	 * @return null
	 */
	public function getLastError()
	{
		return $this->last_error ? $this->last_error : false;
	}

	/**
	 * @return null
	 */
	public function getLastRequest()
	{
		return $this->last_request;
	}

	/**
	 * @return null
	 */
	public function getLastResponse()
	{
		return $this->last_response ? $this->last_response : false;
	}

	/**
	 * get current onnection timeout
	 *
	 * @return int
	 */
	public function getTimeout()
	{
		return $this->timeout;
	}

	/**
	 * set current onnection timeout
	 *
	 * @param int $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->timeout = $timeout;
	}

	/**
	 * Make an HTTP GET request - for retrieving data
	 * @param   string $method URL of the API request method
	 * @param   array $args Assoc array of arguments (usually your data)
	 * @return  array|false   Assoc array of API response, decoded from JSON
	 */
	public function get($method, $args = [])
	{
		return $this->makeRequest('get', $method, $args);
	}

	public function post($method, $args = [])
	{
		return $this->makeRequest('post', $method, $args);
	}

	public function put($method, $args = [])
	{
		return $this->makeRequest('put', $method, $args);
	}

	public function patch($method, $args = [])
	{
		return $this->makeRequest('patch', $method, $args);
	}

	public function delete($method, $args = [])
	{
		return $this->makeRequest('delete', $method, $args);
	}

	public function hasWickets($bool = true)
	{
		return $bool;
	}

	private function makeRequest($http_verb = 'GET', $method, $args)
	{
		$http_verb = strtoupper($http_verb);
		printf("wSDK attempt %s connect: %s%s\n", $http_verb, $this->api_endpoint, $method);
		$uri = $this->api_endpoint . '/' . $method;

		$this->last_error = '';
		$this->last_response = null;
		$this->last_request = array_merge([
				'method'  => $http_verb,
				'uri'     => $uri,
				'timeout' => $this->timeout,
				'options' => $args,
			]
			, parse_url($uri)
		);

		$client = new GuzzleHttp\Client(['base_uri' => $this->api_endpoint]);
		$response = $client->request($http_verb, $method, $args);

		return $this->formatResponse($response);
	}

	/**
	 * Decode the response and format any error messages for debugging
	 * @param ResponseInterface $response The response from the http request
	 * @return array|false The JSON decoded into an array
	 */
	private function formatResponse(ResponseInterface $response)
	{
		$this->last_response = $response;

		$body = $response->getBody();

		if (!empty($body)) {
			$contents = json_decode($body->getContents(), true);

			$statusCode = $response->getStatusCode();
			if ($statusCode !== 200) {
				$this->last_error = sprintf('%d: %s', $statusCode, $response->getReasonPhrase());
			}

			return $contents;
		}

		return false;
	}
}