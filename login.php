<!DOCTYPE html>
<html class="full">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<title>Login</title>
		<!--Title icon-->
        <link rel="shortcut icon" href="/images/auction_logo_icon.png" type="image/png">
        <style>
        	*{
				margin:0;
				padding:0;
			}
			.full{
				background: url('images/background.jpg') no-repeat center center fixed;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			body{
				margin-top: 50px;
			}
			#login-form{
				margin-top:70px;
			}
			table{
				border:solid #dcdcdc 1px;
				padding:25px;
				box-shadow: 0px 0px 1px rgba(0,0,0,0.2);
				background: url("images/panel-bg.png");
			}
			table tr,td{
				padding:15px;
			}
			table tr td input{
				width:97%;
				height:45px;
				border:solid #e1e1e1 1px;
				border-radius:3px;
				padding-left:10px;
				font-family:Verdana, Geneva, sans-serif;
				font-size:16px;
				background:#f9f9f9;
				transition-duration:0.5s;
				box-shadow: inset 0px 0px 1px rgba(0,0,0,0.4);
			}

			table tr td button{
				width:100%;
				height:45px;
				border:0px;
				background:rgba(12,45,78,11);
				background:-moz-linear-gradient(top, #595959 , #515151);
				border-radius:3px;
				box-shadow: 1px 1px 1px rgba(1,0,0,0.2);
				color:#f9f9f9;
				font-family:Verdana, Geneva, sans-serif;
				font-size:18px;
				font-weight:bolder;
				text-transform:uppercase;
			}
			table tr td button:active{
				position:relative;
				top:1px;
			}
			table tr td a{
				text-decoration:none;
				color:#00a2d1;
				font-family:Verdana, Geneva, sans-serif;
				font-size:18px;
			}
        </style>
	</head>
	<body>
		<center>
			<div id="login-form">
				<form method = "post" action = "index.php" id="log_form">
					<table align="center" width="30%" border="0">
						<tr>
							<td><input type="text" name="userid" placeholder="Your UserID" required /></td>
						</tr>
						<tr>
							<td><input type="text" name="username" placeholder="Your Username" required /></td>
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
