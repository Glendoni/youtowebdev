<div class="col-md-3">
<?php include("includes/large-search-box.php"); ?><!-- /col-3 -->
<hr>
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
<ul class="list-unstyled savedlists">';
while($mysavedlistrow = pg_fetch_array($mysavedlistresult)) {
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
while($mysharedlistrow = pg_fetch_array($mysharedlistresult)) {
echo '<li><a href="'.$mysharedlistrow['criteria'].'">'.$mysharedlistrow['name'].'</a></li>';}
echo '</ul></div>
</div>';}?>

<?php 
$myassignedsql = "SELECT B.name, B.id FROM business B where assigned = '".$user_id."' order by name asc";
$myassignedresult=pg_query($con,$myassignedsql);
$myassignedcount=pg_num_rows($myassignedresult);
if($myassignedcount=="0"){
echo'';
}
else {
echo '
<div class="panel panel-default">
<div class="panel-heading"><h4>Assigned To You</h4></div>
<div class="panel-body">
<ul class="list-unstyled">';
while($myassignedrow = pg_fetch_array($myassignedresult)) {
echo '<li><a href="search-results.php?businessid='.$myassignedrow['id'].'">'.$myassignedrow['name'].'</a></li>';}echo '</ul>

<a class="btn btn-danger btn-sm btn-block sidebutton" href="search-results.php?list=1">View List</a>


</div>
</div>';}?>
		
            
          
  	</div>