<html>
<head>
	<title>Search</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/properties_generated.css" />
	<script src="js/main.js"></script>
	<script src="js/propertynavigate.js"></script>
</head>
<body>

<?php include "code/navbar.php"; ?>

<script>
function search()
{
	function c(n)
	{
		var e = ge(n);
		return (e.checked ? e.value : "");
	}

	httpGet("do_search.php?query=" + ge("searchtb").value + "&s=" + c("wantproperty") + c("wantevent") + c("wantuser"),
		function()
		{
			ge("result").innerHTML = this.responseText;
		}
	);
}
</script>

<div id="container">
	Query: <input id="searchtb" type="text" /><br>

	Search for:
	<input type="checkbox" id="wantproperty" value="p" /> Properties
	<input type="checkbox" id="wantevent" value="e" /> Events
	<input type="checkbox" id="wantuser" value="u" /> People
	<br><br>
	<input type="button" onclick="search()" value="Search" />

	<div id="result">
	</div>
</div>

</body>
</html>