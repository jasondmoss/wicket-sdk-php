<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 12/04/16
 * Time: 2:56 PM
 */

namespace Wicket\Entities;


use Illuminate\Support\Str;

class Factory
{
	/**
	 * Factory to create Wicket\Entities from JSON:API style response.
	 * 
	 * @param array $data JSON:API data block.
	 * @param bool $related Traverse base `relationships`?
	 * @return \Wicket\Entities\Base
	 */
	public static function create($data, $related = false)
	{
		$json_api_keys = array_intersect_key($data, array_flip(['type', 'id']));

		if (!count($json_api_keys) >= 2) {
			throw new \InvalidArgumentException('Are you sure this data is JSON:API?' . print_r($data, 1));
		}

		$className = join('\\', [__NAMESPACE__, Str::studly($data['type'])]);

		if (!class_exists($className)) {
			$className = join('\\', [__NAMESPACE__, 'Base']);
		}

		/** @var Base $entity */
		$entity = new $className($data['type'], $data['id']);

		if (array_key_exists('attributes', $data)) {
			foreach ($data['attributes'] as $k => $related) {
				$entity->setAttribute($k, $related);
			}
		}

		if ($related && array_key_exists('relationships', $data)) {
			foreach ($data['relationships'] as $k => $related) {
				if (array_key_exists('data', $related) && !empty($related['data'])) {
					$reldata = $related['data'];
					if (!is_array($reldata)) $reldata = [$reldata];

					foreach ($reldata as $relation) {
						$entity->addRelationship($k, Factory::create($relation));
					}
				}
			}
		}

		return $entity;
	}

}