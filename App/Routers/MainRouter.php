<?php

namespace App\Routers;

use \Exception;
/**

* 
*/
class MainRouter
{
	private $routes = [
		'GET'=>[],
		'POST'=>[]
	];

	public static function loadRoutes()
	{
		$router = new self;
		require 'routes.php';
		return $router;
	}

	public function get($uri, $controller)
	{
		$this->routes['GET'][$uri] = $controller;
	}

	public function post($uri, $controller)
	{
		$this->routes['POST'][$uri] = $controller;
	}

	public function direct($uri, $requestType)
	{
		if (array_key_exists($uri, $this->routes[$requestType])) {
			return $this->run($this->routes[$requestType][$uri]);
		}
		throw new Exception("this route not exist");
		
	}

	public function run($request)
	{
		$controllerName = explode('@',$request)[0];
		$controllerName = "App\\Controllers\\{$controllerName}";
		$actionName = explode('@',$request)[1];
		$controller = new $controllerName();
		$controller->$actionName();
	}
}

