<?php

require "dbtools.php";

//require "cssGenerator.php";

class PropertyPageBuilder
{
	var $output = "";

	public function begin()
	{
	}

	public function end()
	{
		echo $this->output;
	}

	public function displayProperty($prop)
	{
		// TODO: CSS & cssGenerator, improve
		$this->output .= "<div class=\"property " . $prop["type"];
		if (isset($prop["css"]))
		{
			// TODO: add classname
		}
		$this->output .=  "\" title=" . $prop["description"] . ">" . $prop["name"] . "</div>";
	}

	public function displayProperties($props)
	{
		foreach ($props as $prop)
		{
			$this->displayProperty($prop);
		}
	}

}

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
		DB::edit($TABLE, $id, $json);
	}

	public function load()
	{
		$this->json = json_decode(DB::selectById($this->TABLE, $this->id)["json"], true);
	}
}

class User extends JsonDBObject
{
	protected $TABLE = "users";

	// Adds and links an property(JsonDBObject) to this user.
	public function addProperty(&$prop)
	{
		array_push($this->["properties"], $prop->json["property"]);

		$this->save();
		$prop->addUser($this->id);
	}
}

class Property extends JsonDBObject
{
	protected $TABLE = "properies";

	// Creates a new property(json only, not the dbobj)
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
		if (!empty($css))
		{
			$prop["css"] = $css;

			if (!empty($additionalCssDependencies))
			{
				$prop["cssadditional"] = $additionalCssDependencies;
			}
		}

		return $prop;
	}

	// Adds an user to this
	public function addUser($uid)
	{
		array_push($this->json["users"], $uid);
		$this->save();
	}
}

?>