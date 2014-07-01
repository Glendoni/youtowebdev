<?php
$action = $_GET['action'];$deleteid = $_GET['deleteid'];
if(($action ==="delete_assigned")) {
$deleteassigned = "update business B set B.assigned = null where B.id = '".$deleteid."' AND B.assigned = '".$user_id."'";
pg_query($con,$deleteassigned);
echo '<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> Company Unassigned</div>';}

?>
<?php
$sql = "SELECT B.name, DATE_FORMAT(B.founded,'%d/%m/%Y') AS founded, B.address, ".$employeecount." ".$turnoverselect." U.shortened, B.base, B.assigned, B.linkedinid as businesslinkedinid, B.id,  B.web
FROM business B
LEFT JOIN users U
ON B.assigned=U.id
".$turnoverjoin."
".$sectorjoin."
".$employeejoin."
".$providerjoin."
where B.active = '1' ".$savedlistsql." ".$listsearchsql." ".$businessidsql." ".$mortgage_endsql." ".$agencyname." ".$turnoversql." ".$employeessql." ".$providersql." ".$company_agesql." ".$sectorsql." ".$searchorder."";
$query = pg_query($con, $sql);
$row = pg_fetch_row($query);
// Here we have the total row count
 $rows =  pg_num_rows($query);
// This is the number of results we want displayed per page
$page_rows = 30;
// This tells us the page number of our last page
$last = ceil($rows/$page_rows);
// This makes sure $last cannot be less than 1
if($last < 1){
$last = 1;
}
// Establish the $pagenum variable
$pagenum = 1;
// Get pagenum from URL vars if it is present, else it is = 1
if(isset($_GET['pn'])){
$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}
// This makes sure the page number isn't below 1, or more than our $last page
if ($pagenum < 1) { 
$pagenum = 1; 
} else if ($pagenum > $last) { 
$pagenum = $last; 
}
// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
// This is your query again, it is for grabbing just one page worth of rows by applying $limit
$sql = $sql." ".$limit;

$query = pg_query($con, $sql);
// This shows the user what page they are on, and the total number of pages
$textline1 = "Companies (<b>".number_format($rows)."</b>)";
$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
// Establish the $paginationCtrls variable
$paginationCtrls = '';
// If there is more than 1 page worth of results
if($last != 1){
/* First we check if we are on page one. If we are then we don't need a link to 
the previous page or the first page so we do nothing. If we aren't then we
generate links to the first page, and to the previous page. */
if ($pagenum > 5) {
$previous = $pagenum - 5;
$paginationCtrls .= '<li><a href="http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'&pn='.$previous.'">&laquo;</a></li>';
// Render clickable number links that should appear on the left of the target page number
for($i = $pagenum-4; $i < $pagenum; $i++){
if($i > 0){
$paginationCtrls .= '<li><a href="http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'&pn='.$i.'">'.$i.'</a></li>';
}
}
}
if ($pagenum <= 5) {
$previous = $pagenum - 5;
$paginationCtrls .= '<li class="disabled"><a href="#">&laquo;</a></li>';
// Render clickable number links that should appear on the left of the target page number
for($i = $pagenum-5; $i < $pagenum; $i++){
if($i > 0){
$paginationCtrls .= '<li><a href="http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'&pn='.$i.'">'.$i.'</a></li>';
}
}
}
// Render the target page number, but without it being a link
$paginationCtrls .= ' <li class="active"><span>'.$pagenum.'</span></li>';
// Render clickable number links that should appear on the right of the target page number
for($i = $pagenum+1; $i <= $last; $i++){
$paginationCtrls .= '<li><a href="http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'&pn='.$i.'">'.$i.'</a></li>';
if($i >= $pagenum+5){
break;
}
}
// This does the same as above, only checking if we are on the last page, and then generating the "Next"
$pagenum2 = $pagenum + 6;
if ($pagenum2 <= $last) {
$next = $pagenum + 6;
$paginationCtrls .= '<li><a href="http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'&pn='.$next.'">&raquo;</a></li>';
    }
if ($pagenum2 > $last) {
$paginationCtrls .= '<li class="disabled"><span>&raquo;</span></li>';
    }
}
$list = '';
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
{
$business_id = $row["id"];
$business_name = $row['name'];
$business_founded = $row['founded'];
$business_linkedin = $row['linkedinid'];

//GET ASSIGNED NAME
$assignedid = $row['assigned'];
$shortened = $row['shortened'];
if (empty($assignedid)) {
$shorteneddisplay = "";
$shortenedcircle = '
<div class="col-md-12">

<h3 class="name">
<a href="company.php?id='.$business_id.'">
'.$business_name.'
</a>
</h3>
<small>'.$row['address'].' </small>
</div>
';
}
else
{
$shorteneddisplay = "<span class=\"label label-success\" style='margin-left:10px;'>".$shortened."</span>";
$shortenedcircle = '
<div class="col-md-12"> 
<div class="col-md-2 row">
<div class="benefits-circle-text"><div class="benefits-circle-inner"><p>Assigned to</p><h2>'.$shortened.'</h2></div></div>
</div>
<div class="col-md-10">

<h3 class="name">
<a href="company.php?id='.$business_id.'">
'.$business_name.'
</a>
</h3>
<small>'.$row['address'].' </small>
</div>
</div>
';

}
//END GET ASSIGNED NAME
//GET WEBSITE NAME
$webaddress = $row['web'];
//END GET WEB
//ON BASE
$onbase = $row['base'];
if ($onbase=='0') {
	$onbasedisplay="";
}
else
{
	$onbasedisplay= "style='border-left: green 2px solid;'";
	}

//END ON BASE
$business_employees = "<span class=\"label label-warning\">Unknown</span>";
$showturnoverselect = "SELECT turnover from turnover where businessid = '".$business_id."' order by added desc limit 1";
$showturnover = pg_query($con,"SELECT turnover, type from turnover where businessid = '".$business_id."'  order by added desc limit 1");
$showturnoverrow_cnt = pg_num_rows($showturnover);
if ($showturnoverrow_cnt ==0) 
{
$business_turnover = "£0";
$business_turnover_type = "";
}
else {
while($showturnoverrow = mysqli_fetch_array($showturnover)){
$business_turnover = "£".number_format($showturnoverrow['turnover']);
$business_turnover_type = $showturnoverrow['type'];

}
}
$business_location = $row['location'];
$business_linkedin = $row['businesslinkedinid'];
$employeecountsql = "SELECT count
FROM employee_count where businessid = '".$business_id."' order by date desc limit 1";
$employeecount = pg_query($con,$employeecountsql);
$row_cnt = pg_num_rows($employeecount);
if ($row_cnt ==0) 
{
$business_employees = "<span class=\"label label-warning\">Unknown</span>";
}
else
{
while($row = mysqli_fetch_array($employeecount))
{
$business_employees = "<span class='label label-info' >".$row['count']."</span>";
}
}//END OF IF STATEMENT

//START LI COUNT
$liconnectionsql = "
SELECT COUNT(C.li_id) AS count FROM connections C LEFT JOIN contacts ct 
ON C.li_id=ct.id 
WHERE ct.companyid = '$business_linkedin'
";
$liconnectionresult=pg_query($con,$liconnectionsql);

while($liconnectionrow = mysqli_fetch_array($liconnectionresult)) {
 $liconnections = "<span class='label label-info' >".$liconnectionrow['count']."</span>";
}


}
$list .='<div class="panel panel-default">
  <div class="panel-body row">
<div class="col-md-12">
'.$shortenedcircle.'
</div>
<div class="col-md-9">
<div class="col-md-4 centre detailsholder"><small>Turnover</small>
<h3 class="details"><strong>'.$business_turnover.' </strong><br>
<small>'.$business_turnover_type.'</small></h3>
<small>Founded</small>
<h5 class="details"><strong>'.$business_founded.' </strong></h5>
</div>
<div class="col-md-4 centre detailsholder"><small>Employees</small>
<h3 class="details"><strong>'.$business_employees.' </strong></h3>
<small>LinkedIn Connections</small>
<h3 class="details"><strong>'.$liconnections.' </strong></h3>

</div>
<div class="col-md-4 centre detailsholder"><small>Sectors</small>';
$sectorsql = "SELECT S.sector, SL.sector_name FROM sectors S INNER JOIN sector_list SL on S.sector =  SL.sector_id where businessid = '".$business_id."' and S.search = 1";
$sectorresult = pg_query($con,$sectorsql);
while($sectorrow = mysqli_fetch_array($sectorresult))
{  $list.=' <h5>'.$sectorrow['sector_name'].'</h5>';}
 $list .='
</div>
</div>
<div class="col-md-3">
<div class="btn-group-vertical pull-right">
<a class="btn btn-danger btn-sm sidebutton" href="https://www.duedil.com/company/'.$business_id.'" target="_blank">View on Duedil</a>';

if (($business_linkedin == '') || ($business_linkedin == 'null')) {
$list .='';}
else {
$list .='<a href="https://www.linkedin.com/company/'.$business_linkedin.'" class="btn linkedinbtn btn-sm base sidebutton" target="_blank">View on LinkedIn</a>';}
//Add Web Button
if (($webaddress == '') || ($webaddress == 'null')) {
$list .='';}
else {
$list .='
<a href="'.$webaddress.'" class="btn btn-default btn-sm sidebutton" target="_blank">Visit Website</a>';
}
//ADD ASSIGNED CODE//
//CAN ONLY DELETE ON LIST VIEW//
$list .='
</div>
<div class="btn-group-vertical pull-right" style="margin-top:15px">';
if (($assignedid == '0') || ($assignedid == 'null')  || ($assignedid == '')) {
$list .='<a href="includes/saveData.php?business_id='.$business_id.'&user_id='.$user_id.'" class="btn btn-primary btn-sm assign sidebutton" target="_blank">Assign</a>';}
else if (($assignedid === $user_id ) && ($listsearch == '1')) {
$list .='<a href="search-results.php?list='.$user_id.'&deleteid='.$business_id.'&action=delete_assigned" class="btn btn-warning btn-sm assign sidebutton" "><span class="glyphicon glyphicon-remove"></span> Remove</a>';

$action = $_GET['action'];
$deleteid = $_GET['deleteid'];

}
else {
$list .='<a class="btn btn-sm btn-primary sidebutton" disabled="disabled">Assigned to '.$shortened.'</a>';
}
$list .='<input type="hidden" name="assign_user_id" value="'.$user_id.'">
<input type="hidden" name="assign_business_id" value="'.$row['id'].'">';
if (($onbase == '0') || ($onbase == 'null')) {
$list .='<a href="includes/base-add.php?id='.$business_id.'" class="btn btn-success btn-sm base sidebutton" target="_blank">Add to Base</a>';}
else {
$list .='<a class="btn btn-sm btn-success sidebutton" disabled="disabled">Already on Base</a>';
}
$updaterequestsql = "SELECT business_id from update_requests where business_id = '".$business_id."' AND status = 0";
$updaterequestresult=pg_query($con,$updaterequestsql);
$updaterequestcount=pg_num_rows($updaterequestresult);
if($updaterequestcount=="0"){
	$list .='<a href="includes/update-request.php?id='.$business_id.'&user='.$user_id.'" class="btn btn-warning btn-sm update sidebutton" target="_blank">Request Update</a>';}

else {
	$list .='<a class="btn btn-sm btn-warning sidebutton" disabled="disabled">Update Requested</a>';
}
$list .='
</div>
</div>
<div class="col-md-12">';
$mortgagelistsql = "SELECT distinct M.provider, M.businessid,M.mortgage_id,M.status,  
DATE_FORMAT(M.start,'%d/%m/%Y') AS startdate
FROM mortgages M where businessid = '".$business_id."' AND search = 1 order by status ASC, startdate desc
";
$mortgagelistresult=pg_query($con,$mortgagelistsql);
$mortgagelistcount=pg_num_rows($mortgagelistresult);
if($mortgagelistcount=="0"){
$list .='
<div class="alert alert-warning alert-dismissable">
No Mortgage Data Registered</div>';}
else {
$list .='<table class="table table-hover">
      <thead>
        <tr>
          <th class="col-md-7">Provider</th>
          <th class="col-md-3">Status</th>
          <th class="col-md-2">Start Date</th>
        </tr>
      </thead>
      <tbody>';

while($mortgagelistrow = mysqli_fetch_array($mortgagelistresult)) {
if ($mortgagelistrow['status']==="Satisfied"){
$mtrclass = "danger";}
else {
	$mtrclass = "";
}
 $list .='

        <tr class="'.$mtrclass.'">
          <td class="col-md-7">'.$mortgagelistrow['provider'].'</td>
          <td class="col-md-3">'.$mortgagelistrow['status'].'</td>
          <td class="col-md-2">'.$mortgagelistrow['startdate'].'</td>
        </tr>';}
		
		
$list.='</tbody>
    </table>';
	
	}
$sectorresult = pg_query($con,$sectorsql);
{  $list.=' <h5>'.$sectorrow['sector'].'</h5>';}
 $list .='



</div>
</div>

</div>';
}
// Close your database connection
pg_close($con);
?>
<h2><?php echo $textline1; ?></h2>
<?php if ($rows===0) {
	echo '<div class="alert alert-warning">No companies found</div>';
}
else {
	echo '<p>'.$textline2.'</p>';
}
	?><?php echo $list; ?>
</div>
<div style="text-align:center;">
<ul class="pagination"><?php echo $paginationCtrls; ?></ul>
</div>

<!--/tabs-->
 <script>
$( ".assign" ).click(function() {
  $( this ).replaceWith( "<a class='btn btn-primary btn-sm assign' disabled='disabled'>Assigned</a>" );
});
$( ".base" ).click(function() {
  $( this ).replaceWith( "<a class='btn btn-success btn-sm assign' disabled='disabled'>Added to Base</a>" );
});
$( ".update" ).click(function() {
  $( this ).replaceWith( "<a class='btn btn-warning btn-sm assign' disabled='disabled'>Update Requested</a>" );
});
</script>

<!--SAVE MODAL-->
<div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                            <div class="modal-header">
                    <a class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></a>
                    <h4 class="modal-title" id="myModalLabel">Save Search</h4>
                </div>
                <div class="modal-body">
<?php $actual_link = "$_SERVER[REQUEST_URI]";?>
<input id="createdby" type="hidden" value="<?php echo $user_id;?>" />
<div class="form-group">
<label for="user_title">List Name</label>
<input class="form-control" id="searchname" name="searchname" size="30" type="text" value="">
</div>
<input id="criteria" type="hidden" value="<?php echo $actual_link;?>" />
<div class="form-group">
<label for="user_title">Share list with others?</label>
<select class="form-control" id="sharelist">
<option selected value="0">No</option>
<option value="1">Yes</option>
</select>
</div>
<script type="text/javascript">
$(document).ready(function(){
//Get the input data using the post method when Push into mysql is clicked .. we pull it using the id fields of ID, Name and Email respectively...
$("#insert").click(function(){
var boxval = $("#searchname").val();
if(boxval=='')
{
alert("Your list needs a name...");
}
else {
//Get values of the input fields and store it into the variables.
var createdby=$("#createdby").val();
var name=$("#searchname").val();
var criteria=$("#criteria").val();
var sharelist=$("#sharelist").val();

$('#myModal').modal('hide');
$.post('includes/savedlistinsert.php', {createdby: createdby, name: name, criteria: criteria, sharelist: sharelist})
;

 return false;
}
});   
});
</script>
</div>
                <div class="modal-footer">
                    <div class="btn-group">
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <a id="insert" href="#close" title="Close" class="btn btn-primary">Save Search</a>

                </div>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
</div><!-- /.modal -->
