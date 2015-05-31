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

$prop = Main::loadProperty($pid);
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

if (!empty($prop->data["users"]))
{
	echo "<br><p>Users:</p>";
	
	foreach ($prop->getAllUsers() as $uid)
	{
		$user = Main::loadUser($uid);
		/*if (!$user)
		{
			continue;
		}*/
		$up = $user->data["profile"];
		echo "<div class=\"p_userpreview\"><a href=\"user.php?id=" . $uid . "\"><p>" . $up["name"] . "</p><img src=\"" . $up["picture_url"] . "\"></a></div>";
	}
}

?>

</div>

</body>
</html>