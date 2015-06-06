<!DOCTYPE html>
<html>
<head>
	<title>Create eventtt</title>
	<meta charset="utf-8">
</head>
<body>

<?php

// CREATE LINKTABLEEEEEEE FOR ACCES TO EVENT
// OH AND ADMINS

session_start();
if (isset($_SESSION["uid"]))
{
	echo '<form action="do_createevent.php" method="post">' .
		'Title: <input type="text" name="title"><br>Description: <input type="text" name="description"><br>' .
		'<br><br><input type="Submit">' .	
	'</form>';
}
else
{
	echo "You must be logged in to add an event!";
}

?>

</body>
</html>