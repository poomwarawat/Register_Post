<?php
    $data = $_GET["data"];
	$myfile = fopen("userDB.json", "w");
	fwrite($myfile, $data);
	fclose();
?>