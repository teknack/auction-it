<?php
	session_start();
	if(isset($_SESSION['admin_user'])){
		header("Location: ../admin-panel.php");
	}
	$username = $_POST['Username'];
	$password = $_POST['Password'];

	include('../database.php');

	$sql = "SELECT `username`, `password`, `master_admin_control` FROM `admin_user` WHERE `username` = '$username' AND `password` = '$password'";
	$res = mysqli_query($link , $sql);
	if(!$res){
		die('connection failed!');
	}
	else{
		if(mysqli_num_rows($res) > 0){
			$row_u = mysqli_fetch_assoc($res);
			if($row_u['master_admin_control'] == 1){
				$master_admin_control = true;
				$_SESSION['master_control'] = $master_admin_control;
			}
			$_SESSION['admin_user'] = $username;
			echo "<script>alert('Login Successfull'); window.location.href='../admin-panel.php';</script>";
		}
		else{
			echo "<script>alert('Incorrect username or password!'); window.location.href='index.php';</script>";
		}
	}
?>