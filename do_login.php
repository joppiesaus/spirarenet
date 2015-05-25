<?php

if (empty($_POST["uid"]))
{
	echo "Hurr durr uid empty";
	exit;
}

// HAHAHAH! No password checking!
// *ahum*
// TODO: Name and password checking
require "main.php";

$user = Main::loadUser($_POST["uid"]);

session_start();
$_SESSION["uid"] = $user->id;

echo $user->json["profile"]["name"] . ", you're now logged in!";

?>