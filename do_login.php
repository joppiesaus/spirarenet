<?php

if (empty($_POST["name"]))
{
	echo "Hurr durr name empty";
	exit;
}

require "main.php";

$uid = User::getUserIDByName($_POST["name"]);
if (!$uid)
{
	echo "User doesn't exist!";
	exit;
}

session_start();
$_SESSION["uid"] = $uid;

$user = new User;
$user->loadById($uid);

echo $user->data["profile"]["name"] . ", you're now logged in!";

?>