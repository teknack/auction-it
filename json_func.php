<?php
/***********ITEM.JSON FUNCTIONS*************/
	function exportToJsonItem() { // Copy data from database into Json File Before an auction has started
	    
	    include('database.php');
	    $curtime = date("Y-m-d H:i:s");
	    $sql = "SELECT `i_id`, `i_name`, `i_imgpath`, `i_desc`, `i_baseprice`, `i_actualprice`, `i_increment`, `i_starttime`, `i_endtime`FROM `items` WHERE `i_starttime` > '$curtime' ORDER BY `i_starttime` LIMIT 1 ";
	    $res = mysqli_query($link , $sql);
	    $records = array();
	    if($obj = mysqli_fetch_object($res)) {
	        $records []= $obj;
	       // echo $obj->i_name;
	    }
	    file_put_contents("items.json", json_encode($records));
	    mysqli_close($link);
	}

	function exportToJsonItemAfter() { // Copy data from database into Json File After an auction has started.
	    
	    include('database.php');
	    $curtime = date("Y-m-d H:i:s");
	    $sql = "SELECT i_id, i_name, i_imgpath, i_desc, i_baseprice, i_actualprice, i_increment, i_starttime, i_endtime FROM items WHERE (i_starttime <= '$curtime') AND (i_endtime > '$curtime') LIMIT 1";// (i_starttime > '$curtime') ORDER BY i_starttime LIMIT 1
	    $res = mysqli_query($link , $sql);
	    $records = array();
	    if($obj = mysqli_fetch_object($res)) {
	        $records []= $obj;
	    }
	    file_put_contents("items.json", json_encode($records));
	    mysqli_close($link);
	}

	function readJsonItem($attr) { // Read from Json File
	    $records = json_decode(file_get_contents("items.json"), true);
	    if (isset($records[0][$attr])) {
	    	return $records[0][$attr];
	    }else{
	    	return null;
	    }
	}

	function emptyJsonItem() { // Clears the Json File
	    $records = array();
	    file_put_contents("items.json", json_encode($records));
	}
/***********LIVEBID.JSON FUNCTIONS*************/

	function exportToJsonLiveBid($bidValue, $bidUserId, $bidUserName, $i_id) { // Copy data from database into Json File. not db but livbid module
	    //$records = array();
	    $records = json_decode(file_get_contents('livebid.json'), true);

	    if (count($records) > 2) {
	    	$newRecord = array( $records[0], $records[1]);
	    	$records = $newRecord;
	    }

	    array_unshift($records, array('bidValue' => $bidValue, 'bidUserId' => $bidUserId, 'bidUserName' => $bidUserName));

	    file_put_contents("livebid.json", json_encode($records));
	}
	
	function readJsonLiveBid($id, $attr){ //read the data from livebid.json where $id is index
		$records = json_decode(file_get_contents("livebid.json"), true);

		if (isset($records[$id][$attr])) {
    		return $records[$id][$attr];
    	}else{
    		return null;
    	}
	}
	function emptyJsonLiveBid() { // Clears the Json File
	    $records = array();
	    file_put_contents("livebid.json", json_encode($records));
	}
/***********QUIZ.JSON FUNCTIONS*************/

	function exportToJsonQuiz(){
		include('database.php');
		$curtime = date("Y-m-d H:i:s");
		$query = "SELECT `q_id`, `q_question`, `q_op1`, `q_op2`, `q_op3`, `q_op4`, `q_ans`, `q_starttime`, `q_endtime` FROM `quiz` WHERE (`q_starttime` <= '$curtime') AND (`q_endtime` > '$curtime') LIMIT 2";
    	$res = mysqli_query($link , $query);
    	$records = array();
    	
	    $i = -1;
	    while($obj = mysqli_fetch_object($res)){
	    	$i++;
	    	$records [$i]= $obj;
	    }

	    file_put_contents("quiz.json", json_encode($records));
	    mysqli_close($link);
	}

	function readJsonQuiz($id, $attr) { // Read from Json File
	    $records = json_decode(file_get_contents("quiz.json"), true);
	    if (isset($records[$id][$attr])) {
	    	return $records[$id][$attr];
	    }else{
	    	return null;
	    }
	}

	function emptyJsonQuiz(){
		$records = array();
	    file_put_contents("quiz.json", json_encode($records));
	}
?>