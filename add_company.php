<?php include("includes/header.php"); ?>
<body>
<!--GET NAV-->
<?php include("includes/nav.php"); ?>
<!-- Main -->
<div class="container">
<div class="row">
<?php include("includes/left-menu.php"); ?><!-- /col-3 -->
<div class="col-md-9">
<a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a><hr>
<div class="row">
<div class="col-md-12">
</div></div>
<div class="row">
<div class="col-md-12">

<div class="panel panel-default">
<div class="panel-heading"><h4>Add Company</h4>
<?php
if ($search == "1") {
echo "<small>
<a href='search-results.php' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> Clear Search</a></small>";
}
else {};
?>
</div>
<div class="panel-body">
<form action="" method="get">
<div class="row">
<div class="col-md-12">
<div class='form-group'>
<label for="user_title">Agency Name</label>
<input class="form-control" id="agency_name" name="agency_name" size="30" type="text" required/>
</div><!--END FORM GROUP-->
</div><!--END MD12-->
</div><!--END ROW-->
<div class="row">
<div class="col-md-12">
<label>Turnover</label>
</div>
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="form-group">
<input class="form-control" id="turnover" name="turnover" size="30" type="text" placeholder="0"/>
</div><!--END INPUT GROUP-->
</div><!--MD-12-->
</div><!--ROW-->

<div class="row">
<div class="col-md-12">
<label>Employees</label>
</div>
<div class="col-md-12" style="padding-bottom: 10px;">
<div class="form-group">
<input class="form-control" id="employees" name="employees" size="30" type="text" placeholder="0"/>
</div><!--END INPUT GROUP-->
</div><!--MD-12-->
</div><!--ROW-->

<div class="row">
<div class="col-md-12">Registered Date</div>
<div class="col-md-12" style="padding-bottom: 10px;">

<div class="form-group">
<input type="date" class="form-control">
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
<?php
// This first query is just to get the total count of rows
$sql = "select Distinct sector from sectors order by sector desc";
$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
{
$sector_tag_name = $row['sector'];

if(in_array($sector_tag_name, $_GET["sector"])) {
    // $sector is selected

$selected = "selected='selected'"; 
echo "<option value='".$sector_tag_name."' ".$selected.">".$sector_tag_name."</option>";
}
else 
{
echo "<option value='".$sector_tag_name."'>".$sector_tag_name."</option>";
}
}
}
?>
</select>
<label>Current Provider</label>
<select class="form-control" name="provider">
<option selected>None</option>
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

</div>
</div>
<div class="row">
<div class="col-md-12">
<?php include("includes/relationship-tags.php"); ?>
</div>
</div>
<div class="row">
<div class="col-md-12">
<?php include("includes/products.php"); ?>
</div>
</div>
<div class="row">
<div class="col-md-12">
<?php include("includes/company-comments.php"); ?>
</div>
</div>
<!--DON'T DELETE ANYTHING BELOW HERE-->
</div><!--/col-span-9-->
</div><!-- /Row -->
</div><!-- /Container -->
<?php include("includes/footer.php"); ?>
<script type="text/javascript" >

$(function () {
    $('.list-group.checked-list-box .list-group-item').each(function () {
        
        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" />'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };
            
        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });
          

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color + ' active');
            } else {
                $widget.removeClass(style + color + ' active');
            }
        }

        // Initialization
        function init() {
            
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplay();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
            }
        }
        init();
    });
    
    $('#get-checked-data').on('click', function(event) {
        event.preventDefault(); 
        var checkedItems = {}, counter = 0;
        $("#check-list-box li.active").each(function(idx, li) {
            checkedItems[counter] = $(li).text();
            counter++;
        });
        $('#display-json').html(JSON.stringify(checkedItems, null, '\t'));
    });
});
</script>