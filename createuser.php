<!DOCTYPE html>
<html>
<head>
	<title>Create userrrr</title>
	<meta charset="utf-8">
</head>
<body>

<form action="do_createuser.php" method="post">
	Username: <input type="text" name="username"><br>
	Real name: <input type="text" name="userrealname"><br>
	Password: <input type="password" name="userpassword"><br>
	Email: <input type="text" name="useremail"><br>
	Bio: <textarea rows="20" cols="50" name="userbio"></textarea><br>
	Property JSON: <textarea name="userproperties">[]</textarea>
	<br><br><input type="Submit">
</form>

</body>
</html>