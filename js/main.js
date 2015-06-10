var notifyEl;

_onloadfuncs = [];

window.onload = function()
{
	notifyEl = document.createElement("div");
	notifyEl.id = "usernotifymessage";
	notifyEl.style.display = "none";
	notifyEl.onclick = function()
	{
		notifyEl.style.display = "none";
		notifyEl.textContent = "Well this is awkward";
	};
	
	document.body.appendChild(notifyEl);
	
	for (var i = 0; i < _onloadfuncs.length; i++)
	{
		_onloadfuncs[i]();
	}
};

// Returns an DOM element with the id given
function ge(i)
{
	return document.getElementById(i);
}

// Sends an asynchronous httpget to the specified URL, calls callback when ready with this as XMLHttpRequest
function httpGet(url, callback)
{
	var http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.onload = callback;
	http.send(null);
}

// Sends an asynchronous http request with given data with POST, calls callback when ready
// Params in this format: "hurr=durr&name=james&dinosaur=hermaphrodite"
function httpPostRequest(url, params, callback)
{
	var request = new XMLHttpRequest();
	request.open("POST", url, true);
	
	// Headers
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	// Outdated, browser should do this on its own
	//request.setRequestHeader("Content-length", params.length);
	//request.setRequestHeader("Connection", "close");
	
	request.onload = callback;
	request.send(params);
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