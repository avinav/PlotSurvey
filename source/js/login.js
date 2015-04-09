function signin() {
	removeError();
	validation();
}

function validation() {
	var uName = document.getElementsByName("user_name")[0].value;
	var pass = document.getElementsByName("pass")[0].value;
	var valid = true;
	if(!uName.match(".*@.*\\..*")) {
		if(document.getElementById("errorName") == null){
			addUserError();
		}
		valid = false;
	}
	if (pass.length < 3 || pass.length > 10) {
		if (document.getElementById("errorPass") == null) {
			addPassError();
		}
		valid = false;
	}
	if(valid) {
		document.getElementsByName("signin_form")[0].submit();
		//window.location.href ="/home/avinav/Dropbox/workspace/LearnPHP/welcome_page.html";
	}
}

function addUserError() {
	var table = document.getElementById("sign_tb");
	var newRow = document.createElement("tr");
	var newCol = document.createElement("td");
	newRow.id = "errorName";
	newRow.name = "error";
	newCol.colSpan = 2;
	table.appendChild(newRow);
	newRow.appendChild(newCol);
	newCol.innerHTML="<span style='color: red; font-size: 9px'>*Invalid User Name</span>";
}

function addPassError() {
	var table = document.getElementById("sign_tb");
	var newRow = document.createElement("tr");
	var newCol = document.createElement("td");
	newRow.id = "errorPass";
	newRow.name = "error";
	newCol.colSpan = 2;
	table.appendChild(newRow);
	newRow.appendChild(newCol);
	newCol.innerHTML="<span style='color: red; font-size: 9px'>*Invalid Password</span>";
}

function removeError() {
	var table = document.getElementById("sign_tb");
	var errorName = document.getElementById("errorName");
	var errorPass = document.getElementById("errorPass");
	if (errorName != null) {
		table.removeChild(errorName);
	}
	if (errorPass != null) {
		table.removeChild(errorPass);
	}
	/*var errorNodes = document.getElementsByName("error");
	if (errorNodes.length > 0)
	table.removeChild(errorNodes);
	 for (var i = 0; i < errorNodes.length; i++) {
		table.removeChild(errorNodes[i]);
	}*/
}