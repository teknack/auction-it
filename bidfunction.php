<?php 
	session_start();
	if (!isset($_SESSION['tek_userid'])||empty($_SESSION['tek_userid'])) {
		echo "<script language='javascript'> window.top.location.assign('http://www.teknack.in'); </script>"; 
	}
	$curtime = date("Y-m-d H:i:s");
	$itemPresent = false;

	include('json_func.php');
	include('database.php');

	if (readJsonItem('i_id') == null) {

		//Do something here if the result is absent. no item to sell

	}else{
		$itemPresent = true;
		$i_id = readJsonItem('i_id');
		$i_increment = readJsonItem('i_increment');
		$i_endtime = readJsonItem('i_endtime');
		$i_baseprice =readJsonItem('i_baseprice');
		
		$i_bidvalue = readJsonLiveBid(0, 'bidValue');
		if ($i_bidvalue == null) {
			$i_bidvalue = 0;
		}
		$i_biduser_id = readJsonLiveBid(0, 'bidUserId');
		$i_biduser_name = readJsonLiveBid(0, 'bidUserName');

		if (is_null($i_biduser_id)) {
			$curBidValue1 = $i_baseprice;
			$curBidValue2 = $i_baseprice + $i_increment;
			$curBidValue3 = $i_baseprice + ($i_increment * 2);
			$curBidValue4 = $i_baseprice + ($i_increment * 3);
		}else{
			$curBidValue1 = $i_bidvalue + $i_increment;
			$curBidValue2 = $i_bidvalue + ($i_increment * 2);
			$curBidValue3 = $i_bidvalue + ($i_increment * 3);
			$curBidValue4 = $i_bidvalue + ($i_increment * 4);			
		}//End of else someone has already bid
	}//End of else result is present
?>
<div class="main-bid-panel" id="bidfunctioninfo">
    <div class = "bid-function">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Place your bid here....</h3>
            </div>
            <div class="panel-body" id="bidfnc">
            	<?php 
            		if($itemPresent) {
            			if ($i_biduser_id==$_SESSION['tek_userid']) { ?>
							<h3>You have the highest bid.</h3><br/>
						<?php }else{ ?>
							<?php if ($_SESSION['auc_user_cash'] >= $curBidValue1) { ?>
				            	<div class ="bid_form" id="bidform">
				            		<form method="POST" action="update.php" role="form">
				            			<div class="radio">
				  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue1;?>">&nbsp;&#36;<?php echo $curBidValue1;?></label>
										</div>
										<?php if ($_SESSION['auc_user_cash'] >= $curBidValue2) { ?>
											<div class="radio">
					  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue2;?>">&nbsp;&#36;<?php echo $curBidValue2;?></label>
											</div>
										<?php }else{ ?>
											<div class="radio disabled">
					  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue2;?>">&nbsp;&#36;<?php echo $curBidValue2;?></label>
											</div>
										<?php } ?>
										<?php if ($_SESSION['auc_user_cash'] >= $curBidValue3) { ?>
											<div class="radio">
					  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue3;?>">&nbsp;&#36;<?php echo $curBidValue3;?></label>
											</div>
										<?php }else{ ?>
											<div class="radio disabled">
					  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue3;?>">&nbsp;&#36;<?php echo $curBidValue3;?></label>
											</div>
										<?php } ?>
										<?php if ($_SESSION['auc_user_cash'] >= $curBidValue3) { ?>
											<div class="radio">
					  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue4;?>">&nbsp;&#36;<?php echo $curBidValue4;?></label>
											</div>
										<?php }else{ ?>
											<div class="radio disabled">
					  							<label><input type="radio" name="bidValue" value="<?php echo $curBidValue4;?>">&nbsp;&#36;<?php echo $curBidValue4;?></label>
											</div>
										<?php } ?>
										<button type="submit" id="bidsubmit" class="btn btn-default">Submit</button>
				            		</form>
				            	</div>
            				<?php }else{ ?>
								<h2 class="text-info">Insuffecient Funds...</h2>
							<?php } ?>
						<?php } ?>
					<?php } else { ?>
						<!--Do something if item is not present-->
					<?php } ?>
            </div>
    	</div>
    </div>
    <div class = "live-bid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Live Bid...</h3>
            </div>
            <div class="panel-body">
                <?php
					if ($itemPresent) {
						if (readJsonLiveBid(0, 'bidUserId') != null) {
							$str_i_bidvalue = number_format(readJsonLiveBid(0, 'bidValue'), 2, ".", ",");
							echo "<h4>1. ".readJsonLiveBid(0, 'bidUserName')."<br> bid <span>&#36;$str_i_bidvalue</span></h4>";
							if (readJsonLiveBid(1, 'bidValue') != null) {
								$str_i_bidvalue2 = number_format(readJsonLiveBid(1, 'bidValue'), 2, ".", ",");
								echo "<h4>2. ".readJsonLiveBid(1, 'bidUserName')."<br>  bid <span>&#36;$str_i_bidvalue2</span></h4>";
							}
							if (readJsonLiveBid(2, 'bidValue') != null) {
								$str_i_bidvalue3 = number_format(readJsonLiveBid(2, 'bidValue'), 2, ".", ",");
								echo "<h4>3. ".readJsonLiveBid(2, 'bidUserName')."<br>  bid <span>&#36;$str_i_bidvalue3</span></h4>";
							}
						}else{
							echo "<h4 class='text'>No Bid yet... Be the first to bid.</h4>";
						}
					}
				?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#bidsubmit").click(function(e) {
    	e.preventDefault();
       	var formdata = $("form").serialize();
       	$.ajax({
    		url: "update.php",
    		type: "POST",
    		data: formdata,
    		success: function(data){
        		$('#bidfnc').load('update.php');
    		}
		});
    });
</script>