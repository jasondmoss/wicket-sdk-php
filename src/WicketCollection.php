<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 15/04/16
 * Time: 3:35 PM
 */

namespace Wicket;


use Illuminate\Support\Collection;
use Wicket\Entities\Base;

/*
 * Merge pagination and collection here.
 *
 * https://laravel.com/docs/5.2/pagination
 * https://developers.facebook.com/docs/php/howto/example_pagination_basic
 */

class WicketCollection
	extends Collection
{
	/**
	 * WicketCollection constructor.
	 * @param array|false $response
	 */
	public function __construct($response)
	{
		$ent_list = array_map(function ($ent) {
			return Base::fromJsonAPI($ent);
		}, data_get($response, 'data', []));

		parent::__construct($ent_list);
	}

}