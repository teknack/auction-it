<?php 
    session_start();
    if(isset($_POST['userid']) && isset($_POST['username'])){ //use this to test the application
        $_SESSION['tek_userid'] = $_POST['userid'];
        $_SESSION['tek_name'] = $_POST['username'];
    }
    if ((!isset($_SESSION['tek_userid'])||empty($_SESSION['tek_userid']))&&(!isset($_SESSION['tek_name'])||empty($_SESSION['tek_name']))) {
        //echo '<script>window.top.location.href = "http://teknack.in"</script>';
        echo '<script>window.top.location.href = "login.php"</script>';
    }else{
        $user_name = $_SESSION['tek_name'];
        $user_id = $_SESSION['tek_userid'];
        //*****Set Initial cash Balance Here*****//
        $cashbalance = 30000; 
        include("database.php");
          
        $tek_userid=$_SESSION['tek_userid'];
        $tek_name=$_SESSION['tek_name'];
                  
        $sql = "SELECT 1 FROM user WHERE tek_userid = '$tek_userid' LIMIT 1";
                  
        $result = mysqli_query($link , $sql);
        if (!$result) {
            echo "unable to connect 2";
        }
        if (!mysqli_num_rows($result) > 0) {
            //echo "Record Absent";
            $sql2 = "INSERT INTO user (tek_userid, tek_name, u_firstvisit, u_cashbalance) VALUES ( '$tek_userid', '$tek_name', 1, '$cashbalance')";
            if (!mysqli_query($link , $sql2)) {
                die("unable to connect 3");
            }
        }
        $userifo = "SELECT `u_cashbalance`, `u_itempoints`, `u_quizlevel`, `chat_status` FROM `user` WHERE `tek_userid` = '$user_id'";
        if(!mysqli_query($link , $userifo)){
            die('unable to get user info');
        }
        else{
            $user_info = mysqli_fetch_assoc(mysqli_query($link , $userifo));
            $user_cash = $user_info["u_cashbalance"];
            $user_auct_points = $user_info["u_itempoints"];
            $user_quiz_level = $user_info["u_quizlevel"];
        }
        mysqli_close($link);
    }
?>
<!DOCTYPE html>
<html class="full" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Auction - Just buy it</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/bootstrap-override.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/auction_logo_icon.png" type="image/png">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
    </head>

    <body>
        <div id="pagebg"></div>
        <!-- Navigation -->
       <nav class="navbar navbar-inverse navbar-static-top navbar-custom">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                  <a class="navbar-brand" href="index.php"><img src="images/auction_log_nav_bar.png" class="img-rounded icon nav-icon" alt="auctionit-icon" height="70px" width="220px"></img></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                   
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, <?php echo $user_name; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="btn" data-toggle="modal" data-target="#player-profile" role="button">View player profile</a></li>
                                <li><a href="purchases.php">View purchases</a></li>
                                <li><a href="logout.php">Logout</a></li><!--Use this to test application-->
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class = "container">
            <!-- Put your page content here! -->
            <img src="images/auctionnewlogo.png" class="img-rounded logo" alt="auctionit-txt" width="700px" height="300px">
            <div class = "links">
                <a href = "quiz.php" style = "font-size: 35px; margin-left: 0px;">Quiz</a>
                <a href = "winners.php" style = "font-size: 45px; margin-left: 20px;">Auction Winner</a>
                <a href = "join-auction.php" style = "font-size: 70px; margin-left: 20px;">Join the Auction</a>
                <a href = "instruction.php" style = "font-size: 45px; margin-left: 20px;">Instructions</a>
                <a href = "http://teknack.in" style = "font-size: 35px; margin-left: 20px;">Teknack</a>
            </div>
        </div>
        <div class="modal fade" id="player-profile" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Player Profile</h4>
                    </div>
                    <div class="modal-body">
                        <div class="profile-img">
                            <img src="images/profile_image.png" class="thumbnail" width="200px" height="200px"></img>
                        </div>
                        <div class="profile-ifo">
                            <span>Teknack User ID: <?php echo $user_id; ?></span><br>
                            <span>Teknack User Name: <?php echo $user_name; ?></span><br>
                            <span>Cashbalance: <?php echo $user_cash; ?></span><br>
                            <span>Auction Points: <?php echo $user_auct_points; ?></span><br>
                            <span>Quiz Level: <?php echo $user_quiz_level; ?></span><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
