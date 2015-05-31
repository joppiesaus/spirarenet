<!DOCTYPE html>
<html>
<head>
	<title>Propssss</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>

<?php


if (!isset($_GET["id"]))
{
	// TODO: overview of properties?
	echo "No id given!";
	exit;
}

include "main.php";

$prop = Main::loadProperty($_GET["id"]);

if (is_null($prop->data))
{
	echo "<p style=\"color:white;background-color:red;padding:5px\"><b>Property json is null, it probably doesn't exist!</b> <a href=\"createproperty.php\">Create it</a></p>";
}
else
{
	$prop->display();


	echo "<br><br>Users:<br>";
	$users = $prop->data["users"];

	foreach ($users as $uid)
	{
		$user = Main::loadUser($uid);
		echo "<a href=\"user.php?id=" . $uid . "\">" . $user->data["profile"]["name"] . "</a><br>";
	}
}

echo "<br><br><pre>";
var_dump($prop);
echo "</pre>";


?>

</body>
</html>