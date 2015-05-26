var notifyEl;

window.onload = function()
{
	notifyEl = document.createElement("div");
	notifyEl.id = "usernotifymessage";
	notifyEl.style.display = "none";
	notifyEl.onclick = function(){notifyEl.style.display = "none"};
	
	document.body.appendChild(notifyEl);
};


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
	notifyEl.textContent = msg;
	notifyEl.style.display = "block";
}

// Calls usersystem.php with the specified parameters and notifies the user of the result
function usersystem(parameters)
{
	httpGet("usersystem.php" + parameters, function(){userNotify(this.responseText)});
}