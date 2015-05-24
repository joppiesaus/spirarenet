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
$prop->display();


echo "<br><br>Users:<br>";
$users = $prop->json["users"];

foreach ($users as $uid)
{
	$user = Main::loadUser($uid);
	echo "<a href=\"user.php?id=" . $uid . "\">" . $user->json["name"] . "</a><br>";
}

echo "<br><br><pre>";
var_dump($prop);
echo "</pre>";


?>

</body>
</html>