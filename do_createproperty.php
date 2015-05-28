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


$prop->create();

// Generate CSS
if (!empty($_POST["css"]))
{
	$cdeps = "";

	if (!empty($_POST["cssdeps"]))
	{
		$cdeps = $_POST["cssdeps"];
	}

	require "cssGenerator.php";

	CSSGEN::addProperty($prop, $_POST["css"], $cdeps);
}



echo "Succesfully created " . $_POST["type"] . " " . $_POST["name"] . " with id " . $prop->id . "!";
$prop->display();


?>