<?php

namespace App\Models;
/**
* 
*/
class Comment
{
	public $body;
	public $parrent_id;
	public $id;

	function __construct()
	{
		/*
		$this->body = $body;
		$this->parrent_id = $parrent_id;
		$this->id = $id;
		*/
	}

	public function getBody()
	{
		return $this->body;
	}

	public function getParrentId()
	{
		return $this->parrent_id;
	}

	public function getId()
	{
		return $this->id;
	}
}