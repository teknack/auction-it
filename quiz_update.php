<?php
    session_start();
    $myUserid = $_SESSION['tek_userid'];
    $myUsername = $_SESSION['tek_name'];
    //error_reporting(0);

    include('json_func.php');
    include('database.php');
    if(isset($_POST['quizOption0']) || isset($_POST['quizOption1'])){
        $div_id = "quiz-main-panel";

        $question1 = $_POST['quizOption0'];
        $question2 = $_POST['quizOption1'];

        $addAmount = 0;
        $quiz_level = 0;

        $q_ans[0] = readJsonQuiz(0 ,'q_ans');
        $q_ans[1] = readJsonQuiz(1 ,'q_ans');

        if ($question1 == $q_ans[0]) {
            $addAmount = $addAmount + 1000;
            $quiz_level = $quiz_level + 10;
        }
        if ($question2 == $q_ans[1]) {
            $addAmount = $addAmount + 1000;
            $quiz_level = $quiz_level + 10;
        }

        $user_query = "SELECT `u_cashbalance`, `u_quizlevel` FROM `user` WHERE `tek_userid` = '$myUserid'";
        $user_data = mysqli_fetch_assoc(mysqli_query($link , $user_query));
        $user_cashbalance = $user_data["u_cashbalance"];
        $user_quizlevel = $user_data["u_quizlevel"];

        $user_cashbalance = $user_cashbalance + $addAmount;
        $user_quizlevel = $user_quizlevel + $quiz_level;

        $sql ="UPDATE `user` SET `u_cashbalance`='$user_cashbalance', `u_quizlevel`='$user_quizlevel', `quiz_attempt_status` = 1 WHERE `tek_userid` = '$myUserid'";
        $res = mysqli_query($link , $sql);
             
        //for debugging
        /*if(mysqli_affected_rows($link)){
            echo "<script>alert('success');</script>";
        }*/
    }
?>
<div class="panel-body" id="quiz-main-panel">
    <h1>Quiz Submitted successfully!</h1>
</div>
<script>
    setTimeout(function(){
        window.location ="index.php";
    },3000);
</script>