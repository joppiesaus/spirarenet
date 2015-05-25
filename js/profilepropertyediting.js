var pDiv;

function start()
{
	pDiv = document.createElement("div");
	pDiv.style.display = "none";
	pDiv.id = "propertytooltip";
	document.body.appendChild(pDiv);

	/* already done by server
	// Loop through all properties
	var propEls = document.querySelectorAll(".property");

	for (var i = 0; i < propEls.length; i++)
	{
		// Oh you javascript
		propEls[i].onclick = function(j){return function(){propertyClick(j+"")}}(i);
	}*/
}

window.onload = start;

function propertyClick(index)
{
	/*pDiv.style.width = "100px";
	pDiv.style.height = "80px";
	pDiv.style.backgroundColor = "black";
	pDiv.style.display = "block";*/
}