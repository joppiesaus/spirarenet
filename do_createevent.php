<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

require "main.php";

$evnt = new Event;

$evnt->data = array(
		"title" => $_POST["title"], 
		"description" => $_POST["description"]
	);

$evnt->create();

header("Location:event.php?id=" . $evnt->id);

?>