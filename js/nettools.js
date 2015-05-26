
// Sends an asynchronous httpget to the specified URL, calls callback when ready with this as XMLHttpRequest
function httpGet(url, callback)
{
	var http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.onload = callback;
	http.send(null);
}

// Notify the user of an action on-screen
function userNotify(msg)
{
	// TODO: Improve
	alert(msg);
}

// Calls usersystem.php with the specified parameters and notifies the user of the result
function usersystem(parameters)
{
	httpGet("usersystem.php" + parameters, function(){userNotify(this.responseText)});
}