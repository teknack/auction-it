<?php
	session_start();
	session_destroy();
	unset($_SESSION["admin_user"]);
	header("Location: index.php");
?>