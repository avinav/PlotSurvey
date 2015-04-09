function init_page() {
	var query = window.location.search;	
	var vars = query.split("?");
	var params = vars[1].split("&");
	var val = params[0].split("=");
	var user_id = val[1];
	user_id = user_id.replace("%40","@");
	document.getElementById("user").innerHTML = user_id;
}

