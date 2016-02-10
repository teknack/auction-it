<?php
	session_start();
	if(!isset($_SESSION['admin_user'])){
		header("Location: ai-admin/index.php");
	}
	$username = $_SESSION['admin_user'] ;

	include('database.php');
	include('json_func.php');

	$curtime = date("Y-m-d H:i:s");
	if(isset($_SESSION['master_control'])){
		$master_admin_control = $_SESSION['master_control'];
	}
	else{
		$master_admin_control = 0;
	}

	$sql_item = "SELECT i_id, i_name, i_imgpath, i_desc, i_baseprice, i_actualprice, i_increment, i_starttime, i_endtime FROM items WHERE (i_starttime <= '$curtime') AND (i_endtime > '$curtime') LIMIT 1";
	$result = mysqli_query($link , $sql_item);
	$row = mysqli_fetch_assoc($result);

	$current_i_id = $row["i_id"];
	$current_i_name = $row["i_name"];
	$current_i_imgpath = $row["i_imgpath"];
	$current_i_desc = $row["i_desc"];
	$current_i_baseprice = $row["i_baseprice"];
	$current_i_actualprice = $row["i_actualprice"];
	$current_i_increment = $row["i_increment"];
	$current_i_starttime = $row["i_starttime"];
	$current_i_endtime = $row["i_endtime"];

	$loaded_i_id = readJsonItem('i_id');
	$loaded_i_name = readJsonItem('i_name');
	$loaded_i_imgpath = readJsonItem('i_imgpath');
	$loaded_i_desc = readJsonItem('i_desc');
	$loaded_i_baseprice = readJsonItem('i_baseprice');
	$loaded_i_actualprice = readJsonItem('i_actualprice');
	$loaded_i_increment = readJsonItem('i_increment');
	$loaded_i_starttime = readJsonItem('i_starttime');
	$loaded_i_endtime = readJsonItem('i_endtime');

	function chatblock($userid){
		include('database.php');
		$sql = "UPDATE `user` SET `chat_status`=1 WHERE `tek_userid` = '$userid'";
		$res= mysqli_query($link , $sql);
		if(mysqli_affected_rows($link) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	function chatunblock($userid){
		include('database.php');
		$sql = "UPDATE `user` SET `chat_status`=0 WHERE `tek_userid` = '$userid'";
		$res= mysqli_query($link , $sql);
		if(mysqli_affected_rows($link) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	function setitembefore(){
		emptyJsonItem();
		exportToJsonItem();
	}
	function setitemafter(){
		emptyJsonItem();
		exportToJsonItemAfter();
	}
	function resetlivebidjson(){
		emptyJsonLiveBid();
	}
	function addnewadmin($adminuser , $password){
		include('database.php');
		$sql = "INSERT INTO `admin_user`(`username`, `password`, `master_admin_control`) VALUES ('$adminuser','$password',0)";
		$res = mysqli_query($link , $sql);
		if(mysqli_affected_rows($link) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	function removeadmin($adminuser){
		include('database.php');
		$user = $_SESSION['admin_user'];
		$adsql = "SELECT `master_admin_control` FROM `admin_user` WHERE `username` = '$adminuser'";
		$row = mysqli_fetch_assoc(mysqli_query($link , $adsql));
		if($adminuser == $user){
			return false;
		}
		if($row['master_admin_control'] == 1){
			return false;
		}
		else{
			$sql = "DELETE FROM `admin_user` WHERE `username` = '$adminuser'";
			$res = mysqli_query($link , $sql);
			if(mysqli_affected_rows($link) > 0){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function changecurrentpassword($newpassword){
		include('database.php');
		$user = $_SESSION['admin_user'];
		$sql = "UPDATE `admin_user` SET `password` = '$newpassword' WHERE `username` = '$user'";
		$res = mysqli_query($link , $sql);
		if(mysqli_affected_rows($link) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	function updatewinner(){
		include('database.php');
    	$curtime = date("Y-m-d H:i:s");
    	if(readJsonItem('i_endtime') == null){
    		return 3;
    	}
    	elseif(readJsonItem('i_endtime') <= $curtime){
    		$query = "SELECT `i_id`,`i_baseprice`, `i_actualprice`, `i_increment`,`i_bidvalue`, `i_biduser_id` FROM `items` WHERE (`i_is_won` = '0') AND (`i_endtime` < '$curtime') ORDER BY i_endtime DESC LIMIT 1";
        	$res = mysqli_query($link , $query);
        	if(mysqli_num_rows($res) > 0){
        		$row = mysqli_fetch_assoc($res);
		        $up_i_bidvalue = $row["i_bidvalue"];
		        $up_i_id = $row["i_id"];
		        $up_i_biduser_id = $row["i_biduser_id"];
		        $up_i_actualprice = $row["i_actualprice"];

		        $query_cur_usr = "SELECT `u_cashbalance`, `u_cashspent`, `meg_points`, `u_itemswon`, `u_itempoints` FROM `user` WHERE `tek_userid` = '$up_i_biduser_id' LIMIT 1";
		        $res_cur_usr = mysqli_query($link , $query_cur_usr);

		        $cur_usr_row = mysqli_fetch_assoc($res_cur_usr);

		        $up_u_cashspent = $cur_usr_row["u_cashspent"] + $up_i_bidvalue;
		        $up_u_newcashbalance = $cur_usr_row["u_cashbalance"] - $up_i_bidvalue; 
		        $up_u_itemswon = $cur_usr_row["u_itemswon"] + 1;
		         $up_u_megapoints = $cur_usr_row["meg_points"];
		        if($up_u_megapoints == 900){
		            $up_u_megapoints = 1000;
		        }
		        elseif(($up_u_megapoints + 150) < 1000){
		            $up_u_megapoints = $cur_usr_row["meg_points"] + 150;
		        }
		        else{
		            $up_u_megapoints = $up_u_megapoints + 0;
		        }

		        $cur_itempoints = 0;

		        if ($up_i_bidvalue <= ($up_i_actualprice/2)) {
		            $cur_itempoints = 6;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*3/5)) {
		            $cur_itempoints = 7;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*7/10)) {
		            $cur_itempoints = 8;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*4/5)) {
		            $cur_itempoints = 9;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*11/10)) {
		            $cur_itempoints = 10;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*6/5)) {
		            $cur_itempoints = 9;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*13/10)) {
		            $cur_itempoints = 8;
		        }elseif ($up_i_bidvalue <= ($up_i_actualprice*7/5)) {
		            $cur_itempoints = 7;
		        }else {
		            $cur_itempoints = 6;
		        }

		        $up_u_itempoints = $cur_itempoints + $cur_usr_row["u_itempoints"];

		        $up_query_usr = "UPDATE `user` SET `u_cashbalance`='$up_u_newcashbalance',`u_cashspent`='$up_u_cashspent',`u_itemswon`='$up_u_itemswon',`u_itempoints`='$up_u_itempoints',`meg_points`='$up_u_megapoints' WHERE `tek_userid` = '$up_i_biduser_id'";
		        $up_query_itm = "UPDATE `items` SET `i_is_won`='1' WHERE `i_id` = $up_i_id";

		        $up_res_usr = mysqli_query($link , $up_query_usr);
		        $up_res_itm = mysqli_query($link , $up_query_itm);

		        //update mega-event points
		        include('common-code.php');
		        sendScore("auction-it",$up_u_megapoints,$user_id);
		        return 0;
		    }
        	else{
        		return 2;
        	}
    	}
    	else{
    		return 1;
    	}
	}
	if(isset($_POST['act'])){
		$act = $_POST['act'];

		switch($act){
			case "chatblock":
				if(isset($_POST['userid'])){
					$user = $_POST['userid'];
					echo $user;
					if(chatblock($user)){
						echo "<script>alert('User blocked successfully');location.reload();</script>";
					}
					else{
						echo "<script>alert('Not valid User');location.reload();</script>";
					}
				}
				break;
			case "chatunblock":
				if(isset($_POST['userid'])){
					$user = $_POST['userid'];
					if(chatunblock($user)){
						echo "<script>alert('User unblocked successfully');location.reload();</script>";
					}
					else{
						echo "<script>alert('Not valid User');location.reload();</script>";
					}
				}
				break;
			case "reloaditembefore":
				setitembefore();
				echo "<script>alert('Items loaded successfully');location.reload();</script>";
				break;
			case "reloaditemafter":
				setitemafter();
				echo "<script>alert('Items loaded successfully');location.reload();</script>";
				break;
			case "resetlivebid":
				resetlivebidjson();
				echo "<script>alert('livebid.json reset successfully');location.reload();</script>";
				break;
			case "addnewadmin":
				if(isset($_POST['adminname']) && isset($_POST['adminpass'])){
					$adminname = $_POST['adminname'];
					$adminpass = $_POST['adminpass'];
					if(addnewadmin($adminname , $adminpass)){
						echo "<script>alert('Admin added successfully');location.reload();</script>";
					}
					else{
						echo "<script>alert('Error!');location.reload();</script>";
					}
				}
				break;
			case "removeadmin":
				if(isset($_POST['rmadminname'])){
					$adminname = $_POST['rmadminname'];
					if(removeadmin($adminname)){
						echo "<script>alert('Admin removed successfully');location.reload();</script>";
					}
					else{
						echo "<script>alert('Not valid user');location.reload();</script>";
					}
				}
				break;
			case "changepass":
				if(isset($_POST['newadpass'])){
					$pass = $_POST['newadpass'];
					if(changecurrentpassword($pass)){
						echo "<script>alert('Password changed successfully');location.reload();</script>";
					}
					else{
						echo "<script>alert('Error!');location.reload();</script>";
					}
				}
				break;
			case "updateuser":
				$status = updatewinner();
				if($status == 0){
					echo "<script>alert('User updated successfully');location.reload();</script>";
				}
				elseif($status == 1){
					echo "<script>alert('Auction is not completed');location.reload();</script>";
				}
				elseif($status == 3){
					echo "<script>alert('Auction is not started yet');location.reload();</script>";
				}
				else{
					echo "<script>alert('User already updated');location.reload();</script>";
				}
				break;
			default:
				echo "<script>alert('ERROR!');location.reload();</script>";
		}
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="ai-admin/style.css" type="text/css" />
		<!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <script type="text/javascript" src="js/bootstrap.min.js"></script>
		<!--Title icon-->
        <link rel="shortcut icon" href="images/auction_logo_icon.png" type="image/png">
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-static-top cust-navbar">
		  	<div class="container-fluid">
		    	<!-- Brand and toggle get grouped for better mobile display -->
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
		      		</button>
		      		<a class="navbar-brand" href="#">Admin Panel</a>
		    	</div>
			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      		<ul class="nav navbar-nav">
				        <li class="active"><a href="#">Main Menu<span class="sr-only">(current)</span></a></li>
				        <li><a href="index.php">Auction page</a></li>
				        <li><a href="http://teknack.in">Teknack</a></li>
		      		</ul>
		      		<ul class="nav navbar-nav navbar-right">
		        		<li class="dropdown">
		          			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?><span class="caret"></span></a>
		          			<ul class="dropdown-menu">
					            <li><a href="ai-admin/logout.php">Logout</a></li>
		          			</ul>
		        		</li>
		      		</ul>
		    	</div><!-- /.navbar-collapse -->
		  	</div><!-- /.container-fluid -->
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default">
					  	<div class="panel-heading">
					    	<h3 class="panel-title">Auction Settings</h3>
					  	</div>
					  	<div class="panel-body">
					  		<h4>Chat Control</h4>
					  		<div style="width:100%;">
					  			<div style="display:inline-block;">
							    	<form role="form" action="admin-panel.php">
							    		<button type="submit" class="btn btn-default btn-custom" id="chatblockbtn">Block User</button>
							    	</form>
						    	</div>
						    	<div style="display:inline-block;">
							    	<form role="form" action="admin-panel.php">
							    		<button type="submit" class="btn btn-default btn-custom" id="chatunblockbtn">Unblock User</button>
							    	</form>
						    	</div>
					   		</div>
					    	<br>
					    	<h4>Item Control</h4>
					    	<form role="form" class="form-inline">
					    		<button type="submit" class="btn btn-default btn-custom" id="iteminfodisbtn">Item Info</button>
					    	</form>
					    	<h4>Before Auction</h4>
					    	<form role="form" id="itemreloadbeforeform">
					    		<input type="hidden" name="act" value="reloaditembefore"></input>
					    		<button type="submit" class="btn btn-default btn-custom" id="itemreloadbeforebtn">Reload</button>
					    	</form>
					    	<h4>After Auction</h4>
					    	<form role="form" id="itemreloadafterform">
					    		<input type="hidden" name="act" value="reloaditemafter"></input>
					    		<button type="submit" class="btn btn-default btn-custom" id="itemreloadafterbtn">Reload</button>
					    	</form>
					    	<br>
					    	<h4>LiveBid Control</h4>
					    	<div style="width:100%;">
					  			<div style="display:inline-block;">
							    	<form role="form">
							    		<button type="submit" class="btn btn-default btn-custom" id="dislivebidinfo">View Info</button>
							    	</form>
							    </div>
							    <div style="display:inline-block;">
							    	<form role="form" id="resetlivebidform">
							    		<input type="hidden" name="act" value="resetlivebid"></input>
							    		<button type="submit" class="btn btn-default btn-custom" id="resetlivebidbtn">Reset</button>
							    	</form>
							    </div>
							</div>
							<br>
					    	<h4>User Control</h4>
					    	<form role="form" id="updateuserform">
					    		<input type="hidden" name="act" value="updateuser"></input>
					    		<button type="submit" class="btn btn-default btn-custom" id="updateuserbtn">Update User</button>
					    	</form>
					  	</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
					  	<div class="panel-heading">
					    	<h3 class="panel-title">Display</h3>
					  	</div>
					  	<div class="panel-body">
					    	<div class="display-block" id="disBlock">
					 			<div id="chatpaneb">
					 				<?php 
					 					include('database.php');
					 					$sql = "SELECT `tek_userid` FROM `user` WHERE `chat_status` = 0";
					 					$res = mysqli_query($link , $sql);
					 					$i = mysqli_num_rows($res);
					 					echo "<h3>List of allowed users</h3>";
					 					echo "<br>";
					 					while($i > -1){
					 						$obj = mysqli_fetch_assoc($res);
					 						echo '<span style="font-size:16px">'.$obj['tek_userid'].'</span>';
					 						echo "<br>";
					 						$i--;
					 					}
					 				?>
					 				<form role="form" action="admin-panel.php" class="form-horizontal" id="chatblockinfo">
					 					<div class="form-group">
					 						<label class="control-label col-sm-2">UserID:</label>
    										<div class="col-sm-10">
    											<input type="hidden" name="act" value="chatblock"></input>
      											<input type="text" class="form-control" name="userid" placeholder="User ID" required>
    										</div>
  										</div>
  										<div class="form-group">
   											 <div class="col-sm-offset-2 col-sm-10">
					    						<button type="submit" class="btn btn-default btn-custom" id="chatblockact">Block User</button>
					    					</div>
					    				</div>
					    			</form>
					 			</div>
					 			<div id="chatpaneub">
					 				<?php 
					 					include('database.php');
					 					$sql = "SELECT `tek_userid` FROM `user` WHERE `chat_status` = 1";
					 					$res = mysqli_query($link , $sql);
					 					$i = mysqli_num_rows($res);
					 					echo "<h3>List of blocked users</h3>";
					 					echo "<br>";
					 					while($i > -1){
					 						$obj = mysqli_fetch_assoc($res);
					 						echo '<span style="font-size:16px">'.$obj['tek_userid'].'</span>';
					 						echo "<br>";
					 						$i--;
					 					}
					 				?>
					 				<form role="form" action="admin-panel.php" class="form-horizontal" id="chatunblockinfo">
					 					<div class="form-group">
					 						<label class="control-label col-sm-2">UserID:</label>
    										<div class="col-sm-10">
    											<input type="hidden" name="act" value="chatunblock"></input>
      											<input type="text" class="form-control" name="userid" placeholder="User ID" required>
    										</div>
  										</div>
  										<div class="form-group">
   											 <div class="col-sm-offset-2 col-sm-10">
					    						<button type="submit" class="btn btn-default btn-custom" id="chatunblockact">UnBlock User</button>
					    					</div>
					    				</div>
					    			</form>
					 			</div>
					 			<div id = "iteminfo">
					 				<h4>item.json Content</h4>
					 				<span style="font-size: 16px;">Item ID: <span style="font-size: 14px;"><?php echo $loaded_i_id; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Name: <span style="font-size: 14px;"><?php echo $loaded_i_name; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Description: <span style="font-size: 14px;"><?php echo $loaded_i_desc; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Baseprice: <span style="font-size: 14px;"><?php echo $loaded_i_baseprice; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Actual Price: <span style="font-size: 14px;"><?php echo $loaded_i_actualprice; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Increment: <span style="font-size: 14px;"><?php echo $loaded_i_increment; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Start-time: <span style="font-size: 14px;"><?php echo $loaded_i_starttime; ?></span></span><br>
					 				<span style="font-size: 16px;">Item End-time: <span style="font-size: 14px;"><?php echo $loaded_i_endtime; ?></span></span><br>
					 				<h4>Current item info</h4>
					 				<span style="font-size: 16px;">Item ID: <span style="font-size: 14px;"><?php echo $current_i_id; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Name: <span style="font-size: 14px;"><?php echo $current_i_name; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Description: <span style="font-size: 14px;"><?php echo $current_i_desc; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Baseprice: <span style="font-size: 14px;"><?php echo $current_i_baseprice; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Actual Price: <span style="font-size: 14px;"><?php echo $current_i_actualprice; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Increment: <span style="font-size: 14px;"><?php echo $current_i_increment; ?></span></span><br>
					 				<span style="font-size: 16px;">Item Start-time: <span style="font-size: 14px;"><?php echo $current_i_starttime; ?></span></span><br>
					 				<span style="font-size: 16px;">Item End-time: <span style="font-size: 14px;"><?php echo $current_i_endtime; ?></span></span><br>
					 			</div>
					 			<div id="livebidinfo">
					 				<table class="table" style="background:transparent;">
									    <thead>
									      	<tr>
										        <th>User-ID</th>
										        <th>User-Name</th>
										        <th>Bidvalue</th>
									      	</tr>
									    </theead>
								    	<tbody>
								    		<?php 
								    			$i = 0;
								    			while(readJsonLiveBid($i, 'bidUserId') != null){ ?>
								    				<tr>
												        <td><?php echo readJsonLiveBid($i, 'bidUserId')?></td>
												        <td><?php echo readJsonLiveBid($i, 'bidUserName')?></td>
												        <td><?php echo readJsonLiveBid($i, 'bidValue')?></td>
								      				</tr>
								    			<?php $i++; } ?>
								    	</tbody>
								  </table>
					 			</div>
					 			<div id = "addnewamdin">
					 				<form role="form" id = "newadminform">
					 					<input type="hidden" name="act" value="addnewadmin"></input>
  										<div class="form-group">
										    <label for="text">Name:</label>
										    <input type="text" name="adminname" class="form-control">
  										</div>
  										<div class="form-group">
										    <label for="pwd">Password:</label>
										    <input type="password" name="adminpass" class="form-control">
  										</div>
  										<button type="submit" class="btn btn-default" id="newadminbtn">Submit</button>
									</form>
					 			</div>
					 			<div id="removeadmin">
					 				<h3>Current Administrators</h3>
					 				<?php 
					 					$adminsql = "SELECT `username` FROM `admin_user`";
					 					$res = mysqli_query($link , $adminsql);
					 					$i = mysqli_num_rows($res);
					 					echo "<br>";
					 					while($i > -1){
					 						$obj = mysqli_fetch_assoc($res);
					 						echo '<span style="font-size:16px">'.$obj['username'].'</span>';
					 						echo "<br>";
					 						$i--;
					 					}
					 				?>
					 				<form role="form" id = "removeadminform">
					 					<input type="hidden" name="act" value="removeadmin"></input>
					 					<div class="form-group">
										    <label for="text">Admin User Name:</label>
										    <input type="text" name="rmadminname" class="form-control">
  										</div>
  										<button type="submit" class="btn btn-default" id="removeadminbtn">Submit</button>
					 				</form>
					 			</div>
					 			<div id="chngpass">
					 				<form role="form" id = "chngpassform">
					 					<input type="hidden" name="act" value="changepass"></input>
					 					<div class="form-group">
										    <label for="text">New Password:</label>
										    <input type="text" name="newadpass" class="form-control">
  										</div>
  										<button type="submit" class="btn btn-default" id="chngpassbtn">Submit</button>
					 				</form>
					 			</div>
					 			<div id="update"></div>
					 			<script type="text/javascript">
				 					$("#chatpaneb").hide();
									$("#chatpaneub").hide();
									$("#iteminfo").hide();
									$("#livebidinfo").hide();
									$("#addnewamdin").hide();
									$("#removeadmin").hide();
									$("#chngpass").hide();
									$("#update").hide();
								</script>
					    	</div>
					  	</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-default">
					  	<div class="panel-heading">
					    	<h3 class="panel-title">Admin Settings</h3>
					  	</div>
					  	<div class="panel-body">
					    	<h4>New Admin</h4>
					    	<form role="form" class="form-inline">
					    		<button type="submit" class="btn btn-default btn-custom" id="addnewadminbtn">Add</button>
					    		<button type="submit" class="btn btn-default btn-custom" id="removeprevadminbtn">Remove</button>
					    	</form>
					    	<br><br>
					    	<h4>Personal Settings</h4>
					    	<form role="form" class="form-inline">
					    		<button type="submit" class="btn btn-default btn-custom" style="width:150px;" id="newpass">Change Password</button>
					    	</form>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$("#chatblockbtn").click(function(e) {
			e.preventDefault();
			$("#chatpaneub").hide();
			$("#iteminfo").hide();
			$("#livebidinfo").hide();
			$("#addnewamdin").hide();
			$("#removeadmin").hide();
			$("#chngpass").hide();
			$("#chatpaneb").show();
		});
		$("#chatunblockbtn").click(function(e) {
			e.preventDefault();
			$("#chatpaneb").hide();
			$("#iteminfo").hide();
			$("#livebidinfo").hide();
			$("#addnewamdin").hide();
			$("#removeadmin").hide();
			$("#chngpass").hide();
			$("#chatpaneub").show();   			
		});
		$("#iteminfodisbtn").click(function(e) {
			e.preventDefault();
			$("#chatpaneb").hide();
			$("#chatpaneub").hide();
			$("#livebidinfo").hide();
			$("#addnewamdin").hide();
			$("#removeadmin").hide();
			$("#chngpass").hide();
			$("#iteminfo").show();   			
		});
		$("#dislivebidinfo").click(function(e) {
			e.preventDefault();
			$("#chatpaneb").hide();
			$("#chatpaneub").hide();
			$("#iteminfo").hide();
			$("#addnewamdin").hide();
			$("#removeadmin").hide();
			$("#chngpass").hide();
			$("#livebidinfo").show();   			
		});
		$("#addnewadminbtn").click(function(e) {
			e.preventDefault();
			$("#chatpaneb").hide();
			$("#chatpaneub").hide();
			$("#iteminfo").hide();
			$("#livebidinfo").hide();
			$("#removeadmin").hide();
			$("#chngpass").hide();
			$("#addnewamdin").show();   			
		});
		$("#removeprevadminbtn").click(function(e) {
			e.preventDefault();
			$("#chatpaneb").hide();
			$("#chatpaneub").hide();
			$("#iteminfo").hide();
			$("#livebidinfo").hide();
			$("#addnewamdin").hide();
			$("#chngpass").hide();
			$("#removeadmin").show();   			
		});
		$("#newpass").click(function(e) {
			e.preventDefault();
			$("#chatpaneb").hide();
			$("#chatpaneub").hide();
			$("#iteminfo").hide();
			$("#livebidinfo").hide();
			$("#addnewamdin").hide();
			$("#removeadmin").hide();
			$("#chngpass").show();   			
		});
	</script>
	<script type="text/javascript">
		$("#chatblockact").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#chatblockinfo").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#chatunblockact").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#chatunblockinfo").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#itemreloadbeforebtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#itemreloadbeforeform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#itemreloadafterbtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#itemreloadafterform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#resetlivebidbtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#resetlivebidform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#newadminbtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#newadminform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#removeadminbtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#removeadminform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	alert(data);
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#chngpassbtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#chngpassform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
    	$("#updateuserbtn").click(function(e) {
	        e.preventDefault();
	        var formdata = $("#updateuserform").serialize();
	        $.ajax({
	            url: "admin-panel.php",
	            type: "POST",
	            data: formdata,
	            success: function(data){
	            	$("#update").html(data);
	            }
	        });
    	});
	</script>
</html>