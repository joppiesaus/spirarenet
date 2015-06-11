<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

session_start();
if (empty($_SESSION["uadmin"]))
{
	echo "How about no?";
	exit;
}

require "code/dbtools.php";

DB::edit($_POST["table"], $_POST["id"], json_decode($_POST["json"]));

echo "Edited!";

?>