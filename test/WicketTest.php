<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 15/03/16
 * Time: 2:47 PM
 */

namespace Wicket;


class WicketTest extends \PHPUnit_Framework_TestCase
{

	public function testWicketHasWickets()
	{
		$wicket = new Client('app_key', 'api_key');
		$this->assertNotEmpty($wicket);
	}

}