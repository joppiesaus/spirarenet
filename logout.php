<?php

session_start();

if (!isset($_SESSION["uid"]))
{
	echo "Nobody logged in!";
	exit;
}

session_destroy();

echo "Logged out!";

?>