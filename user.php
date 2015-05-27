<!DOCTYPE html>
<html>
<head>
	<title>userrrr</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="js/main.js"></script>
	<script src="js/propertynavigate.js"></script>
</head>
<body>

<div id="container"> 
<?php

if (!isset($_GET["id"]))
{
	echo "No user requested!";
	exit;
}

$uid = intval($_GET["id"]);


require "main.php";

$user = new User;
$user->id = $uid;
$user->load();
if ($user)
{
	$userj = $user->json["profile"];
	$name = $userj["name"];

	// user exists, print
	echo '<img id="uprofile_pic" src="' . $userj["picture_url"] . '" alt="' . $name . '\'s profile picture" />';
	echo '<p id="uprofile_name">' . $name . '</p>';
	echo '<p id="uprofile_username">' . $userj["username"] . '</p>';
	echo '<p id="uprofile_bio">' . $userj["bio"] . '</p>';

	if (!empty($user->json["properties"]))
	{
		echo '<div id="uprofile_properties">';
		Main::displayProperties($user->json["properties"]);
		echo '</div>';
	}

	// Check if user is logged on and if the user is the same user as the page
	session_start();
	if ($_SESSION["uid"] == $user->id)
	{
		echo "<script src=\"js/profileimageupload.js\"></script>";
		Main::addGlobalEvents();
	}
}
else
{
	// user doesn't, cry
	echo "User " . $uid . " doesn't exist!";
}


?>
</div>

</body>
</html>