<?php

define("DBSERVER", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "");

class DB
{
	public static function connectToDb()
	{
		$db = new PDO("mysql:host=" . DBSERVER . ";dbname=spirarenet", DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

	// Returns the object based on id. If the object doesn't exist, it'll return false.
	public static function selectById($table, $id)
	{
		return self::connectToDb()->query("SELECT * FROM " . $table . " WHERE id=" . $id)->fetch(PDO::FETCH_ASSOC);
	}

	// Creates a new row. Returns id on succes
	public static function insert($table, $properties)
	{
		$db = self::connectToDb();

		$statement = $db->prepare("INSERT INTO " . $table . "(data) VALUES(:data)");


		if ($statement->execute(array(":data" => json_encode($properties))))
		{
			return $db->lastInsertId("id");
		}
		return false;
	}

	// Edits a row
	public static function edit($table, $id, $properties)
	{
		self::connectToDb()->prepare("UPDATE " . $table . " SET data=:data WHERE id=" . $id)->execute(array(":data" => json_encode($properties)));
	}
}

?>