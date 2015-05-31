<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

require "main.php";

$user = new User;

$user->data = array(
		"profile" => array(
				"username" => $_POST["username"], 
				"name" => $_POST["userrealname"],
				"password" => $_POST["userpassword"],
				"email" => $_POST["useremail"],
				"picture_url" => "img/missing.png",
				"bio" => $_POST["userbio"]
			)
	);

$props = json_decode($_POST["userproperties"]);
if (!empty($props))
{
	$user->data["properties"] = $props;
}

$user->create();

header("Location:user.php?id=" . $user->id);

?>