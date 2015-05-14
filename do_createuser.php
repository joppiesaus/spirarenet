<?php

require "dbtools.php";


// TODO: properties
DB::insert("users", array(
		"profile" => array(
				"name" => $_POST["username"], 
				"password" => $_POST["userpassword"],
				"email" => $_POST["useremail"],
				"picture_url" => NULL,
				"bio" => $_POST["userbio"]
			),
		"properties" => NULL
	)
);

// TODO: Make header to the new profile!

?>