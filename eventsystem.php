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

$uid = $_SESSION["uid"];

switch ($_GET["action"])
{
	case "addproperties":
		
		break;

	default:
		echo "Hurr durr \"" . $_GET["action"] . "\" is no command! D:";
		break;
}

?>