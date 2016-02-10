<?php
    session_start();
    $myUserid = $_SESSION['tek_userid'];
    $myUsername = $_SESSION['tek_name'];
    //error_reporting(0);

    include('json_func.php');
    include('database.php');

    if(isset($_POST['bidValue'])){
        $div_id = "bidfnc";
        $bidvalue = $_POST['bidValue'];
        
        $i_id = readJsonItem('i_id');
       
        $sql_query = "UPDATE `items` SET `i_bidvalue` = '$bidvalue' , `i_biduser_id` = '$myUserid' , `i_biduser_name` = '$myUsername',`i_is_won` = '0' WHERE `i_id` = '$i_id' AND `i_bidvalue` < '$bidvalue'";
        $sql_res = mysqli_query($link , $sql_query);

        if(mysqli_affected_rows($link) == 1){
            exportToJsonLiveBid($bidvalue, $myUserid, $myUsername , $i_id);
        }
    }
?>
<div class="panel-body" id="bidfnc">
    <img src="images/wait.gif" height="150px" width="150px"></img>
</div>
