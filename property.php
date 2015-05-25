<!DOCTYPE html>
<html>
<head>
	<title>Propertyyyy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css" />
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
$jp = $prop->json["property"];

// Todo: Do seperate CSS
echo "<p id=\"uprofile_name\">" . $jp["name"] . "</p>";
echo "<p>" . $jp["description"] . "</p>";

if (!empty($prop->json["users"]))
{
	echo "<br><p>Users:</p>";
	
	foreach ($prop->json["users"] as $uid)
	{
		$user = Main::loadUser($uid);
		if (!$user)
		{
			continue;
		}
		$up = $user->json["profile"];
		echo "<div class=\"p_userpreview\"><a href=\"user.php?id=" . $uid . "\"><p>" . $up["name"] . "</p><img src=\"" . $up["picture_url"] . "\"></a></div>";
	}
}

?>

</div>

</body>
</html>