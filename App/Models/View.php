<?php

namespace App\Models;
/**
* 
*/
class View
{
	
	public function hometop()
	{
		include('../Views/home_top.php');
	}

	public function homebottom()
	{
		include('../Views/home_bottom.php');
	}

	public function addComment($argument)
	{
		$argument = $argument;
		include('../Views/Layouts/content.php');
	}
}