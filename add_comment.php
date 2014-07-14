<?php
// code will run if request through ajax
include('includes/connection.php');


// preventing sql injection
$comment=$_POST['comment'];
$comment=pg_escape_string($comment);
$business_id=$_POST['business_id']; 
$business_id=pg_escape_string($business_id);
$user_id=$_POST['user_id']; 
$user_id=pg_escape_string($user_id);
$sql = "INSERT INTO comments_business
      (user_id, comment, business_id)
      VALUES('".$user_id."','".$comment."','".$business_id."')";
	  	pg_query($con,$sql);
?>

    				<div class="message-item">
						<div class="message-inner">
							<div class="message-head clearfix">
								<div class="user-detail">
									<h5 class="handle">You</h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data">Just Now</span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="qa-message-content">
<?php echo $comment; ?>							</div>
					</div>
                    </div><!--END MESSAGE CONTENT-->
                    
                  
<?php pg_close($con);
?>
