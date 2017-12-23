<?php

namespace App\Request;
/**
* 
*/
class Request
{
	
	public static function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public static function getUri()
	{
		return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),'/');
	}

	
}