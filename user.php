<!DOCTYPE html>
<html>
<head>
	<title>userrrr</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
	<script src="js/propertynavigate.js"></script>
</head>
<body>

<?php include "code/navbar.php"; ?>

<div id="container">
<?php

session_start();

if (!isset($_GET["id"]))
{
	if (isset($_SESSION["uid"]))
	{
		header("Location:user.php?id=" . $_SESSION["uid"]);
		exit;
	}
	else
	{
		echo "No user requested!";
		exit;
	}
}

$uid = intval($_GET["id"]);


require "main.php";

$user = new User($uid);
if ($user)
{
	$userj = $user->data["profile"];
	$name = $userj["name"];

	// user exists, print
	echo '<img id="uprofile_pic" src="' . $userj["picture_url"] . '" alt="' . $name . '\'s profile picture" />';
	echo '<p id="uprofile_name">' . $name . '</p>';
	echo '<p id="uprofile_username">' . $userj["username"] . '</p>';
	echo '<p id="uprofile_bio">' . $userj["bio"] . '</p>';

	echo '<div id="uprofile_properties">';

	if (!empty($user->data["properties"]))
	{
		Main::displayProperties($user->data["properties"]);
	}

	$props = $user->getAllProperties();

	foreach ($props as $pid)
	{
		$prop = new Property($pid);
		$prop->display();
	}

	echo '</div>';


	// Check if user is logged on and if the user is the same user as the page
	if (isset($_SESSION["uid"]) && $_SESSION["uid"] == $user->id)
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