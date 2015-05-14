<?php

define("DBSERVER", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "");

class DB
{
	// Returns the object based on id. If the object doesn't exist, it'll return false.
	public static function selectById($table, $id)
	{
		$db = new PDO("mysql:host=" . DBSERVER . ";dbname=spirarenet", DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement = $db->query("SELECT * FROM " . $table . " WHERE id=" . $id);

		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	// Creates a new row
	public static function insert($table, $properties)
	{
		$db = new PDO("mysql:host=" . DBSERVER . ";dbname=spirarenet", DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement = $db->prepare("INSERT INTO " . $table . "(json) VALUES(:json)");
		$statement->execute(array(":json" => json_encode($properties)));
	}

}

?>