<!DOCTYPE html>
<html>
<head>
	<title>Propertyyyy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
</head>
<body>

<div id="container">

<?php

if (!isset($_GET["id"]))
{
	echo "No property requested!";
	exit;
}

$pid = intval($_GET["id"]);

require "main.php";

$prop = new Property($pid);
$jp = $prop->data;


// Todo: Do seperate CSS
echo "<p id=\"uprofile_name\">" . $jp["name"] . "</p>";
echo "<p>" . $jp["description"] . "</p>";
$prop->display();

// TODO: Check if user already has property, then handle it another way(e.g. remove this badge)

session_start();
if (isset($_SESSION["uid"]))
{
	echo "<br><br><input type=\"button\" value=\"Add this " . $jp["type"] . " to your profile\" onclick=\"usersystem('?action=addproperty&pid=" . $pid . "')\"/>";
}
Main::addGlobalEvents();

$users = $prop->getAllUsers();
if (empty($users))
{
	echo "<br><br>Nobody currently has this " . $jp["type"] . ".";
}
else
{
	echo "<br><p>Users:</p>";

	foreach ($users as $uid)
	{
		$user = new User($uid);
		$user->display();
	}
}

$events = $prop->getAllEvents();
if (empty($events))
{
	echo "<br><br>No events are coming up for this " . $jp["type"] . ".";
}
else
{
	echo "<br><p>Upcoming events:</p>";

	foreach ($events as $eid)
	{
		$evnt = new Event($eid);
		$evnt->display();
	}
}

?>

</div>

</body>
</html>