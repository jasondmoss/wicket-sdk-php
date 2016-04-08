<?php
/**
 * Created by IntelliJ IDEA.
 * User: scott
 * Date: 08/04/16
 * Time: 1:16 PM
 */

namespace Wicket\Entities;


/**
 * Interface WicketResource
 * @deprecated by ApiResource a/o Base
 * @package Wicket\Entities
 */
interface WicketResource
{
	public function all();
	public function fetch();
	public function create();
	public function update();
	public function delete();

	//public function relationships()->sync()
	//public function relationships()->attach()
	//public function relationships()->detach()

}