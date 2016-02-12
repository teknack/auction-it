<?php 
    session_start();
    if ((!isset($_SESSION['tek_emailid'])||empty($_SESSION['tek_emailid']))&&(!isset($_SESSION['tek_fname'])||empty($_SESSION['tek_fname']))) {
        echo '<script>window.top.location.href = "http://teknack.in"</script>';
        //echo '<script>window.top.location.href = "login.php"</script>'; //use to test the application
    }
    
    $curtime = date("Y-m-d H:i:s");
    $itemPresent = false;
    $next_itemPresent = false;

    $user_name = $_SESSION['tek_fname'];
    $user_id = $_SESSION['tek_emailid'];

    include('database.php');
    include('json_func.php');
    $name_array = explode("@" , $_SESSION['tek_emailid']);
    $chat_name = $name_array[0];

    $userifo = "SELECT `u_cashbalance`, `u_itempoints`, `u_quizlevel`, `chat_status` FROM `user` WHERE `tek_userid` = '$user_id'";
    if(!mysqli_query($link , $userifo)){
        die('unable to get user info');
    }
    else{
        $user_info = mysqli_fetch_assoc(mysqli_query($link , $userifo));
        $user_cash = $user_info["u_cashbalance"];
        $user_auct_points = $user_info["u_itempoints"];
        $user_quiz_level = $user_info["u_quizlevel"];
        $user_chat_status = $user_info["chat_status"];
    }

    //update winner info after endtime for item and refresh item.json
    if(readJsonItem('i_endtime') <= $curtime){
        $query = "SELECT `i_id`,`i_baseprice`, `i_actualprice`, `i_increment`,`i_bidvalue`, `i_biduser_id` FROM `items` WHERE (`i_is_won` = '0') AND (`i_endtime` < '$curtime') ORDER BY i_endtime DESC LIMIT 1";
        $res = mysqli_query($link , $query);
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
        //include('common-code.php');
        //sendScore("auction-it",$up_u_megapoints,$user_id);

        //use to debug auto update script
        /*
        if(!$up_res_usr){
            echo "error 1";
        }
        if(!$up_res_itm){
           echo "error 2";
        }
        */
        //reset item.json
        emptyJsonItem();
        //reset livebid.json
        emptyJsonLiveBid();
    }

    //if item is absent load the next item to item.json
    if (readJsonItem('i_id') == null) {
        //load next item info when the result is absent
        $query = "SELECT * FROM `items` WHERE `i_starttime` >= '$curtime' ORDER BY `i_starttime` LIMIT 1";
        $res = mysqli_query($link , $query);
        if(mysqli_num_rows($res) > 0){
            emptyJsonItem();
            exportToJsonItem();
        }
    }
   
    //Query for Next Item
    $next_sql = "SELECT i_name, i_imgpath, i_starttime FROM items WHERE (i_starttime > '$curtime') ORDER BY i_starttime LIMIT 1";
    $next_result = mysqli_query($link , $next_sql);
    if (!$next_result) {
        echo "unable to connect next_2";
    }
    if (mysqli_num_rows($next_result) > 0) {
        $next_itemPresent = true;
        $next_row = mysqli_fetch_assoc($next_result);
        $next_i_name = $next_row["i_name"];
        $next_i_imgpath = $next_row["i_imgpath"];
        $next_i_starttime = $next_row["i_starttime"];
    }

    //Query for User Cash Balance
    $user_sql = "SELECT u_cashbalance FROM user WHERE tek_userid = '".$_SESSION['tek_emailid']."' LIMIT 1";
    $user_result = mysqli_query($link , $user_sql);
    if (!$user_result) {
        echo "unable to connect user_2";
    }
    if (mysqli_num_rows($user_result) > 0) {
        //Result is present
        $user_row = mysqli_fetch_assoc($user_result);
        $user_cashbalance = $user_row["u_cashbalance"];
        $_SESSION['auc_user_cash'] = $user_cashbalance;
    }
      
    //Query for Current Auction Item
    $sql = "SELECT i_id, i_name, i_imgpath, i_desc, i_baseprice, i_actualprice, i_increment, i_starttime, i_endtime FROM items WHERE (i_starttime <= '$curtime') AND (i_endtime > '$curtime') LIMIT 1";
    $result = mysqli_query($link , $sql);
    if (!$result) {
        echo "unable to connect 2";
    }
    if (!mysqli_num_rows($result) > 0) {
        //Do something here if the result is absent. no item to sell
    }else{ //Result is present
        $itemPresent = true;
        $row = mysqli_fetch_assoc($result);

        $i_id = $row["i_id"];
        $i_name = $row["i_name"];
        $i_imgpath = $row["i_imgpath"];
        $i_desc = $row["i_desc"];
        $i_baseprice = $row["i_baseprice"];
        $i_actualprice = $row["i_actualprice"];
        $i_increment = $row["i_increment"];
        $i_starttime = $row["i_starttime"];
        $i_endtime = $row["i_endtime"];

        //check whether the item is loaded correctly
        if(readJsonItem('i_id') != $i_id){
            if($next_itemPresent){
                emptyJsonItem();
                exportToJsonItemAfter();
            }
        }
    }//End of else result is present
    mysqli_close($link);
?>

<html class="full" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="refresh" content="60">
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
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.countdownTimer.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="chat.js"></script>
        <script type="text/javascript">

        <?php 
        if (!isset($_SESSION['tek_emailid'])||empty($_SESSION['tek_emailid'])) { ?>
            window.top.location.assign("http://teknack.in");
        <?php } ?>

        setTimeout(function(){  // Whole page reload for item change
            window.location.reload(true); 
        },<?php 
        if ($itemPresent) {
            echo (strtotime($i_endtime)-strtotime(date("Y-m-d H:i:s"))-1)*1000; //Reload before 1 secs of end time
        }elseif ($next_itemPresent) {
            echo (strtotime($next_i_starttime)-strtotime(date("Y-m-d H:i:s"))+3)*1000; //Reload after 3 secs after start time of next item
        }else{ ?>
            60000  //If no next item present reload after every 30 secs
        <?php } ?>);

        function updateDiv(){ //Function to reload div for live bidding
            $('#bidfunctioninfo').load('bidfunction.php');
        }
        <?php if ($itemPresent) { ?>
            setInterval(updateDiv, 5000); //Reload Live Bid module after every 5 secs
        <?php } ?>
        </script>

        <?php 
            if ($next_itemPresent) {
                $next_hours = intval((strtotime($next_i_starttime)-strtotime(date("Y-m-d H:i:s")))/3600);
                $next_minutes = intval((strtotime($next_i_starttime)-strtotime(date("Y-m-d H:i:s")))/60)-($next_hours*60);
                $next_seconds = intval(strtotime($next_i_starttime)-strtotime(date("Y-m-d H:i:s")))-($next_minutes*60)-($next_hours*3600);
        ?>
        <script>
            $(function(){
                $('#next_hms_timer').countdowntimer({
                    hours :<?php echo $next_hours; ?>,
                    minutes :<?php echo $next_minutes; ?>,
                    seconds :<?php echo $next_seconds; ?>,
                    borderColor : "transparent",
                    backgroundColor : "transparent",
                    fontColor : "inherit",                             
                    size : "lg"
                });
            });
        <?php } ?>
        </script>
        <script type="text/javascript">
            var name = '<?php echo "$chat_name:  "; ?>';
            $("#name-area").html("You are: <span>" + name + "</span>");
            // kick off chat
            var chat =  new Chat();
            $(function() {
                chat.getState(); 
                // watch textarea for key presses
                $("#sendie").keydown(function(event) {  
                    var key = event.which;  
                    //all keys including return.  
                    if (key >= 33) {
                        var maxLength = $(this).attr("maxlength");  
                        var length = this.value.length;  
                        // don't allow new content if length is maxed out
                        if (length >= maxLength) {  
                            event.preventDefault();  
                        } 
                    }                                                                                                                                                                                       });
                    // watch textarea for release of key press
                    $('#sendie').keyup(function(e) {                     
                        if (e.keyCode == 13) { 
                        var text = $(this).val();
                        var maxLength = $(this).attr("maxlength");  
                        var length = text.length; 
                        // send 
                        if (length <= maxLength + 1) { 
                            chat.send(text, name);  
                            $(this).val("");
                        } else {
                            $(this).val(text.substring(0, maxLength));
                        }   
                    }
                });     
            });
        </script>
        <style>
            @media screen and (min-width: 1600px) {
                .main-panel{
                    height: 600px;
                }
                .chat-panel{
                    height: 600px;
                }
                .bid-function > .panel{
                    height: 265px;
                }
                .live-bid > .panel {
                    height: 265px;
                }
                .form-group{
                    margin-top: 60px;
                }
                #chat-area{
                    height:400px;
                }
            }
            @media screen and (min-width: 1920px) {
                .main-panel{
                    height: 700px;   
                }
                .chat-panel{
                    height: 700px;   
                }
                .bid-function > .panel{
                    height: 315px;
                }
                .live-bid > .panel {
                    height: 315px;
                }
                .form-group{
                    margin-top: 60px;
                }
                 #chat-area{
                    height:490px;
                }
            }
        </style>
    </head>
    <body onload="setInterval('chat.update()', 1000)">
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
                        <li class="active"><a href="#">Join The Auction <span class="sr-only">(current)</span></a></li>
                        <li><a href="quiz.php">Quiz</a></li>
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
            <div class = "row">
                <div class = "col-md-3">
                    <div class ="panel panel-default info-panel">
                        <div class="panel-body">
                            <!-- main function panel -->
                            <div class="main-bid-panel" id="bidfunctioninfo">
                                <div class = "bid-function">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Place your bid here....</h3>
                                        </div>
                                        <div class="panel-body">
                                            <!-- place bidding function here -->
                                            Please Wait!
                                        </div>
                                    </div>
                                </div>
                                <div class = "live-bid">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Live Bid...</h3>
                                        </div>
                                        <div class="panel-body">
                                            Please Wait!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class="panel panel-default main-panel">
                        <div class="panel-body">
                            <?php if ($itemPresent) { ?>
                                <img class = "thumbnail" style="background:transparent; border:0; margin: 0 auto; margin-bottom:30px;" src="<?php echo $i_imgpath; ?>" width="500px" height="300px">
                            <?php }elseif ($next_itemPresent) { ?>
                                <img class = "thumbnail" style="background:transparent; border:0; margin: 0 auto; margin-bottom:30px;" src="<?php echo $next_i_imgpath; ?>" width="500px" height="300px">
                            <?php }else{ ?>
                                <img class="thumbnail" style="background:transparent; border:0; margin: 0 auto; margin-bottom:30px; width:90%; height:55%;" src="images/commingSoon.jpg" width="500px" height="300px">
                            <?php } ?>
                        
                            <?php if ($itemPresent) { ?>
                                <span style="font-size: 23px;">Item name: <?php echo $i_name;?></span><br>
                                <span style = "font-size: 25px;">Base price:</span><span style = "font-size: 20px;"> <?php echo number_format($i_baseprice, 2, ".", ",");?></span><br>
                                <span style = "font-size: 25px;">Time Remaining: <span id="hms_timer" style="font-size: 20px;;"></span></span><br><br>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">View Description</button>
                                
                                <?php 
                                    $hours = intval((strtotime($i_endtime)-strtotime(date("Y-m-d H:i:s")))/3600);
                                    $minutes = intval((strtotime($i_endtime)-strtotime(date("Y-m-d H:i:s")))/60)-($hours*60);
                                    $seconds = intval(strtotime($i_endtime)-strtotime(date("Y-m-d H:i:s")))-($minutes*60)-($hours*3600);
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
                            <?php }elseif ($next_itemPresent) { ?>
                                <span style = "font-size: 25px;">Next item name: <?php echo $next_i_name;?></span><br>
                                <span style = "font-size: 25px;">Bidding Starts In: <span id="next_hms_timer" style="font-size: 25px;"></span></span>
                            <?php }else{ ?>
                                <span style = "font-size: 25px;">New item coming shortly...</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class ="panel panel-default chat-panel">
                        <div class="panel-heading chat-head">
                            <h3 class="panel-title">Chat box</h3>
                        </div>
                        <div class="panel-body">
                            <?php if($user_chat_status == 0){ ?>
                            <div id="page-wrap">
                                <div class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading"><p id="name-area"></p></h4>
                                        <div id="chat-wrap"><div id="chat-area"></div></div>
                                    </div>
                                </div>
                                <form id="send-message-area">
                                    <div class="form-group" style="width:100%;">
                                        <textarea class="form-control" placeholder="Enter message..." id="sendie" maxlength = '100'></textarea>
                                    </div>
                                </form>
                            </div>
                            <?php } else {?>
                                <h3>Your chat is blocked by administrator</h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
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
    </body>
</html>