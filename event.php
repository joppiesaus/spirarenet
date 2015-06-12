<!DOCTYPE html>
<html>
<head>
	<title>Eventttt</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
	<script src="js/propertynavigate.js"></script>
</head>
<body>

<?php include "code/navbar.php"; ?>


<div id="container">

<?php

if (!isset($_GET["id"]))
{
	echo "No event requested!";
	exit;
}

$eid = intval($_GET["id"]);

require "main.php";

$evnt = new Event($eid);

if ($evnt)
{
	echo '<p id="uprofile_name">' . $evnt->data["title"]. '</p>';
	echo '<p id="uprofile_bio">' . $evnt->data["description"] . '</p>';

	echo '<div id="uprofile_properties">';

	$props = $evnt->getAllProperties();

	foreach ($props as $pid)
	{
		$prop = new Property($pid);
		$prop->display();
	}

	echo '</div>';
}
else
{
	echo "This event doesn't exist :/";
}

session_start();
if (isset($_SESSION["uid"]))
{
	if ($evnt->isOrganisator($_SESSION["uid"]))
	{
		echo "<a href=\"eventlinking.php?eid=" . $eid . "\">Add properties</a>";
	}
}

?>

</div>

</body>
</html>