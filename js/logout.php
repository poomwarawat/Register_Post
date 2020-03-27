<?php
	session_start();
	//add code here
	// ทำลาย session และ redirect ไปที่ index.html
	session_destroy();
	header('Location: ../index.html')
?>