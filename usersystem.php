<?php

header("Content-Type:text/plain");

if (empty($_GET["action"]))
{
	echo "Do you know what you're doing? You didn't define an action todo!";
	exit;
}

session_start();
if (!isset($_SESSION["uid"]))
{
	echo "Not logged in!";
	exit;
}

require "main.php";

$pid = $_GET["pid"];
$uid = $_SESSION["uid"];

switch ($_GET["action"])
{
	case "addproperty":

		if (!isset($pid))
		{
			exit;
		}

		$user = Main::loadUser($uid);
		$prop = Main::loadProperty($pid);
		$user->addProperty($prop);

		echo "Succesfully added " . $prop->json["property"]["type"] . " " . $prop->json["property"]["name"] . " to your profile, " . $user->json["profile"]["name"] . "!";

		break;
}

?>