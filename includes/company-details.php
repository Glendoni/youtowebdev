<?php
$business_id = $_GET['id'];
if((($_GET['updatetags'] ==="1") || ($_GET['updaterectypes'] ==="1")) && (!empty($business_id))) {
$deletesectors = "update sectors S set S.search = 0, S.user = '".$user_id."' where S.businessid = '".$business_id."'";
mysqli_query($con,$deletesectors);


//UPDATE EMPLOYEES//
if(($_GET['employees'] > "-1")) {
$addemployees = "insert into employee_count ( businessid, count) VALUES ('".$business_id."','".$_GET['employees']."')";
mysqli_query($con,$addemployees);
}
else {}



foreach($_GET["sector"] as $sectortoupdate) {
 $updatesectors = "insert into sectors (businessid, sector, user) VALUES 
('".$business_id."','".$sectortoupdate."','".$user_id."');";
mysqli_query($con,$updatesectors);
}
if (!empty($_GET['contract'])) {
$updatecontract = "1";
}
else {
$updatecontract = "NULL";
}
if (!empty($_GET['perm'])) {
$updateperm = "1";
}
else {
$updateperm = "NULL";
}
if (!empty($_GET['website'])) { 
$safe_url = mysqli_real_escape_string($con, $_GET['website']);
}
else {
$safe_url = "NULL";
}
if (!empty($_GET['linkedinid'])) {
$updatelinkedinid = mysqli_real_escape_string($con, $_GET['linkedinid']);
}
else {
$updatelinkedinid = "NULL";
}
$updaterectype = "update business set contract = '".$updatecontract."', perm = '".$updateperm."', web = '".$safe_url."', linkedinid='".$updatelinkedinid."' where id = '".$business_id."'";
mysqli_query($con,$updaterectype);
}

// This first query is just to get the total count of rows
$sql = "SELECT business.name, DATE_FORMAT(founded,'%d/%m/%Y') AS founded,  business.linkedinid as businesslinkedinid, business.id, web from business where active = '1' and business.id = '$business_id' ";
$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
{
$business_name = $row['name'];
$business_location = $row['location'];
$business_founded = $row['founded'];
$business_web = $row['web'];
$business_linkedin = $row['businesslinkedinid'];
$showturnover = mysqli_query($con,"SELECT turnover, type from turnover where businessid = '".$business_id."'  order by added desc limit 1");
$showturnoverrow_cnt = mysqli_num_rows($showturnover);
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
}//END OF IF STATEMENT
$employeecount = mysqli_query($con,"SELECT count
FROM employee_count where businessid = '".$business_id."' order by date desc limit 1");
$row_cnt = mysqli_num_rows($employeecount);
if ($row_cnt ==0) 
{
$business_employees = '
 <div class="form-group">
    <input type="text" class="form-control" name="employees" style="text-align:center" id="employees" placeholder="Add Number">
  </div>
';
}
else
{
while($row = mysqli_fetch_array($employeecount))
{
$business_employees = "<span class=\"label label-info\">".$row['count']."</span>";
}
}//END OF IF STATEMENT
}
//START LI COUNT
$liconnectionsql = "
SELECT COUNT(C.li_id) AS count FROM connections C LEFT JOIN contacts ct 
ON C.li_id=ct.id 
WHERE ct.companyid = '$business_id'
";
$liconnectionresult=mysqli_query($con,$liconnectionsql);

while($liconnectionrow = mysqli_fetch_array($liconnectionresult)) {
 $liconnections = "<span class='label label-info' >".$liconnectionrow['count']."</span>";
}



$list .='
<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="get" id="update-tags">

<div class="panel panel-default">

  <div class="panel-body row">
<div class="col-md-12">
<h3 class="name"><a href="company.php?id='.
$business_id.'">'.$business_name.'</a></h3><small>'.$row['address'].' </small>
</div>
<div class="col-md-9">
<div class="col-md-4 centre detailsholder"><small>Turnover</small>
<h3 class="details"><strong>'.$business_turnover.' </strong><br>
<small>'.$business_turnover_type.'</small></h3>
<small>Founded</small>
<h5 class="details"><strong>'.$business_founded.$business_founded2.' </strong></h5>
</div>
<div class="col-md-4 centre detailsholder"><small>Employees</small>
<h3 class="details">'.$business_employees.' </h3>
<small>LinkedIn Connections</small>
<h3 class="details"><strong>'.$liconnections.' </strong></h3>

</div>
<div class="col-md-4 centre detailsholder"><small>Sectors</small>';
$sectorsql = "SELECT S.sector, SL.sector_name FROM sectors S INNER JOIN sector_list SL on S.sector =  SL.sector_id where businessid = '".$business_id."' AND S.search=1";
$sectorresult = mysqli_query($con,$sectorsql);
 $stored = array();
while($sectorrow = mysqli_fetch_array($sectorresult, MYSQLI_ASSOC))

{
	$list.=' <h5>'.$sectorrow['sector_name'].'</h5>';
  $stored[] = $sectorrow['sector'];
}
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
$updaterequestresult=mysqli_query($con,$updaterequestsql);
$updaterequestcount=mysqli_num_rows($updaterequestresult);
if($updaterequestcount=="0"){
	$list .='<a href="includes/update-request.php?id='.$business_id.'&user='.$user_id.'" class="btn btn-warning btn-sm update sidebutton" target="_blank">Request Update</a>';}

else {
	$list .='<a class="btn btn-sm btn-warning sidebutton" disabled="disabled">Update Requested</a>';
}

if (empty($business_web) || ($business_web==="NULL")) {$business_web_placeholder="Add Website";$business_web="";
	
	} else {$business_web_placeholder="Add Website"; $business_web=$business_web;};
	
	if (empty($business_linkedin) || ($business_linkedin==="NULL")) {$business_linkedin_placeholder="Add Linkedin ID";$business_linkedin="";
	
	} else {$business_linkedin_placeholder="Add Linkedin ID"; $business_linkedin=$business_linkedin;};


$list .='
</div>
</div>
<div class="col-md-12">
<hr>
<div class="col-md-6">
<div class="form-group">
<label for="web">Website</label>
<input type="text" class="form-control" name="website" id="website" value="'.$business_web.'" placeholder="'.$business_web_placeholder.'">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="web">LinkedIn ID</label>
<input type="text" class="form-control" name="linkedinid" id="linkedinid" value="'.$business_linkedin.'" placeholder="'.$business_linkedin_placeholder.'">
</div>
</div>
</div>';
}
?>
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
<?php echo $list; ?>