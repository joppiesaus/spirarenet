<?php

require "dbtools.php";

class JsonDBObject
{
	// TODO: Make this static
	protected $TABLE = "Oops a developer was sleeping on its keyboard while it should be overriding JsonDBObject";

	public $id;
	public $json;

	public function create()
	{
		DB::insert($this->TABLE, $this->json);
	}

	public function save()
	{

	}

	public function load()
	{
		$this->json = json_decode(DB::selectById($this->TABLE, $this->id)["json"], true);
	}
}

class User extends JsonDBObject
{
	protected $TABLE = "users";
}

class Property extends JsonDBObject
{
	protected $TABLE = "properies";
}

?>