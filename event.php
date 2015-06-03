<!DOCTYPE html>
<html>
<head>
	<title>Propertyyyy</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
	<script src="js/propertynavigate.js"></script>
</head>
<body>

<div id="container">

<?php

if (!isset($_GET["id"]))
{
	echo "No event requested!";
	exit;
}

$eid = intval($_GET["id"]);

require "main.php";
s


?>

</div>

</body>
</html>