<?php

namespace App\Database;

use \PDO;
use \Exception;
/**
* 
*/

class QueryBuilder
{
	protected $pdo;

	function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function select($table)
	{
		$statement = $this->pdo->prepare('select * from comments');
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectAllComments()
	{
		$statement = $this->pdo->prepare('select * from comments');
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_CLASS,'App\Models\Comment');
	}
	
	public function selectAllCommentsArr()
	{
		$statement = $this->pdo->prepare('select * from comments');
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function store($table, $comment)
	{
		$params = [];
		$params['id'] = $comment['id'];
		$params['body'] = $comment['body'];
		$params['parrent_id'] = $comment['parrent_id'];
		
		$sql = sprintf('insert into %s (%s) values (%s)', $table, implode(', ', array_keys($params)), ':'.implode(', :', array_keys($params)));
		
		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute($params);
		} catch (Exception $e) {
			$e->getMessage();	
		}

		$child = [];
		$child['parrent_id'] = $params['parrent_id'];
		$child['child_id'] = $params['id'];
		$child['depth'] = $this->getDepth($params['parrent_id']);
		while ( $child['depth'] > -1) {
			$this->storeChild($child);
			$child['parrent_id'] = empty($this->getById($child['parrent_id'])) ? 0 : $this->getById($child['parrent_id'])['parrent_id'];
			$child['depth'] = $child['depth'] - 1;
		}
	}

	public function storeChild($params)
	{
		$table = "child_comments";
		$sql = sprintf('insert into %s (%s) values (%s)', $table, implode(', ', array_keys($params)), ':'.implode(', :', array_keys($params)));
			try {
				$statement = $this->pdo->prepare($sql);
				$statement->execute($params);
			} catch (Exception $e) {
				$e->getMessage();	
			}
	}

	public function getDepth($parrent_id)
	{
		$depth = 0;
		
		while ($this->getById($parrent_id)['parrent_id']>-1) {
			$depth = $depth + 1;
			$parrent_id = $this->getById($parrent_id)['parrent_id'];
		}
		return $depth;
	}

	public function getById($id)
	{
		$statement = $this->pdo->prepare("SELECT * FROM comments WHERE id =:id");
		$statement->bindParam(":id",$id);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function getChilds($id)
	{
		$statement = $this->pdo->prepare("SELECT child_id FROM child_comments WHERE parrent_id=:parrent_id ORDER BY child_id DESC");
		$statement->bindParam(":parrent_id",$id);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_COLUMN,0);
	}

	public function deleteById($id)
	{
		$statement = $this->pdo->prepare("DELETE FROM comments WHERE id=:id");
		$statement->bindParam(":id",$id);
		$statement->execute();
	}

	public function getMaxId()
	{
		$statement = $this->pdo->prepare("SELECT MAX(id) FROM comments");
		$statement->execute();
		return $statement->fetch(PDO::FETCH_COLUMN,0);
	}
}