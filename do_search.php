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

if (strpos($searchfor, 'u') !== FALSE)
{
	if ($isid === TRUE)
	{
		$user = new User($q);
		if ($user)
		{
			$user->display();
		}
	}

	foreach (DB::linktable_search("ind_users", "id", "name", $q) as $uid)
	{
		$user = new User($uid);
		$user->display();
	}
}

?>