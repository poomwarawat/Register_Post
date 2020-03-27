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

			
			http.open("POST", "./js/writeJson.php?data=" + msg + "&user=" + document.getElementById("name").textContent())
			http.onload = () =>{
				console.log(http.responseText)
				// showPost(JSON.parse(http.responseText))
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
