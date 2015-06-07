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

$user = new User($uid);

if (hash("sha512", $_POST["password"]) != $user->data["profile"]["password"])
{
	echo "Wrong password!";
	exit;
}


// Why check if someone is logged in already?
session_start();
$_SESSION["uid"] = $uid;

if (isset($user->data["uadmin"]))
{
	$_SESSION["uadmin"] = TRUE;
}

$_SESSION["usernotifymessage"] = $user->data["profile"]["name"] . ", you're now logged in!";

header("Location:user.php?id=" . $uid);

?>