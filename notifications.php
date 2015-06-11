<!DOCTYPE html>
<html>
<head>
	<title>Notifications(temporary, wip)</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
</head>
<body>

<?php include "code/navbar.php"; ?>

<div id="container">

<?php


session_start();
if (!isset($_SESSION["uid"]))
{
	echo "You better <a href=\"login.php\">login</a>!";
	exit;
}

$uid = $_SESSION["uid"];

require "main.php";

$user = new User($uid);

if (empty($user->data["notifications"]))
{
	echo "No notifications!";
}
else
{
	foreach ($user->data["notifications"] as $note)
	{
		Notification::display($note);
	}
}

?>

</div>

</body>
</html>