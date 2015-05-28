<?php

require "dbtools.php";

class JsonDBObject
{
	// TODO: Make this static
	protected $TABLE = "Oops a developer was sleeping on its keyboard while it should be overriding JsonDBObject";

	public $id;
	public $json;

	// Creates the object, 
	public function create()
	{
		$i = DB::insert($this->TABLE, $this->json);
		if (!$i)
		{
			throw("Creation failed!");
		}
		$this->id = intval($i);
	}

	public function save()
	{
		DB::edit($this->TABLE, $this->id, $this->json);
	}

	public function load()
	{
		$this->json = json_decode(DB::selectById($this->TABLE, $this->id)["json"], true);
	}
}

// Helper class
class Main
{
	// Displays all properties in the array. All json, not JsonDBObjects
	public static function displayProperties($props)
	{
		foreach ($props as $prop)
		{
			Main::displayProperty($prop);
		}
	}

	// Displays the property on the page. Make sure you included style.css. prop is propery json
	public static function displayProperty($prop)
	{
		$output = "<div class=\"property " . $prop["type"];

		if (isset($prop["css"]))
		{
			$output .= "\" style=\"" . $prop["css"] . "\"";
		}
		else if (isset($prop["cssclass"]))
		{
			$output .= " " . $prop["cssclass"] . "\"";
		}

		$output .= "alt=\"" . $prop["description"] . "\"";

		if (!empty($prop["id"]))
		{
			$output .= " onclick=\"propertyClick('" . $prop["id"] . "')\"";
		}

		$output .=  ">" . $prop["name"] . "</div>";
		echo $output;
	}

	public static function loadUser($id)
	{
		$user = new User;
		$user->id = intval($id);
		$user->load();
		return $user;
	}

	public static function loadProperty($id)
	{
		$prop = new Property;
		$prop->id = intval($id);
		$prop->load();
		return $prop;
	}


	// Adds global things to a webpage, such as notifications
	public static function addGlobalEvents()
	{
		// Display notification popup on load when requested
		if (!empty($_SESSION["usernotifymessage"]))
		{
			echo "<script>_onloadfuncs.unshift(function(){userNotify(\"" . $_SESSION["usernotifymessage"] . "\")});</script>";
			unset($_SESSION["usernotifymessage"]);
		}
	}
}

class User extends JsonDBObject
{
	protected $TABLE = "users";

	// Adds and links an property(JsonDBObject) to this user.
	public function addProperty(&$prop)
	{
		// TODO: Check if the user already has property
		array_push($this->json["properties"], $prop->json["property"]);

		$this->save();
		$prop->addUser($this->id);
	}
}

class Property extends JsonDBObject
{
	protected $TABLE = "properties";

	function create()
	{
		parent::create();
		$this->json["property"]["id"] = $this->id;
		$this->save();
	}

	// Creates a new property(json only, not the dbobj)
	// Arguments: name - name, description - description, type - badge or tag, id - id to database index, css - CSS class CONTENTS
	public static function createProperty($name, $description, $type, $id = NULL, $css = "")
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
		}

		return $prop;
	}

	// Adds an user to this property, doesn't link
	public function addUser($uid)
	{
		array_push($this->json["users"], $uid);
		$this->save();
	}

	
	public function display()
	{
		Main::displayProperty($this->json["property"]);
	}
}

?>