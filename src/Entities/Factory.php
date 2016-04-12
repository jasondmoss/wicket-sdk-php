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
	 * Factory constructor.
	 * @param $data
	 * @return Base
	 */
	public static function create($data)
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
			foreach ($data['attributes'] as $k => $v) {
				$entity->setAttribute($k, $v);
			}
		}

		if (array_key_exists('relationships', $data)) {
			foreach ($data['relationships'] as $k => $v) {
				if (array_key_exists('data', $v) && !empty($v['data'])) {
					printf("addRelation: %s\n", $k);
					$reldata = $v['data'];
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