<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 12/04/16
 * Time: 6:38 PM
 */

namespace Wicket\Entities;


class Emails extends Base
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