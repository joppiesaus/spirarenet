<?php

// Requires dbtools.php
class JsonDBObjectMapper
{
	// Creates a new row. Returns id on succes
	public static function insert($table, $properties)
	{
		$db = DB::connectToDb();

		$statement = $db->prepare("INSERT INTO " . $table . "(data) VALUES(:data)");


		if ($statement->execute(array(":data" => json_encode($properties))))
		{
			return $db->lastInsertId("id");
		}
		return false;
	}

	// Edits a row based on id
	public static function edit($table, $id, $properties)
	{
		DB::connectToDb()->prepare("UPDATE " . $table . " SET data=:data WHERE id=" . $id)->execute(array(":data" => json_encode($properties)));
	}
}

?>