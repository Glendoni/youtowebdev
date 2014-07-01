<div class="panel panel-default">
<div class="panel-heading"><h4>Search</h4>
<?php
if ($search == "1") {
echo "<small>
<a href='search-results.php' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> Clear Search</a></small>";
}
else {};
?>
</div>
<div class="panel-body">
<form action="search-results.php" method="get">
<input type="hidden" name="search" value="1">
<div class="row">
<div class="col-md-12">
<div class='form-group'>
<label for="user_title">Agency Name</label>
<input class="form-control" id="agency_name" name="agency_name" size="30" type="text" value="<?php echo $_GET['agency_name']; ?>" />
<p id="empty-message"></p>

</div><!--END FORM GROUP-->
</div><!--END MD12-->

</div><!--END ROW-->
<div class="row">
<div class="col-md-12">
<label>Turnover</label>
</div>
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon">From</span>
<input class="form-control number" id="turnover_from" name="turnover_from" size="30" type="text" placeholder="0" value="<?php echo $_GET['turnover_from']; ?>" />
</div><!--END INPUT GROUP-->
</div><!--MD-12-->
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon" style="min-width: 58px;">To</span>
<input class="form-control number" id="turnover_to" name="turnover_to" size="30" type="text" placeholder="100,000,000" value="<?php echo $_GET['turnover_to']; ?>" />
</div><!--END INPUT GROUP-->
</div><!--MD-12-->
</div><!--ROW-->

<div class="row">
<div class="col-md-12">
<label>Employees</label>
</div>
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon">From</span>
<input class="form-control number" id="employees_from" name="employees_from" size="30" type="text" placeholder="0" value="<?php echo $_GET['employees_from']; ?>" />
</div><!--END INPUT GROUP-->
</div><!--MD-12-->
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon" style="min-width: 58px;">To</span>
<input class="form-control number" id="employees_to" name="employees_to" size="30" type="text" placeholder="1000" value="<?php echo $_GET['employees_to']; ?>" />
</div><!--END INPUT GROUP-->
</div><!--MD-12-->
</div><!--ROW-->

<div class="row">
<div class="col-md-12">
<label>Company Age</label>
</div>
<div class="col-md-12" style="padding-bottom: 10px;">

<div class="input-group">
  <span class="input-group-addon">From</span>
<input class="form-control number" id="company_age_from" name="company_age_from" maxlength="3" size="10" type="text" placeholder="0" value="<?php echo $_GET['company_age_from']; ?>" />
  <span class="input-group-addon">Years</span>

</div><!--END INPUT GROUP-->
</div><!--MD-12-->
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon" style="min-width: 58px;">To</span>
<input class="form-control number" id="company_age_to" name="company_age_to" size="30" type="text" placeholder="100" value="<?php echo $_GET['company_age_to']; ?>" />
  <span class="input-group-addon">Years</span>

</div><!--END INPUT GROUP-->
</div><!--MD-12-->
</div><!--ROW-->

<div class="row">
<div class="form-group">
<div class='col-sm-12'>
<strong>Sector</strong>
</div>
<div class='col-sm-12' style="padding-bottom:10px;">
<select class="form-control" name="sector[]" multiple size="7">
<option 
<?php if(empty($_GET["sector"]) || in_array('All', $_GET["sector"])) {
	echo "selected";};?>>All</option>
<?php
// This first query is just to get the total count of rows
$sql = "select sector_name, sector_id from sector_list where sector_in_search_list = '1' order by sector_name asc";
$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
{
$sector_tag_name = $row['sector_name'];
$sector_tag_id = $row['sector_id'];

if(in_array($sector_tag_id, $_GET["sector"])) {
    // $sector is selected

$selected = "selected='selected'"; 
echo "<option value='".$sector_tag_id."' ".$selected.">".$sector_tag_name."</option>";
}
else 
{
echo "<option value='".$sector_tag_id."'>".$sector_tag_name."</option>";
}
}
}
?>
</select>
<label>Current Provider</label>
<select class="form-control" name="provider">
<option selected>All</option>
<?php
// This first query is just to get the total count of rows
$sql = "select Distinct provider from mortgages where search = 1 AND status = 'Outstanding' order by provider asc";
$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
{
$provider_tag_name = $row['provider'];
if ($provider_tag_name=== $_GET['provider']) {
$selected = "selected='selected'"; 
echo "<option value='".$provider_tag_name."' ".$selected.">".$provider_tag_name."</option>";
}
else 
{
echo "<option value='".$provider_tag_name."'>".$provider_tag_name."</option>";
}
}
}
?>
</select>
<div class="row">
<div class="col-md-12">
<label>Anniversary Range</label>
</div>
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon">From</span>
<input class="form-control number" id="mortgage_end_from" name="mortgage_end_from" maxlength="3" size="10" type="text" placeholder="30" value="<?php echo $_GET['mortgage_end_from']; ?>" />
  <span class="input-group-addon">Days</span>

</div><!--END INPUT GROUP-->
</div><!--MD-12-->
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="input-group">
  <span class="input-group-addon" style="min-width: 58px;">To</span>
<input class="form-control number" id="mortgage_end_to" name="mortgage_end_to" maxlength="3" size="10" type="text" placeholder="90" value="<?php echo $_GET['mortgage_end_to']; ?>" />
  <span class="input-group-addon">Days</span>

</div><!--END INPUT GROUP-->
</div><!--MD-12-->
</div>
<input type="submit" class="btn btn-success btn-lg btn-block" value="Search" style="margin-top:10px;">
<?php
if ($search == "1") {
echo "<hr>
<a data-toggle='modal' href='#myModal' class='btn btn-primary btn-lg btn-block'>Save Search</a>";
}
else {};
?></div>
</div><!--ROW-->
</div>
</form>


</div>
</div>