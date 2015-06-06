<?php

if (empty($_POST))
{
	echo "No data provided!";
	exit;
}

session_start();

if (!isset($_SESSION["uid"]))
{
	echo "You can't create an event, because you aren't logged in!";
	exit;
}

require "main.php";

$evnt = new Event;

$evnt->data = array(
		"title" => $_POST["title"], 
		"description" => $_POST["description"]
	);

$evnt->create();
$evnt->addOrganisator($_SESSION["uid"]);

header("Location:event.php?id=" . $evnt->id);

?>