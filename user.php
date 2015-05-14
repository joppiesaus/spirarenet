<!DOCTYPE html>
<html>
<head>
	<title>userrrr</title>
	<meta charset="utf-8">
</head>
<body>

<pre>

<?php

if (!isset($_GET["id"]))
{
	echo "No user requested!";
	exit;
}

$uid = intval($_GET["id"]);

$db = new PDO("mysql:host=localhost;dbname=spirarenet", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $db->query("SELECT * FROM users WHERE id=" . $uid);

$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user)
{
	// user exists, print
	var_dump($user);
}
else
{
	// user doesn't, cry
	echo "User " . $uid . " doesn't exist!";
}


?>

</body>
</html>