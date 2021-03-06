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
			exit;
		}
	}

	// Returns the object based on id. If the object doesn't exist, it'll return false.
	public static function selectById($table, $id)
	{
		return self::connectToDb()->query("SELECT * FROM " . $table . " WHERE id=" . $id)->fetch(PDO::FETCH_ASSOC);
	}

	// Inserts n values in a table. At least one key and value is required.
	public static function multiple_insert($table, $keys, $values)
	{
		$query = "INSERT INTO " . $table . "(" . $keys[0];
		for ($i = 1; $i < count($keys); $i++)
		{
			$query .= "," . $keys[$i];
		}

		$query .= ") VALUES(:" . $keys[0];
		for ($i = 1; $i < count($keys); $i++)
		{
			$query .= ",:" . $keys[$i];
		}

		$query .= ")";

		$db = self::connectToDb();
		$statement = $db->prepare($query);

		$vls = [];

		for ($i = 0; $i < count($keys); $i++)
		{
			$vls[":" . $keys[$i]] = $values[$i];
		}

		return $statement->execute($vls);
	}

	// Inserts two values in a table
	public static function dual_insert($table, $key1, $key2, $v1, $v2)
	{
		// This code 2sad4me ;_;
		$label1 = ":" . $key1;
		$label2 = ":" . $key2;

		$statement = self::connectToDb()->prepare("INSERT INTO " . $table . "(" . $key1 . "," . $key2 . 
			") VALUES(" . $label1. "," . $label2 . ")");

		return $statement->execute(array($label1 => $v1, $label2 => $v2));
	}

	// Removes a row from a table based on id
	public static function removeById($table, $id)
	{
		return (self::connectToDb()->execute("DELETE FROM " . $table . " WHERE id=" . $id));
	}

	// Removes a row from a table based on key and it's value
	public static function removeByKey($table, $key, $value)
	{
		return (self::connectToDb()->execute("DELETE FROM " . $table . " WHERE " . $key . "=" . $value));
	}

	// Checks if a link exists in a linktable table
	public static function linktable_has($table, $key1, $key2, $v1, $v2)
	{
		return (self::connectToDb()->query("SELECT * FROM " . $table . " WHERE " . $key1 . "=" . $v1 . " AND " . $key2 . "=" . $v2)->fetch(PDO::FETCH_ASSOC) != FALSE);
	}

	public static function linktable_delete($table, $key1, $key2, $v1, $v2)
	{
		return (self::connectToDb()->query("DELETE FROM " . $table . " WHERE " . $key1 . "=" . $v1 . " AND " . $key2 . "=" . $v2));
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