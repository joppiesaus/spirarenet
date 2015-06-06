<?php

require "dbtools.php";
require "JsonDBObjectMapper.php";

class JsonDBObject
{
	// If id is not 0, instance will set id and load
	function __construct($id = 0)
	{
		if (!empty($id))
		{
			$this->id = $id;
			$this->load();
		}
	}

	// TODO: Make this static
	protected $TABLE = "Oops a developer was sleeping on its keyboard while it should be overriding JsonDBObject";

	public $id;
	public $data;

	// Creates the object, 
	public function create()
	{
		$i = JsonDBObjectMapper::insert($this->TABLE, $this->data);
		if (!$i)
		{
			throw("Creation failed!");
		}
		$this->id = intval($i);
	}

	public function save()
	{
		JsonDBObjectMapper::edit($this->TABLE, $this->id, $this->data);
	}

	public function load()
	{
		$this->data = json_decode(DB::selectById($this->TABLE, $this->id)["data"], true);
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

	// Displays the property on the page. Make sure you included style.css. prop is propery json. If id is not 0, it'll create a link to the property action
	public static function displayProperty($prop, $id = 0)
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
		else
		{
			$output .= "\"";
		}

		$output .= " alt=\"" . $prop["description"] . "\"";

		if (!empty($id))
		{
			$output .= " onclick=\"propertyClick('" . $id . "')\"";
		}

		$output .=  ">" . $prop["name"] . "</div>";
		echo $output;
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

	// TODO: Make a mapper of this too, since this will not be the only index table
	public static function getUserIDByName($name)
	{
		$result = DB::connectToDb()->query("SELECT id FROM ind_users WHERE name=\"" . $name . "\"")->fetch(PDO::FETCH_ASSOC);
		if ($result)
		{
			return $result["id"];
		}
		return false;
	}

	public function loadByName($name)
	{
		$this->id = self::getUserIDByName($name);
		if (!$this->id)
		{
			throw "Error: User probably doesn't exist!";
		}
		$this->load();
	}

	public function create()
	{
		parent::create();

		// index
		$db = DB::connectToDb();
		$statement = $db->prepare("INSERT INTO ind_users(id,name) VALUES(:id,:name)");
		
		try
		{
			if (!$statement->execute(array(":id" => $this->id, ":name" => $this->data["profile"]["username"])))
			{
				echo "Error, user probably already exists!";
				return false;
			}
		}
		catch (PDOException $exception)
		{
			echo "Error, user probably exists: " . $exception->getMessage();
			return false;
		}

		return true;
	}

	// Displays all properties of this user
	public function displayAllProperties()
	{
		foreach (getAllProperties() as $prop)
		{
			$prop->display();
		}
	}

	// Adds and links a property to this user
	public function addProperty($pid)
	{
		DB::linktable_insert("user_prop", "uid", "pid", $this->id, $pid);
	}

	// Returns if the user already has a property with the id $pid
	public function hasProperty($pid)
	{
		return DB::linktable_has($this->TABLE, "pid", "uid", $pid, $this->id);
	}

	// Returns an array of all property id's this user has
	public function getAllProperties()
	{
		return DB::linktable_getAllIds($this->TABLE, "pid", "uid", $this->id);
	}
}

class Property extends JsonDBObject
{
	protected $TABLE = "properties";

	// Creates a new property(json only, not the dbobj)
	// Arguments: name - name, description - description, type - badge or tag, id - id to database index, css - CSS class CONTENTS
	public static function createProperty($name, $description, $type, $css = "")
	{
		$prop = array();
		$prop["type"] = $type;
		$prop["name"] = $name;
		$prop["description"] = $description;
		
		if (!empty($css))
		{
			$prop["css"] = $css;
		}

		return $prop;
	}

	// Adds and links an user to this property
	public function addUser($uid)
	{
		DB::linktable_insert("user_prop", "uid", "pid", $uid, $this->id);
	}

	// Returns if the property already has a user with the id $uid
	public function hasUser($uid)
	{
		return DB::linktable_has($this->TABLE, "uid", "pid", $uid, $this->id);
	}

	// Returns an array of all user id's this property has
	public function getAllUsers()
	{
		return DB::linktable_getAllIds($this->TABLE, "uid", "pid", $this->id);
	}

	public function display()
	{
		Main::displayProperty($this->data, $this->id);
	}
}

class Event
{
	protected $TABLE = "events";
}

?>