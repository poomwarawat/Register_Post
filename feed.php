<?php
session_start();
	// complete this : check ว่ามีการ login หรือยัง โดยเช็คจาก username ถ้ายังให้กลับไปที่ index.html
	if(!$_SESSION['username']){
		header("Location: ./index.html");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link type="text/css" rel="stylesheet" href="css/stylefeed.css">
		<script type="text/javascript" src="./js/feed.js"></script>
	</head>
	<style>
		.picture{
			width:100px
		}
		</style>
	<body>
		<div class="grid-container">
			<div class="item1">
				<div class="browsePic">
					<div id="displayPic">
						<img class="picture" id="picprofile">
					</div>
					<form action="js/upload.php" id="formId" method="post" enctype="multipart/form-data">
						<input type="file" name="fileToUpload" value="fileToUpload" placeholder="" class="hidden" id="fileField">
					</form>
				</div>
				Hello <?php echo "<span id='name'>" . $_SESSION['username'] . "</span>" ?>, Welcome back!
			</div>
  			<div class="item2"> <a href="js/logout.php"> Logout</a> </div>
  			<div class="item3">
  				<div id="posting">
  					<textarea name="msg" id="textmsg" value="" placeholder="" rows="4" cols="50"></textarea>
					<br>
  					<button id="postbutton">Post</button>
  				</div>
  				<hr>
  				<div id="feed-container">
  					
  				</div>	
  			</div>  
		</div>
	</body>
	<script>
		window.onload = pageLoad;

var jdata;
var udata;

function pageLoad(){
	document.getElementById('postbutton').onclick = getData;
	document.getElementById('displayPic').onclick = fileUpload;
	document.getElementById('fileField').onchange = fileSubmit;
	readJson();
}
function fileUpload(){
	document.getElementById('fileField').click()
}
function fileSubmit(){
	document.getElementById('formId').submit()
	var fullPath = document.getElementById('fileField').value;
	if (fullPath) {
		var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
		var filename = fullPath.substring(startIndex);
		if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
			filename = filename.substring(1);
		}
		console.log(filename);
	}
	var key = Object.keys(udata)
	for (let index = 0; index < key.length; index++) {
		const user = udata[key[index]].username
		const user1 = document.getElementById('name').textContent
		if(user == user1){
			udata[key[index]].dir =  "uploads/" + filename
			console.log(udata)
		}
	}
	var http = new XMLHttpRequest();
	var jsonData = JSON.stringify(udata)
	http.open("POST", "./js/writeUser.php?data=" + jsonData)
	http.onload = () =>{
		console.log("success")
	}
	http.onerror = () => console.log("Error")
	http.send()
}
function getData(){
	//  homework
	var msg = document.getElementById("textmsg").value;
	writeJson(msg);
}

function readJson(){
	// complete this function
	// อ่าน post ที่เคยเขียนไว้ ใน file ที่ชื่อว่า postDB.json และทำการ show post ทั้งหมดที่มีใน file
	var http = new XMLHttpRequest();
	http.open("GET", "./js/postDB.json")
	http.onload = () =>{
		jdata = JSON.parse(http.responseText)
		showPost(JSON.parse(http.responseText))
	}
	http.onerror = () => console.log("Error")
	http.send()
	readUser()
}
function readUser(){
	var http = new XMLHttpRequest();
	http.open("GET", "./js/userDB.json")
	http.onload = () =>{
		udata = JSON.parse(http.responseText)
		CheckUser(udata)
	}
	http.onerror = () => console.log("Error")
	http.send()
}
function CheckUser(data){
	console.log(udata)
	var key = Object.keys(udata)
	for (let index = 0; index < key.length; index++) {
		const user = udata[key[index]].username
		const user1 = document.getElementById('name').textContent
		if(user == user1){
			const url = "js/" + data[key[index]].dir
			console.log(url)
			document.getElementById('picprofile').src = url
		}
	}
}
function writeJson(msg){
	//add code here 
	//  homework
	// ส่งข้อความที่เพิ่งพิมพ์และข้อความเก่าเข้ามาเพื่อทำการบันทึกทับใน postDB.json โดย AJAX ทำการส่ง json string ไปให้ writeJson.php ถ้าทำสำเร็จจะแสดง post ข้อความ โดยใช้ showPost function
	var http = new XMLHttpRequest();
	var post = Object.keys(jdata)
	var last = parseInt(parseInt(post.slice(-1)) + 1);
	console.log(last)
	var datas = {
		newIndex:{
			user :  document.getElementById('name').textContent,
			message : msg
		}
	}

	var lengthData = Object.keys(jdata).length + 1
	var newIndex = "post" + lengthData

	datas[newIndex] = datas["newIndex"]
	delete datas["newIndex"]

	var data = Object.assign(jdata, datas);

	var jsonData = JSON.stringify(data)
	http.open("POST", "./js/writeJson.php?data=" + jsonData)
	http.onload = () =>{
		alert("Post success")
		window.location.reload()
	}
	http.onerror = () => console.log("Error")
	http.send()
}

function showPost(data){
	var keys = Object.keys(data);
	var divTag = document.getElementById("feed-container");
	
	for (var i = 0; i < keys.length; i++) {
		var temp = document.createElement("div");
		temp.className = "newsfeed";
		divTag.appendChild(temp);
		var temp1 = document.createElement("div");
		temp1.className = "postmsg";
		temp1.innerHTML = data[keys[i]]["message"];
		temp.appendChild(temp1);
		var temp1 = document.createElement("div");
		temp1.className = "postuser";
		temp1.innerHTML = "Post by: "+data[keys[i]]["user"];
		temp.appendChild(temp1);
		
	}
}

	</script>
</html>

