<?php

namespace App\Container;
/**
* 
*/
class Container
{
	protected static $registry =[];
	public static function bind($key, $value)
	{
		static::$registry[$key] = $value;
		# code...
	}

	public static function get($key)
	{
		return static::$registry[$key];
	}
}