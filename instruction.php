<?php
    session_start();
   if ((!isset($_SESSION['tek_emailid'])||empty($_SESSION['tek_emailid']))&&(!isset($_SESSION['tek_fname'])||empty($_SESSION['tek_fname']))) {
        echo '<script>window.top.location.href = "http://teknack.in"</script>';
        //echo '<script>window.top.location.href = "login.php"</script>'; //use to test the application
    }

    $user_name = $_SESSION['tek_fname'];
    $user_id = $_SESSION['tek_emailid'];

    include('database.php');

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
?>
<html class="full" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Auction - Just buy it</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/bootstrap-override.css" rel="stylesheet">

        <!--Title icon-->
        <link rel="shortcut icon" href="images/auction_logo_icon.png" type="image/png">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
    </head>
    <body>
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
                  <a class="navbar-brand" href="index.php"><img src="images/auction_log_nav_bar.png" class="img-rounded icon" alt="auctionit-icon" height="80px" width="220px"></img></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="http://teknack.in/">Teknack</a></li>
                        <li><a href="join-auction.php">Join The Auction </a></li>
                        <li><a href="quiz.php">Quiz</a></li>
                        <li class="active"><a href="#">Instructions<span class="sr-only">(current)</span></a></li>
                        <li><a href="winners.php">Auction Winner</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, <?php echo $user_name; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="btn" data-toggle="modal" data-target="#player-profile" role="button">View player profile</a></li>
                                <li><a href="purchases.php">View purchases</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class = "container">
            <div class="inst-background">
                <div class = "inst-block">
                    <h1>Auction Instructions</h1>
                    <ul class="h4">
                        <li>The game will be live from <span class="text-danger">11:00 IST</span> to <span class="text-danger">00:00 IST.</li><br>
                        <li>Two quizes will be held per hour.</li><br>
                        <li>The correct question will give the partcipant $1000.</li><br>
                        <li>Every 20 minutes , a new iten will be auctioned.</li><br>
                        <li>A player can start bidding from based price.</li><br>
                        <li>The player with highest auction points will be displayed in the leaderboard</li><br>
                        <li>The auction points depend on number of items bought and cash spent.</li><br>
                        <li>At the end of the auction, the player with highest bid wins the item and bidding amount is deducted from player cash balance.</li><br>

                    </ul>
                </div>
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