<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

require "dbtools.php";

DB::edit($_POST["table"], $_POST["id"], json_decode($_POST["json"]));

echo "Edited!";

?>