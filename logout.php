<?php
	session_start();
	session_destroy();
	unset($_SESSION['tek_name']);
	unset($_SESSION['tek_userid']);
	header("Location: index.php");
?>