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
<?php 
if($_GET['updatetags'] ==="1") {
echo "<div class='alert alert-success alert-dismissable'>
  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
  <strong>Record Updated</strong>
</div>";	
}
else {}
	
	?>
<?php include("includes/company-details.php"); ?>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading"><h4>Mortgages</h4></div>
<div class="panel-body">
<div class="col-md-12 row">
<?php include("includes/mortgages.php"); ?>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading"><h4>Recruitment Type</h4></div>
<div class="panel-body">
<div class="col-md-12 row">
<?php include("includes/recruitment-types.php"); ?>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading"><h4>Sectors</h4></div>
<div class="panel-body">
<div class="col-md-12 row">
<?php include("includes/sectors.php"); ?>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
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