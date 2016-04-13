<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 08/04/16
 * Time: 2:42 PM
 */

namespace Wicket\Entities;


class Organizations extends Base
{
	public function __construct($data = null)
	{
		parent::__construct(strtolower(class_basename(__CLASS__)));

		// set class attributes
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$this->$k = $v;
			}
		}
	}
}