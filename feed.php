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
		<script type="text/javascript" src="js/feed.js"></script>
	</head>
	<body>
		<div class="grid-container">
			<div class="item1">
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

		function pageLoad(){
			document.getElementById('postbutton').onclick = getData;
			readJson();
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
				window.location.reload()
				showPost(JSON.parse(http.responseText))
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

