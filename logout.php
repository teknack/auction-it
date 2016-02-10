<?php
	session_start();
	session_destroy();
	unset($_SESSION['tek_fname']);
	unset($_SESSION['tek_emailid']);
	header("Location: index.php");
?>