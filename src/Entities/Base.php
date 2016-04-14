<?php
namespace Wicket\Entities;

/**
 * Class Base
 * Maybe checkout \Illuminate\Database\Eloquent\Model for a little motivation for the BaseClass
 *
 * @package Wicket\Entities
 */
class Base
{
	public $type;
	public $id;
	protected $attributes;
	protected $relationships;
	protected $meta;

	/**
	 * Base constructor.
	 * @param array|null $attributes
	 * @param null $type
	 * @param null $id
	 */
	public function __construct($attributes = [], $type = null, $id = null)
	{
		$this->attributes = $attributes;
		$this->type = $type;
		$this->id = $id;
	}

	/**
	 * Dynamically retrieve attributes on the model.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->getAttribute($key);
	}

	/**
	 * Dynamically set attributes on the model.
	 *
	 * @param  string $key
	 * @param  mixed $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->setAttribute($key, $value);
	}

	/**
	 * Get an attribute from the model.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function getAttribute($key)
	{
		if (array_key_exists($key, $this->attributes)) {
			return $this->attributes[$key];
		}
	}

	/**
	 * Set a given attribute on the model.
	 *
	 * @param  string $key
	 * @param  mixed $value
	 * @return $this
	 */
	public function setAttribute($key, $value)
	{
		$this->attributes[$key] = $value;

		return $this;
	}

	/**
	 * Add entity relationship with explicit type control.
	 *
	 * @param $type
	 * @param Base $entity
	 */
	public function addRelationship($type, Base $entity)
	{
		$this->relationships[$type][] = $entity;
	}

	/**
	 * Add entity relationship using implicit entity type.
	 *
	 * @param Base $entity
	 */
	public function attach(Base $entity)
	{
		$this->relationships[$entity->type][] = $entity;
	}

	public function toJsonAPI()
	{
		return ['data' => [
			'attributes'    => $this->attributes,
			'relationships' => $this->relationshipsJsonAPI(),
		]];
	}

	private function relationshipsJsonAPI()
	{
		$encodable = [];
		foreach ($this->relationships as $type => $entityList) {
			$ents = collect($entityList);

			$tattrs = $ents->transform(function ($item, $key) {
				return [
					'type'       => $item->type,
					'attributes' => $item->attributes,
				];
			});

			$encodable[$type] = ['data' => $tattrs->toArray()];
		}

		return ($encodable);
	}

}