<?php

header("Content-Type:text/html");

if (empty($_GET))
{
	echo "sheep";
}


$q = $_GET["query"];
$searchfor = $_GET["s"];

$isid = (intval($q) !== 0);

require "main.php";

// TODO: Think about data handling and sorting, not just printing evertyhing on the screen
if (strpos($searchfor, 'u') !== FALSE)
{
	$users = [];

	if ($isid === TRUE)
	{
		$users[$q] = 0;
	}

	foreach (DB::linktable_search("ind_users", "id", "name", $q) as $uid)
	{
		$users[$uid] = 0;
	}

	foreach (DB::linktable_search("ind_users", "id", "realname", $q) as $uid)
	{
		$users[$uid] = 0;
	}

	// display all users
	foreach (array_keys($users) as $uid)
	{
		$user = new User($uid);
		$user->display();
	}
}


// Not doing duplicate checking for the rest, chance is too small
if (strpos($searchfor, 'e') !== FALSE)
{
	if ($isid === TRUE)
	{
		$evnt = new Event($q);
		if ($evnt)
		{
			$evnt->display();
		}
	}

	foreach (DB::linktable_search("ind_evnts", "id", "title", $q) as $eid)
	{
		$evnt = new Event($eid);
		$evnt->display();
	}
}

if (strpos($searchfor, 'p') !== FALSE)
{
	if ($isid === TRUE)
	{
		$prop = new Property($q);
		if ($prop)
		{
			$prop->display();
		}
	}

	foreach (DB::linktable_search("ind_props", "id", "name", $q) as $pid)
	{
		$prop = new Property($pid);
		$prop->display();
	}
}

?>