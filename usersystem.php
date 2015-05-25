<?php

if (empty($_GET["action"]))
{
	exit;
}

session_start();
if (!isset($_SESSION["uid"]))
{
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

		break;
}

?>