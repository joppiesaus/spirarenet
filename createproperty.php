<!DOCTYPE html>
<html>
<head>
	<title>Create propertyyy</title>
	<meta charset="utf-8">
</head>
<body>

<form action="do_createproperty.php" method="post">
	<input type="radio" name="type" value="tag" checked>Tag <input type="radio" name="type" value="badge">Badge<br>
	Name: <input type="text" name="name"><br>
	Description: <input type="text" name="description"><br>
	CSS class(optional): <input type="text" name="css"><br>
	CSS dependencies(danger zone): <input type="text" name="cssdeps"><br><br>

	<br><br><input type="Submit">
</form>

</body>
</html>