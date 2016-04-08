<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 08/04/16
 * Time: 3:49 PM
 */

namespace Wicket\Entities;


/**
 * Class Base
 * Maybe checkout \Illuminate\Database\Eloquent\Model for a little motivation for the BaseClass
 * 
 * @package Wicket\Entities
 */
class Base
{
	protected $attributes;

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
		if (array_key_exists($key, $this->attributes)) return $this->attributes[$key];
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

}