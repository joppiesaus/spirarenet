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


require "dbtools.php";

$user = DB::selectById("users", $uid);

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