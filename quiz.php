<?php 
    session_start();
    if ((!isset($_SESSION['tek_emailid'])||empty($_SESSION['tek_emailid']))&&(!isset($_SESSION['tek_fname'])||empty($_SESSION['tek_fname']))) {
        echo '<script>window.top.location.href = "http://teknack.in"</script>';
        //echo '<script>window.top.location.href = "login.php"</script>'; //use to test the application
    }
    
    $user_name = $_SESSION['tek_fname'];
    $user_id = $_SESSION['tek_emailid'];

    $curtime = date("Y-m-d H:i:s");
    $itemPresent = false;
    $quizPresent = false;
    $next_quizPresent = false;
    $quiz_status = false;

    $tek_user = $_SESSION['tek_emailid'];
    include('database.php');
    include('json_func.php');

    //integrity check and refesh quiz.json

    $currentStartTime = readJsonQuiz(1 ,'q_starttime');
    $currentEndTime = readJsonQuiz(1 ,'q_endtime');

    if(!(($currentStartTime <= $curtime) && ($currentEndTime > $curtime))){ // refresh the quiz attempt flag and load new quiz into quiz.json
        emptyJsonQuiz();
        $_SESSION['quizStatus'] = false;
        exportToJsonQuiz();
        $sql = "UPDATE `user` SET `quiz_attempt_status` = 0 WHERE `tek_userid` = '$tek_user'";
        if(!(mysqli_query($link , $sql))){
            die ('unable to update!');
        }
    }

    $query = "SELECT `quiz_attempt_status` FROM `user` WHERE `tek_userid` = '$tek_user'";
    if(mysqli_query($link , $query)){
        $u_row = mysqli_fetch_assoc(mysqli_query($link , $query));
        if($u_row['quiz_attempt_status'] == 1){
            $quiz_status = true;
        }
    }
    else{
        die ('unable to connect!');
    }

    $quizAttempted = $quiz_status;

    for($i = 0 ; $i < 2 ; $i++){
        $q_question[$i] = readJsonQuiz($i ,'q_question');
        $q_op1[$i] = readJsonQuiz($i ,'q_op1');
        $q_op2[$i] = readJsonQuiz($i ,'q_op2');
        $q_op3[$i] = readJsonQuiz($i ,'q_op3');
        $q_op4[$i] = readJsonQuiz($i ,'q_op4');
        $q_ans[$i] = readJsonQuiz($i ,'q_ans');
    }
    $q_endtime = readJsonQuiz(1 ,'q_endtime');

    if(!((readJsonQuiz(0 ,'q_id') == null) && (readJsonQuiz(1 ,'q_id') == null))){
         $quizPresent = true;
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

    $i_name = readJsonItem('i_name');
    $i_imgpath = readJsonItem('i_imgpath');
    $i_desc = readJsonItem('i_desc');
    $i_baseprice = readJsonItem('i_baseprice');
    $i_currentbidvalue = readJsonLiveBid(0, 'bidValue');

    if($i_name != null){
         $itemPresent = true;
    }
    mysqli_close($link);
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

        <!--Title icon-->
        <link rel="shortcut icon" href="images/auction_logo_icon.png" type="image/png">

        <!-- Custom CSS -->
        <link href="css/bootstrap-override.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.countdownTimer.js"></script>
        <script type="text/javascript">
            /*
            <?php 
                if (!isset($_SESSION['tek_userid'])||empty($_SESSION['tek_userid'])) { ?>
                    window.top.location.assign("http://www.teknack.in");
            <?php } ?>
            */

            setTimeout(function(){  // Whole page reload for item change
                window.location.reload(true); 
            },<?php 
            if ($quizPresent) {
                echo (strtotime($q_endtime[0])-strtotime(date("Y-m-d H:i:s"))+3)*1000; //Reload after 3 secs of end time
            }elseif ($next_quizPresent) {
                echo (strtotime($next_q_starttime)-strtotime(date("Y-m-d H:i:s"))+3)*1000; //Reload after 3 secs after start time of next quiz
            }else{ ?>
                60000  //If quiz present reload after every 60 secs
            <?php } ?>);
         </script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <style>
            @media screen and (min-width: 1600px) {
                .quiz-form{
                    height: 600px;
                }
                .quiz-other-info{
                    height: 600px;
                }
                
            }
            @media screen and (min-width: 1920px) {
                .quiz-form{
                    height: 700px;   
                }
                .quiz-other-info{
                    height: 700px;
                }
            }
        </style>
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
                        <li class="active"><a href="#">Quiz<span class="sr-only">(current)</span></a></li>
                        <li><a href="instruction.php">Instructions</a></li>
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
        <div class = "container" style="width:85%;">
            <!-- Put your page content here! -->
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default quiz-form">
                        <div class="panel-body" id="quiz-main-panel">
                            <?php if ($quizAttempted) { ?>
                                <h2 class="text-info">Quiz already attempted.</h2><br/>
                                <span style = "font-size: 25px;">Next Quiz Starts in: <span id="hms_timer" style="font-size: 20px;;"></span></span><br><br>
                                <?php 
                                    $hours = intval((strtotime($q_endtime)-strtotime(date("Y-m-d H:i:s")))/3600);
                                    $minutes = intval((strtotime($q_endtime)-strtotime(date("Y-m-d H:i:s")))/60)-($hours*60);
                                    $seconds = intval(strtotime($q_endtime)-strtotime(date("Y-m-d H:i:s")))-($minutes*60)-($hours*3600);
                                ?>
                                <script>
                                $(function(){
                                    $('#hms_timer').countdowntimer({
                                        hours :<?php echo $hours; ?>,
                                        minutes :<?php echo $minutes; ?>,
                                        seconds :<?php echo $seconds; ?>,
                                        borderColor : "transparent",
                                        backgroundColor : "transparent",
                                        fontColor : "inherit",        
                                        size : "lg"
                                    });
                                });
                                </script>
                            <?php } elseif ($quizPresent) { $i1 = 0; ?>
                                <?php while ($i1 < 2) {?>
                                    <h3><?php echo $q_question[$i1];?></h3>
                                    <form method="post" action="quiz_update.php" role="form">
                                        <div class="radio">
                                            <label><input type="radio" name="quizOption<?php echo $i1; ?>" value="<?php echo $q_op1["$i1"]; ?>"><?php echo $q_op1["$i1"]; ?></label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="quizOption<?php echo $i1; ?>" value="<?php echo $q_op2["$i1"]; ?>"><?php echo $q_op2["$i1"]; ?></label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="quizOption<?php echo $i1; ?>" value="<?php echo $q_op3["$i1"]; ?>"><?php echo $q_op3["$i1"]; ?></label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="quizOption<?php echo $i1; ?>" value="<?php echo $q_op4["$i1"]; ?>"><?php echo $q_op4["$i1"]; ?></label>
                                        </div>
                                        <br>
                                    <?php $i1++; } ?>
                                    <button id="quiz-submit-btn" type="submit" class="btn btn-default">Submit</button>
                                    </form>
                            <?php }else{ ?>
                                   <h2>The next quiz coming up shortly...</h2><br/>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default quiz-other-info">
                        <div class="panel-body">
                            <h3>Current Item Info:</h3><br>
                            <?php if ($itemPresent) { ?>
                                <img class = "thumbnail" src="<?php echo $i_imgpath; ?>" width="300px" height="200px" style="margin-left:10px; background:transparent; border:0;"></img>
                                <span style="font-size: 20px;">Item Name: <?php echo $i_name;?></span><br>
                                <span style="font-size: 20px;">Base Price: <?php echo $i_baseprice;?></span><br>
                                <span style="font-size: 20px;">Current Bid Value: <?php if($i_currentbidvalue == null){ echo 0; } else{ echo $i_currentbidvalue; }?></span><br><br>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">View Description</button>
                            <?php }else{ ?>
                                <img class = "thumbnail" src="images/commingSoon.jpg" width="500px" height="300px" style="margin:0 auto; padding-bottom:20px; background:transparent; border:0; height:50%; width:90%;"></img>
                                <span style="font-size: 20px;">Comming soon...</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Item Description</h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $i_desc;?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--player profile modal-->
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
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
<script type="text/javascript">
    $("#quiz-submit-btn").click(function(e) {
        e.preventDefault();
        var formdata = $("form").serialize();
        $.ajax({
            url: "quiz_update.php",
            type: "POST",
            data: formdata,
            success: function(data){
                $('#quiz-main-panel').load('quiz_update.php');
            }
        });
    });
</script>