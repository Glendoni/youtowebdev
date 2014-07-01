<div class="panel panel-default">
<div class="panel-heading"><h4>Search</h4></div>
<div class="panel-body">
<form action="search-results.php" method="get">
<input type="hidden" name="search" value="1">
<div class='row'>
<div class='col-sm-12'>    
<div class='form-group'>
<label for="user_title">Agency Name</label>
<input class="form-control" id="agency_name" name="agency_name" size="30" type="text" value="<?php echo $_GET['agency_name']; ?>" />
</div>
</div>
</div>
<hr>
<div class="row">
<div class="col-md-6 row" style="padding-bottom: 10px;">
<div class="col-sm-12" style="padding-bottom: 10px;">
<strong>Employees</strong>
</div>
<div class="col-lg-12" style="padding-bottom: 10px;">
<div class="col-md-6" style="padding-bottom: 10px; padding-left:0">
<input class="form-control" name="employee-from" placeholder="0" type="text" />
</div>
<div class="col-md-6" style="padding-bottom: 10px; padding-left:0;">
<input class="form-control" name="employee-to" placeholder="30,000" type="text" />
</div>
</div>
</div>

<div class="col-md-6" style="padding-bottom: 10px;">
<div class="col-sm-12" style="padding-bottom: 10px;">
<strong>Employees</strong>
</div>
<div class="col-lg-12" style="padding-bottom: 10px;">
<div class="col-md-6" style="padding-bottom: 10px; padding-left:0">
<input class="form-control" name="employee-from" placeholder="0" type="text" />
</div>
<div class="col-md-6" style="padding-bottom: 10px; padding-left:0">
<input class="form-control" name="employee-to" placeholder="30,000" type="text" />
</div>
</div>
</div>
</div>
                      



<div class='row'>
<div class='col-sm-6 row'>
<div class="form-group">
<div class='col-sm-12'>
<strong>Employees</strong>
</div>
<div class='col-sm-6'>
<input type="text" class="form-control" placeholder="0">
</div>
<div class='col-sm-6'>
<input type="text" class="form-control" placeholder="30,000">
<div class="map_canvas"></div>
</div>
</div>
</div>

<div class='col-sm-6'>
<div class="form-group">
<div class='col-sm-12'>
<strong>Turnover</strong>
</div>
<div class='col-sm-6'>
<input type="text" class="form-control" placeholder="£0">

</div>
<div class='col-sm-6'>
<input type="text" class="form-control" placeholder="£1,000,0000">

</div>
</div>
</div>

</div><!--END ROW-->
<hr>
<div class='row'>
<div class='col-sm-6 row'>
<div class="form-group">
<div class='col-sm-12'>
<strong>Location</strong>
</div>
<div class='col-sm-12'>
<input name="geo-box" style="margin-bottom:10px;" class="form-control" id="geocomplete" type="text" placeholder="Location" value="<?php echo $searchlocation; ?>">
<input name="lat" type="hidden" value="<?php echo $lat; ?>">
<input name="lng" type="hidden" value="<?php echo $lng; ?>">
</div>
<div class='col-sm-12'>
<select class="form-control">
  <option selected>All</option>

  <option>Head Office</option>
  <option>Branch</option>
  <option>Registered Address</option>
</select>
</div>
</div>
</div>

<div class='col-sm-6'>
<div class="form-group">
<div class='col-sm-12'>
<strong>Sector</strong> (Hold Ctrl to multi select)
</div>
<div class='col-sm-12'>
<select multiple class="form-control">
  <option selected>All</option>

<?php
$business_id = $_GET['id'];
// This first query is just to get the total count of rows
$sql = "select tag_name from tags where type = 'sector' and active = '1' order by tag_name ASC ";
$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
{
$sector_tag_name = $row['tag_name'];
echo "<option>".$sector_tag_name."</option>";
}
}
?>
</select>

</div>
</div>
</div>

</div><!--END ROW-->


<div class='row' style="margin-top:20px">
<div class='col-sm-12'>    
  <input type="submit" class="btn btn-primary btn-lg btn-block" value="Search">

<?php
if ($search == "1") {
	echo "
	<a data-toggle='modal' href='#myModal' class='btn btn-success btn-lg btn-block'>Save Search</a>";
}
else {};
?>

</div>
</div>
</form>
</div><!--/panel-body-->
</div><!--/panel-->

