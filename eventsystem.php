<?php

// I suck at error messages

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

if (!isset($_GET["eid"]))
{
	echo "No event!";
	exit;
}

require "main.php";

$uid = $_SESSION["uid"];
$eid = $_GET["eid"];

$evnt;

try
{
	$evnt = new Event($eid);
}
catch (NotFoundException $ex)
{
	echo "Event " . $eid . " not found!";
	exit;
}

$isOrganisator = $evnt->isOrganisator($uid);

switch ($_GET["action"])
{
	case "addproperties":

		if (empty($_POST["pids"]))
		{
			echo "No properties to link!";
			exit;
		}

		if (!$isOrganisator)
		{
			echo "Wrong permissions!";
			exit;
		}

		$pids = json_decode($_POST["pids"]);

		foreach ($pids as $pid)
		{
			$evnt->addProperty($pid);
		}

		echo "Succesfully added properties!";

		break;

	default:
		echo "Hurr durr \"" . $_GET["action"] . "\" is no command! D:";
		break;
}

?>