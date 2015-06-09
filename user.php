<!DOCTYPE html>
<html>
<head>
	<title>userrrr</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
	<script src="js/propertynavigate.js"></script>
</head>
<body>

<nav id="primary_nav_wrap">
<ul>
  <li class="current-menu-item"><a href="#">Home</a></li>
  <li><a href="#">Menu 1</a>
    <ul>
      <li><a href="#">Sub Menu 1</a></li>
      <li><a href="#">Sub Menu 2</a></li>
      <li><a href="#">Sub Menu 3</a></li>
      <li><a href="#">Sub Menu 4</a>
        <ul>
          <li><a href="#">Deep Menu 1</a>
            <ul>
              <li><a href="#">Sub Deep 1</a></li>
              <li><a href="#">Sub Deep 2</a></li>
              <li><a href="#">Sub Deep 3</a></li>
                <li><a href="#">Sub Deep 4</a></li>
            </ul>
          </li>
          <li><a href="#">Deep Menu 2</a></li>
        </ul>
      </li>
      <li><a href="#">Sub Menu 5</a></li>
    </ul>
  </li>
  <li><a href="#">Menu 2</a>
    <ul>
      <li><a href="#">Sub Menu 1</a></li>
      <li><a href="#">Sub Menu 2</a></li>
      <li><a href="#">Sub Menu 3</a></li>
    </ul>
  </li>
  <li><a href="#">Menu 3</a>
    <ul>
      <li class="dir"><a href="#">Sub Menu 1</a></li>
      <li class="dir"><a href="#">Sub Menu 2 THIS IS SO LONG IT MIGHT CAUSE AN ISSEUE BUT MAYBE NOT?</a>
        <ul>
          <li><a href="#">Category 1</a></li>
          <li><a href="#">Category 2</a></li>
          <li><a href="#">Category 3</a></li>
          <li><a href="#">Category 4</a></li>
          <li><a href="#">Category 5</a></li>
        </ul>
      </li>
      <li><a href="#">Sub Menu 3</a></li>
      <li><a href="#">Sub Menu 4</a></li>
      <li><a href="#">Sub Menu 5</a></li>
    </ul>
  </li>
  <li><a href="#">Menu 4</a></li>
  <li><a href="#">Menu 5</a></li>
  <li><a href="#">Menu 6</a></li>
  <li><a href="#">Contact Us</a></li>
</ul>
</nav>


<div id="container">
<?php

if (!isset($_GET["id"]))
{
	echo "No user requested!";
	exit;
}

$uid = intval($_GET["id"]);


require "main.php";

$user = new User($uid);
if ($user)
{
	$userj = $user->data["profile"];
	$name = $userj["name"];

	// user exists, print
	echo '<img id="uprofile_pic" src="' . $userj["picture_url"] . '" alt="' . $name . '\'s profile picture" />';
	echo '<p id="uprofile_name">' . $name . '</p>';
	echo '<p id="uprofile_username">' . $userj["username"] . '</p>';
	echo '<p id="uprofile_bio">' . $userj["bio"] . '</p>';

	echo '<div id="uprofile_properties">';

	if (!empty($user->data["properties"]))
	{
		Main::displayProperties($user->data["properties"]);
	}

	$props = $user->getAllProperties();

	foreach ($props as $pid)
	{
		$prop = new Property($pid);
		$prop->display();
	}

	echo '</div>';


	// Check if user is logged on and if the user is the same user as the page
	session_start();
	if (isset($_SESSION["uid"]) && $_SESSION["uid"] == $user->id)
	{
		echo "<script src=\"js/profileimageupload.js\"></script>";
		Main::addGlobalEvents();
	}
}
else
{
	// user doesn't, cry
	echo "User " . $uid . " doesn't exist!";
}


?>
</div>

</body>
</html>