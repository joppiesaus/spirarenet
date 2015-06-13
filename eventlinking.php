<!DOCTYPE html>
<html>
<head>
	<title>goat.exe</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
	<script src="js/propertyselection.js"></script>
</head>
<body>

<?php include "code/navbar.php"; ?>

<script>

function search()
{
	httpGet("do_search.php?query=" + ge("searchtb").value + "&s=p",
		function()
		{
			ge("result").innerHTML = this.responseText;
		}
	);
}

function submit(id)
{
	submitSelectedProperties("eventsystem.php?action=addproperties&eid=" + id,
		function()
		{
			userNotify(this.responseText);
		}
	);
}

</script>

<div id="container">

<?php

if (!isset($_GET["eid"]))
{
	echo "No event defined(eid empty)!";
	exit;
}

session_start();
if (!isset($_SESSION["uid"]))
{
	echo "You have no rights!";
}

require "main.php";


$eid = $_GET["eid"];
$evnt = new Event($eid);

if (!$evnt->isOrganisator($_SESSION["uid"]))
{
	echo "You have no rights!";
}

echo '<p>Select your properties:</p>' .
	'Filter: <input type="text" id="searchtb"><br><br>' .
	'<input type="button" onclick="search()" value="Update"><input type="button" onclick="submit(' . $eid . ')" value="Submit"><br><br>' .
	'<div id="result"></div>' .
	'<script>search()</script>';

?>

</div>

</body>
</html>