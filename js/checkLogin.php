<?php
	session_start();
	
	$username = $_GET["username"];
	$password = $_GET["password"];

	//complete this file
	// ทำได้โดยเริ่มจากอ่านไฟล์ userDB.json วน  foreach loop ถ้าตรงทั้ง password และ username ให้ redirect ไปที่ feed.php แต่ถ้าไม่ตรงให้ กลับไปที่ index.html?error=1
	$data = file_get_contents("./userDB.json");
	$data = json_decode($data, true);
	foreach($data as $temp){
	
		if($username === $temp["username"] && $password === $temp["password"]){
			
			$_SESSION["username"] = $username;
			
			header("Location: ../feed.php");
			exit;
		}
		
		// echo $temp["username"]."<br>";
		// echo $temp["password"]."<br>";		
	}
	foreach($data as $temp){
	
		if($username != $temp["username"] && $password != $temp["password"]){
			
			header("Location: ../index.html?error=1");
			exit;
		}
		
		
			
	}
	
?>