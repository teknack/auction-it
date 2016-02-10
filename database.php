<?php
	//Not used yet
	$host= 'localhost';
    $user = 'root'; 
    $pass = '';
	$database = 'auctionit201602';
	$link = mysqli_connect($host, $user, $pass) or die("unable to connect 1");
	$db = mysqli_select_db($link , $database);
?>