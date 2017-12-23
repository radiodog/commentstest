<?php

namespace App\Database;

use \Exception;
use \PDO;
/**
* 
*/
class Connection
{
	
	public static function make($config)
	{
		try {
			//return new PDO('mysql:host=127.0.0.1;dbname=mydb','root','21346976');
			return new PDO($config['connection'].';dbname='.$config['name'],$config['user'],$config['password'],$config['options']);
			
		} catch (Exception $e) {
			die($e->getMessage());
		}
		# code...
	}
}