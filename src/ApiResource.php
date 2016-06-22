<?php
namespace Wicket;

use Exception;
use Illuminate\Support\Str;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use Wicket\Entities\Base;
use Wicket\Entities\Factory;

class ApiResource
{
	private $client;
	private $entity;

	/**
	 * ApiResource constructor.
	 * @param \Wicket\Client $client
	 * @param $entity
	 */
	public function __construct(Client $client, $entity)
	{
		$this->client = $client;
		$entity_class = join('\\', [__NAMESPACE__, 'Entities', Str::studly($entity)]);

		try {
			$entity_class = new $entity_class();
			$this->entity = $entity;
		} catch(Exception $e) {
			throw new ClassNotFoundException($e->getMessage(), $entity_class);
		}

		return $entity_class;
	}

	/**
	 * @return WicketCollection A WicketCollection that may be pageable.
	 */
	public function all()
	{
		$response = $this->client->get($this->entity);
		$response = new WicketCollection($response, $this->client);

		return $response;
	}

	public function fetch($id)
	{
		$result = $this->client->get($this->entity . '/' . $id);
		if ($result && array_key_exists('included', $result)) {
			$included = $result['included'];
		}
		if ($result && array_key_exists('data', $result)) {
			$result = Factory::create($result['data'], true);
		}
		if (!empty($included)) {
			$result->addIncluded($included);
		}
		return $result;
	}

	public function create(Base $entity, $parent_tree = null)
	{
		$entity_create_url = '';

		if ($parent_tree) {
			if (class_basename(get_class($parent_tree)) != 'Collection') {
				if (!is_array($parent_tree)) {
					$parent_tree = [$parent_tree];
				}
				$parent_tree = collect($parent_tree);
			}

			$entity_create_url = $parent_tree->reduce(function ($url, $ent) {
				return $url . '/' . $ent->type . '/' . $ent->id;
			});
		}
		$entity_create_url .= '/' . $entity->type;
		$payload = ['json' => $entity->toJsonAPI()];
		$res = $this->client->post(ltrim($entity_create_url, '/'), $payload);

		return $res;
	}

	public function update(Base $entity)
	{
		$entity_create_url = '';
		$entity_create_url .= '/' . $entity->type;
		$payload = ['json' => $entity->toJsonAPI()];
		$res = $this->client->patch(ltrim($entity_create_url, '/').'/'.$entity->id, $payload);
		return $res;
	}

	/**
	 * Posts newly created entities for existing entites. (ex: address to person)
	 * @param Base $entity Usually a person object.
	 * @param Base $entity A new entity to be added to the parent.
	 */
	public function add_entity(Base $entity, Base $added_entity)
	{
		$entity_create_url = '';
		$entity_create_url .= $entity->type.'/'.$entity->id.'/'.$added_entity->type;
		$payload = ['json' => $added_entity->toJsonAPI()];
		$res = $this->client->post($entity_create_url, $payload);
		return $res;
	}

	public function delete()
	{
		// TODO: Implement delete() method.
	}

}
