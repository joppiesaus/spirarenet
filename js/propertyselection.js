function propertyClick(index)
{
	ge("p" + index).classList.toggle("selected");
}

// Documentation is hard
// POST data is pids, an JSON array of id's
function submitSelectedProperties(url, callback, params)
{
	var els = document.querySelectorAll("div.property.selected");
	var ids = [];
	
	for (var i = 0; i < els.length; i++)
	{
		ids.push(Number(els[i].id.substring(1)));
	}
	
	if (ids.length > 0)
	{
		params = params || "";
		httpPostRequest(url, params + "&pids=" + JSON.stringify(ids), callback);
	}
}