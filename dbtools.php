<?php

define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASSWORD", "");

class DB
{
	// Returns a new PDO database connection to the super awesome database called spirarenet
	public static function connectToDb()
	{
		try
		{
			$db = new PDO("mysql:host=" . DBHOST . ";dbname=spirarenet", DBUSER, DBPASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		}
		catch (PDOException $error)
		{
			echo "<h1>D:</h1><p><b>Owh crap.</b> Something went horribly wrong. If you see the sweating computer monkeys, give them this:</p><pre>" .
				 $error->getMessage() .
				 "</pre>";
		}
	}

	// Returns the object based on id. If the object doesn't exist, it'll return false.
	public static function selectById($table, $id)
	{
		return self::connectToDb()->query("SELECT * FROM " . $table . " WHERE id=" . $id)->fetch(PDO::FETCH_ASSOC);
	}



	// Inserts two values in a linktable
	public static function linktable_insert($table, $key1, $key2, $v1, $v2)
	{
		// This code 2sad4me ;_;
		$label1 = ":" . $key1;
		$label2 = ":" . $key2;

		$statement = self::connectToDb()->prepare("INSERT INTO " . $table . "(" . $key1 . "," . $key2 . 
			") VALUES(" . $label1. "," . $label2 . ")");

		return $statement->execute(array($label1 => $v1, $label2 => $v2));
	}

	// Checks if a link exists in a linktable table
	public static function linktable_has($table, $key1, $key2, $v1, $v2)
	{
		(self::connectToDb()->query("SELECT * FROM " . $table . " WHERE " . $key1 . "=" . $v1 . " AND " . $key2 . "=" . $v2)->fetch(PDO::FETCH_ASSOC) != FALSE);
	}

	protected static function getWantedKeysFromRows($arr, $wantKey)
	{
		// Thanks Tim
		$ids = [];

		if ($arr)
		{
			foreach ($arr as $row)
			{
				$ids[] = $row[$wantKey];
			}
		}

		return $ids;	
	}

	// Returns all target ids from a linktable
	public static function linktable_getAllIds($table, $wantKey, $selKey, $selVal)
	{
		return self::getWantedKeysFromRows(self::connectToDb()->query("SELECT " . $wantKey . " FROM " . $table . " WHERE " . $selKey . "=" . $selVal)->fetchAll(PDO::FETCH_ASSOC), $wantKey);		
	} 


	// Searches a linktable
	public static function linktable_search($table, $wantKey, $selKey, $selVal)
	{
		return self::getWantedKeysFromRows(self::connectToDb()->query("SELECT " . $wantKey . " FROM " . $table . " WHERE " . $selKey . " LIKE \"" . $selVal . "%\"")->fetchAll(PDO::FETCH_ASSOC), $wantKey);
	}
}

?>