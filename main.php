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

	// Creates a new property
	// Arguments: name - name, description - description, type - badge or tag, id - id to database index, css - CSS class CONTENTS, additionalCssDependencies - Additional required css, but does not fit in class - usage unique and disencourged when not needed
	public static function createProperty($name, $description, $type, $id = NULL, $css = "", $additionalCssDependencies = "")
	{
		$prop = array();
		$prop["type"] = $type;
		$prop["name"] = $name;
		$prop["description"] = $description;

		if (isset($id))
		{
			$prop["id"] = $id;
		}
		if (isset($css))
		{
			$prop["css"] = $css;

			if (isset($additionalCssDependencies))
			{
				$prop["cssadditional"] = $additionalCssDependencies;
			}
		}

		return $prop;
	}
}

?>