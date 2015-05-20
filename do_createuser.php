<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

require "main.php";

$user = new User;

// TODO: properties
$user->json = array(
		"profile" => array(
				"username" => $_POST["username"], 
				"name" => $_POST["userrealname"],
				"password" => $_POST["userpassword"],
				"email" => $_POST["useremail"],
				"picture_url" => NULL,
				"bio" => $_POST["userbio"]
			),
		// TEMP TEMP TEMP
		"properties" => json_decode($_POST["userproperties"])
	);

$user->create();

// TODO: Make header to the new profile!

?>