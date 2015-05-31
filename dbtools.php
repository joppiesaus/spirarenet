<?php

define("DBSERVER", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "");

class DB
{
	// Returns a new PDO database connection to the super awesome database called spirarenet
	public static function connectToDb()
	{
		$db = new PDO("mysql:host=" . DBSERVER . ";dbname=spirarenet", DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

	// Inserts two values in a linktable
	public static function linktable_insert($table, $value1name, $value2name, $value1, $value2)
	{
		// This code 2sad4me ;_;
		$label1 = ":" . $value1name;
		$label2 = ":" . $value2name;

		$statement = self::connectToDb()->prepare("INSERT INTO " . $table . "(" . $value1name . "," . $value2name . 
			") VALUES(" . $label1. "," . $label2 . ")");

		return $statement->execute(array($label1 => $value1, $label2 => $value2));
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