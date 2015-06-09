<?php

require "code/dbtools.php";
require "code/JsonDBObjectMapper.php";

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

	// Returns true if the target user is an admin
	/*public static function isUserAdmin($uid)
	{
		return (DB::connectToDb()->query("SELECT * FROM useradmins WHERE id=" . $uid)->fetch(PDO::FETCH_ASSOC) != FALSE);
	}*/

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

		return (!DB::multiple_insert("ind_users", ["id", "name", "realname"],
			[
				$this->id,
				$this->data["profile"]["username"],
				$this->data["profile"]["name"]
			]
			));
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
		DB::dual_insert("user_prop", "uid", "pid", $this->id, $pid);
	}

	// Returns if the user already has a property with the id $pid
	public function hasProperty($pid)
	{
		return DB::linktable_has("user_prop", "pid", "uid", $pid, $this->id);
	}

	// Returns an array of all property id's this user has
	public function getAllProperties()
	{
		return DB::linktable_getAllIds("user_prop", "pid", "uid", $this->id);
	}

	// Makes a user preview appear on the page
	public function display()
	{
		echo "<div class=\"p_userpreview\"><a href=\"user.php?id=" . $this->id . "\"><p>" . $this->data["profile"]["name"] . "</p><img src=\"" . $this->data["profile"]["picture_url"] . "\"></a></div>";
	}

	// Returns true if this user is an admin
	/*public function isAdmin()
	{
		return self::isUserAdmin($this->id);
	}*/
}

class Property extends JsonDBObject
{
	protected $TABLE = "properties";

	public function create()
	{
		parent::create();

		DB::dual_insert("ind_props", "id", "name", $this->id, $this->data["name"]);
	}

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
		DB::dual_insert("user_prop", "uid", "pid", $uid, $this->id);
	}

	// Returns if the property already has a user with the id $uid
	public function hasUser($uid)
	{
		return DB::linktable_has("user_prop", "uid", "pid", $uid, $this->id);
	}

	// Returns an array of all user id's this property has
	public function getAllUsers()
	{
		return DB::linktable_getAllIds("user_prop", "uid", "pid", $this->id);
	}

	// Returns an array of all event id's this property has
	public function getAllEvents()
	{
		return DB::linktable_getAllIds("evnt_prop", "eid", "pid", $this->id);
	}

	// Displays this property on the page
	public function display()
	{
		Main::displayProperty($this->data, $this->id);
	}
}

class Event extends JsonDBObject
{
	protected $TABLE = "events";


	public function create()
	{
		parent::create();

		DB::dual_insert("ind_evnts", "id", "title", $this->id, $this->data["title"]);
	}

	// returns an array of property id's of this event
	public function getAllProperties()
	{
		return DB::linktable_getAllIds("evnt_prop", "pid", "eid", $this->id); 
	}

	// Returns true if the user is an organisator of this event
	public function isOrganisator($uid)
	{
		return DB::linktable_has("evnt_organisator", "uid", "eid", $uid, $this->id);
	}

	// Adds an organisator to this event. Returns false on fail
	public function addOrganisator($uid)
	{
		return DB::dual_insert("evnt_organisator", "eid", "uid", $this->id, $uid);
	}

	// Displays an preview of this event on the page
	public function display()
	{
		echo "<a href=\"event.php?id=" . $this->id . "\">" . $this->data["title"] . "</a><br>";
	}
}

?>