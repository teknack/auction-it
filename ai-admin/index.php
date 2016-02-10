<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<!--Title icon-->
        <link rel="shortcut icon" href="../images/auction_logo_icon.png" type="image/png">
	</head>
	<body>
		<center>
			<div id="login-form">
				<form method = "post" action = "login.php" id="log_form">
					<table align="center" width="30%" border="0">
						<tr>
							<td><input type="text" name="Username" placeholder="Your Username" required /></td>
						</tr>
						<tr>
							<td><input type="password" name="Password" placeholder="Your Password" required /></td>
						</tr>
						<tr>
							<td><button type="submit" name="btn-login">Sign In</button></td>
						</tr>
					</table>
				</form>
			</div>
		</center>
	</body>
</html>
