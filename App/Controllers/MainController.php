<?php

namespace App\Controllers;

use App\Models\View;
use App\Database\QueryBuilder;
use App\Container\Container;
use App\Models\Comment;
/**
* 
*/
class MainController
{
	private static $argument=[];
	private $qb;

	public function __construct()
	{
		$this->qb = new QueryBuilder(Container::get('pdo'));
	}

	public function home()
	{
		$comments = $this->sortComments();
		$view = new View();
		$view->hometop();

		$this->showComments($comments);
		$view->homebottom();
	}

	public function post()
	{
		$argument = $this->getDataFromPost();
		$this->qb->store('comments', $argument);
		$this->home();
	}

	private function getDataFromPost()
	{
		$data = [];
		$data['body'] = array_key_exists('body', $_POST) ? strtolower(trim(strval($_POST['body']))) : '';
		$data['parrent_id'] = array_key_exists('parrent_id', $_POST) ? intval(strtolower(trim(strval($_POST['parrent_id'])))) : '';
		$data['id'] = intval($this->qb->getMaxId())+1;
		return $data;
	}


	public function isTableEmpty($table)
	{
		return (empty($this->qb->select('comments')));
	}

	public function sortComments()
	{
		$comments = $this->qb->selectAllCommentsArr();
		if (empty($comments)) {
			return $comments;
		}
		$ar = [];
		for ($i=0; $i < count($comments); $i++) {
	       $ar[$comments[$i]['parrent_id']][] = $comments[$i];
    	} 
    	return $ar;
	}

	public function deleteComment()
	{
		$id = intval(strtolower(trim(strval($_GET['id']))));
		$childs = $this->qb->getChilds($id);
		if (empty($childs)) {
			$this->qb->deleteById($id);
		} else {
			foreach ($childs as $key => $value) {
				$this->qb->deleteById($value);
			}
			$this->qb->deleteById($id);
		}
		$this->home();
	}

	public function showComments($data, $parent = 0, $level = 20)
    {
    	if (empty($data)) {
    		return;
    	}
        $comments = $data[$parent];

        for($i = 0; $i < count($comments); $i++) {
         	include('../Views/Layouts/comment.php');
       }
    }
}


