<?php

$router->get('','MainController@home');
$router->post('','MainController@post');
$router->get('delete','MainController@deleteComment');
