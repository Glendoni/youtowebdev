<?php
$sectorlistsql = "SELECT * from sector_list order by sector_name asc";
$sectorlistresult=pg_query($con,$sectorlistsql);
while($sectorlistrow = pg_fetch_array($sectorlistresult)) {
if (in_array($sectorlistrow['sector_id'], $stored)){
$sectorselected ='checked';
} else
{$sectorselected ='';}


 $sector .='
<span class="button-checkbox" id="'.$sectorlistrow['sector_id'].'">
        <button type="button" class="btn" data-color="primary"  id="'.$sectorlistrow['sector_id'].'">'.$sectorlistrow['sector_name'].'</button>
         <input type="checkbox" name="sector[]" value="'.$sectorlistrow['sector_id'].'" id="'.$sectorlistrow['sector_id'].'" class="hidden" '.$sectorselected.' >
    </span>
';}
		
		



		

	
?>
<input type="hidden" name="updatetags" value="1">

<div class="tag-holder">
  <?php echo $sector;?>
</div>
<input type="submit" class="btn btn-success btn-lg btn-block" value="Update" style="margin-top:10px;">
<script>
$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
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
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
</script>
