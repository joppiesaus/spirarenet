<!DOCTYPE html>
<html>
<head>
	<title>Edit</title>
	<meta charset="utf-8">
</head>
<body>

<?php


$exit = false;
if (!isset($_GET["id"]))
{
	// TODO: overview of properties?
	echo "No id given!<br>";
	$exit = true;
}
if (!isset($_GET["table"]))
{
	echo "No table given!<br>";
	$exit = true;
}

if ($exit)
{
	exit;
}

include "dbtools.php";

$id = $_GET["id"];
$table = $_GET["table"];

$json = DB::selectById($table, $id)["data"];

echo "<form action=\"do_rawedit.php\" method=\"post\"><table>";

echo "<tr><td>ID:</td><td><input type=\"text\" name=\"id\" value=\"" . $id . "\"></td></tr>";
echo "<tr><td>Table:</td><td><input type=\"text\" name=\"table\" value=\"" . $table . "\"></td></tr>";
echo "<tr><td>JSON:</td><td><textarea name=\"json\" rows=\"10\" cols=\"50\">" . $json . "</textarea></td></tr>";

echo "<tr><td><input type=\"Submit\"></td></tr>";
echo "</table></form>";


?>

</body>
</html>