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

$user = new User;
$user->loadById($uid);

if (hash("sha512", $_POST["password"]) != $user->data["profile"]["password"])
{
	echo "Wrong password!";
	exit;
}

// Why check if someone is logged in already?
session_start();
$_SESSION["uid"] = $uid;

echo $user->data["profile"]["name"] . ", you're now logged in!";

?>