<?php
	$data = $_GET["data"];
	$myfile = fopen("postDB.json", "w");
	fwrite($myfile, $data);
	fclose();
?>