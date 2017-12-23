<?php

use App\Routers\MainRouter;
use App\Request\Request;
use App\Container\Container;
use App\Database\QueryBuilder;
use App\Database\Connection;

require __DIR__ . '/../vendor/autoload.php';


Container::bind('config', require'../config.php');
Container::bind('pdo', Connection::make(Container::get('config')['database']));

MainRouter::loadRoutes()->direct(Request::getUri(),Request::getMethod());

