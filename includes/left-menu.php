
<div class="col-md-3">

<?php 
 $mysavedlistsql = "SELECT * FROM savedlists where createdby = '".$user_id."' order by created desc";
$mysavedlistresult=pg_query($con,$mysavedlistsql);
$mysavedlistcount=pg_num_rows($mysavedlistresult);
if($mysavedlistcount=="0"){
echo '<div class="alert alert-warning">You have no saved lists</div>';

}
else {
echo '<div class="panel panel-default">
<div class="panel-heading"><h4>Your Saved Lists</h4></div>
<div class="panel-body">
<ul class="list-unstyled">';
while($mysavedlistrow = mysqli_fetch_array($mysavedlistresult)) {
echo '<li><a href="'.$mysavedlistrow['criteria'].'">'.$mysavedlistrow['name'].'</a></li>';}
echo '</ul></div>
</div>';}?>

<?php 
$mysharedlistsql = "SELECT * FROM savedlists where createdby <> '".$user_id."' AND shared = 1 order by created desc";
$mysharedlistresult=pg_query($con,$mysharedlistsql);
$mysharedlistcount=pg_num_rows($mysharedlistresult);
if($mysharedlistcount=="0"){
echo '
<div class="alert alert-info">No lists have been shared with you</div>';
}
else {
echo '
<div class="panel panel-default">
<div class="panel-heading"><h4>Lists Shared With You</h4></div>
<div class="panel-body">
<ul class="list-unstyled">';
while($mysharedlistrow = mysqli_fetch_array($mysharedlistresult)) {
echo '<li><a href="'.$mysharedlistrow['criteria'].'">'.$mysharedlistrow['name'].'</a></li>';}
echo '</ul></div>
</div>';}?>
		
          
  	</div>