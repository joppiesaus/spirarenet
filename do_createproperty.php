<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

require "main.php";

$prop = new Property;
$prop->json = array(
		"users" => array(),
		"property" => array(
				"id" => NULL,
				"type" => $_POST["type"],
				"name" => $_POST["name"],
				"description" => $_POST["description"],
			)
	);

// CSSGENERATION!!!!!!!!!!!!
if (!empty($_POST["css"]))
{
	$prop->json["property"]["css"] = $_POST["css"];

	if (!empty($_POST["cssdeps"]))
	{
		$prop->json["property"]["cssadditional"] = $_POST["cssdeps"];
	}
}

$prop->create();

echo "Succesfully created " . $_POST["type"] . " " . $_POST["name"] . " with id " . $prop->id . "!";
$prop->display();


?>