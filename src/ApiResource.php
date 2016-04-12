<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 08/04/16
 * Time: 2:26 PM
 */

namespace Wicket;


use Exception;
use Illuminate\Support\Str;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use Wicket\Entities\Factory;

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

		$entity_class = join('\\', [__NAMESPACE__, 'Entities', Str::studly($entity)]);

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
		printf("\n%s()\n", __METHOD__);

		$res = $this->client->get($this->entity);

		return $res;
	}

	public function fetch($id)
	{
		printf("\n%s(%s)\n", __METHOD__, $id);

		$result = $this->client->get($this->entity . '/' . $id);

		if ($result && array_key_exists('data', $result)) {
			$result = Factory::create($result['data']);
		}

		return $result;
	}

	public function create()
	{
		printf("\n%s %s\n", __CLASS__, __FUNCTION__);

		$res = $this->client->post($this->entity);
	}

	public function update()
	{
		printf("\n%s(%s)\n", __METHOD__, $id);
		// TODO: Implement update() method.
	}

	public function delete()
	{
		// TODO: Implement delete() method.
	}

}