var profilePictureFileUploadEl;

_onloadfuncs.push(function()
{
	var e = document.getElementById("uprofile_pic");
	
	e.onclick = showProfilePictureFileUploadDialog;
	e.onmouseover = function()
	{
		//alert("hi");
	};
	
	profilePictureFileUploadEl = document.createElement("div");
	profilePictureFileUploadEl.id = "profilePictureFileUploadDialog";
	profilePictureFileUploadEl.style.display = "none";
	profilePictureFileUploadEl.innerHTML = "<p>Choose an image. Recommended is a square image with width and height >= 250.</p>" + 
	'<form action="usersystem.php?action=uploadprofilepic" method="post" enctype="multipart/form-data" target="_self">' +
	'<input type="file" name="uploadimg"><br><input type="submit" value="Upload"></form>';
	document.body.appendChild(profilePictureFileUploadEl);
});

function showProfilePictureFileUploadDialog()
{
	profilePictureFileUploadEl.style.display = "block";
}