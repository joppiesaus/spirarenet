<?php

$properties = array(
		"profile" => array(
				"name" => $_POST["username"], 
				"password" => $_POST["userpassword"],
				"email" => $_POST["useremail"],
				"picture_url" => NULL,
				"bio" => $_POST["userbio"]
			),
		"properties" => NULL
	);

$db = new PDO("mysql:host=localhost;dbname=spirarenet", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $db->prepare("INSERT INTO users(json) VALUES(:json)");
$statement->execute(array(":json" => json_encode($properties)));

// TODO: Make header to the new profile!

?>