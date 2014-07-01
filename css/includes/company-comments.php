
<script type="text/javascript" >
$(document).ready(function(){
var form = $('form');
var submit = $('#submit');
form.on('submit', function(e) {
var comment = $("#comment").val();
var business_id = $("#business_id").val(); 
var user_id = $("#user_id").val(); 
var dataString = 'comment=' + comment+ '&business_id=' + business_id+ '&user_id=' + user_id;
$("#flash").show();
$("#flash").fadeIn(400).html('<img src="ajax-loader.gif" />Loading Comment...');
$.ajax({
type: "POST",
url: "add_comment.php",
data: dataString,
cache: false,
success: function(html){
$(".qa-message-list").prepend(html);
$("ol#update li:last").fadeIn("slow");
$("#flash").hide();
}
});
return false;
}); });
</script>
<div class="panel panel-default">
<div class="panel-heading"><h4>Comments</h4></div>
<div class="panel-body">
<div class="col-md-12">
<div id="flash"></div>
<form action="#" method="post">
<input type="hidden" id="user_id" value="<?php echo $user_id; ?>"/> 
<input type="hidden" id="business_id" value="<?php echo $business_id; ?>"/> 
<textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Type your comment here...." required style="width:100%"></textarea>
<input type="submit" id="submit" class="btn btn-success" value="Comment" style="margin:10px 0 20px 0;">
</form>
<div class="qa-message-list" id="wallmessages">
<?php
//$post_id value comes from the POSTS table
$sql=pg_query($con,"SELECT CB.id AS comment_id,CB.user_id, CB.comment, CB.date, U.user_name FROM comments_business AS CB, users AS U 
WHERE CB.user_id = U.user_id AND CB.business_id = 03901185 order by CB.date desc");
while($row=mysqli_fetch_array($sql))
{
$name=$row['user_name'];
$comment=$row['comment'];
$comment_id=$row['comment_id'];
$comment_timestamp=$row['date'];
?>
    				<div class="message-item" id="<?php echo $comment_id; ?>">
						<div class="message-inner">
							<div class="message-head clearfix">
								<div class="user-detail">
									<h5 class="handle"><?php echo $name; ?></h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data"><?php echo $comment_timestamp; ?></span>
											</span>
										</div>
									</div>
								</div>
							</div>
<div class="qa-message-content">
<?php echo $comment; ?>
</div>
</div>
</div><!--END MESSAGE CONTENT-->
<?php
}
?>
</div>
</div>
</div>
</div>