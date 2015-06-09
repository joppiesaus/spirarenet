<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

require "main.php";

$prop = new Property;
$prop->data = array(
		"id" => NULL,
		"type" => $_POST["type"],
		"name" => $_POST["name"],
		"description" => $_POST["description"]
);


$prop->create();

// Generate CSS
/*if (!empty($_POST["css"]))
{
	$cdeps = "";

	if (!empty($_POST["cssdeps"]))
	{
		$cdeps = $_POST["cssdeps"];
	}

	require "code/cssGenerator.php";

	CSSGEN::addProperty($prop, $_POST["css"], $cdeps);
}*/

// Add notification
session_start();
$_SESSION["usernotifymessage"] = "Succesfully created " . $_POST["type"] . " " . $_POST["name"] . "!";

// Redirect to property
header("Location:property.php?id=". $prop->id);

?>