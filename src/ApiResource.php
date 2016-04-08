<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 08/04/16
 * Time: 2:26 PM
 */

namespace Wicket;


use Exception;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class ApiResource
{
	private $client;
	private $entity;

	/**
	 * ApiResource constructor.
	 * @param $entity
	 */
	public function __construct(Client $client, $entity)
	{
		$this->client = $client;

		$entity_class = sprintf('\Wicket\Entities\%s', str_replace(' ', '', ucwords(str_replace('_', ' ', $entity))));

		try {
			$entity_class = new $entity_class();

			$this->entity = $entity;
		} catch (Exception $e) {
			throw new ClassNotFoundException($e->getMessage(), $entity_class);
		}

		return $entity_class;
	}

	public function all()
	{
		echo "api_res->all";

		$res = $this->client->get($this->entity);
		
		$data = $res['data'][0];
		print_r($data);
	}

	public function fetch()
	{
		// TODO: Implement fetch() method.
	}

	public function create()
	{
		// TODO: Implement create() method.
	}

	public function update()
	{
		// TODO: Implement update() method.
	}

	public function delete()
	{
		// TODO: Implement delete() method.
	}

}