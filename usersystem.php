<?php

header("Content-Type:text/plain");

if (empty($_GET["action"]))
{
	echo "Do you know what you're doing? You didn't define an action todo!";
	exit;
}

session_start();
if (!isset($_SESSION["uid"]))
{
	echo "Not logged in!";
	exit;
}

require "main.php";

$pid;

if (isset($_GET["pid"]))
{
	$pid = $_GET["pid"];
}
$uid = $_SESSION["uid"];

switch ($_GET["action"])
{
	case "addproperty":

		if (!isset($pid))
		{
			exit;
		}

		$user = new User($uid);

		if ($user->hasProperty($pid))
		{
			echo "You already have this property!";
			exit;
		}

		$prop = new Property($pid);
		$user->addProperty($pid);

		echo "Succesfully added " . $prop->data["type"] . " " . $prop->data["name"] . " to your profile, " . $user->data["profile"]["name"] . "!";

		break;

	case "removeproperty":

		if (!isset($pid))
		{
			exit;
		}

		$user = new User($uid);
		$prop = new Property($pid);

		// TODO: Check if prop exist!
		if ($user->removeProperty($pid))
		{
			echo "Succesfully deleted " . $prop->data["type"] . " " . $prop->data["name"] . " from your profile, " . $user->data["profile"]["name"] . "!";
		}
		else
		{
			echo "Failed to remove " . $prop->data["type"] . " " . $prop->data["name"] . " D:";
		}

		break;

	case "uploadprofilepic":

		// TODO: do from location where the user came from
		header("Location:user.php?id=" . $uid);
		$target_file = "img/user/profilepic-" . $uid . "." . end(explode(".", $_FILES["uploadimg"]["name"]));

		if ($_FILES["uploadimg"]["size"] <= 0)
		{
			$_SESSION["usernotifymessage"] = "Upload failed: No file to upload";
			exit;
		}

		$check = getimagesize($_FILES["uploadimg"]["tmp_name"]);

		if (!$check)
		{
			$_SESSION["usernotifymessage"] = "Upload failed - file not an image";
			exit;
		}

		if ($_FILES["uploadimg"]["size"] > 5242880)
		{
			$_SESSION["usernotifymessage"] = "Upload failed - file too large(Max. 5MiB)";
			exit;
		}

		if (!move_uploaded_file($_FILES["uploadimg"]["tmp_name"], $target_file))
		{
			$_SESSION["usernotifymessage"] = "Unexpected error when saving image. :(";
			exit;
		}

		$user = new User($uid);

		// Delete old picture if not needed
		if ($user->data["profile"]["picture_url"] != $target_file && $user->data["profile"]["picture_url"] != "img/missing.png")
		{
			unlink($user->data["profile"]["picture_url"]);
		}

		$user->data["profile"]["picture_url"] = $target_file;
		$user->save();

		$_SESSION["usernotifymessage"] = "Your image was succesfully uploaded!";

		break;

	default:
		echo "Hurr durr \"" . $_GET["action"] . "\" is no command! D:";
		break;
}

?>