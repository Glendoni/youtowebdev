	    	</div>
	        <!-- /#page-wrapper -->
		</div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?php echo asset_url();?>js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript 
    <script type="text/javascript"  src="<?php echo asset_url();?>js/plugins/metisMenu/metisMenu.min.js"></script>-->

    <!-- Morris Charts JavaScript 
    
 	<script type="text/javascript"  src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 	<script type="text/javascript"  src="//cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>-->

 	<!-- Custom Theme JavaScript -->
    <script type="text/javascript"  src="<?php echo asset_url();?>js/sb-admin-2.js"></script>


    <script type="text/javascript" src="<?php echo asset_url();?>js/ladda.min.js"></script>


    <script type="text/javascript"  src="<?php echo asset_url();?>js/pace.min.js"></script> 

    <script type="text/javascript"  src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    
    <!-- DATE TIME PICKER -->
    <script type="text/javascript" src="https://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>

    <script type="text/javascript" src="<?php echo asset_url();?>js/bootstrap-datetimepicker.js"></script>

<!--FORMAT NUMBERS WITH COMMAS (ADD CLASS NUMBER TO INPUT)-->
    <script type="text/javascript" src="<?php echo asset_url();?>js/format-numbers.js"></script>


 	<script type="text/javascript">
 	$( document ).ready(function() {
 		// Datetime picker
        $('#planned_at').datetimepicker();
        $('#actioned_at').datetimepicker();
         

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

	$('.assign-to-form .ladda-button').click(function(e){
		var btn = $(this);
		var form = btn.closest('form');
		var url = form.attr('action');

		var textbtn = btn.find('span.ladda-label');
		var name = btn.attr('assignto');

	 	e.preventDefault();
	 	var l = Ladda.create(this);
	 	l.start();
	 	$.post(url, form.serialize(),
	 	  function(response){
	 	    
	 	  })
	 	.always(function() { 
            if(typeof name != 'undefined'){
                    textbtn.text('Assigned to '+name ); 
                }else{
                    textbtn.text('Unassigned');
                    form.closest('.panel').children('.panel-heading').hide();
                }  
            l.stop(); 
            btn.attr('disabled','disabled'); 
        });

	 	return false;
	});

        
    // reset button on page load
    $('.submit_btn').button('reset');

    // on click action 
	$('.submit_btn').click(function(e){
		
		var btn = $(this);
		var form = btn.closest('form');
		var url = form.attr('action');
        // var edi_btn_id = btn.attr('edit-btn');
        // var edit_btn = $('#'+edi_btn_id);
        // edit_btn.button('loading');
        var loading_display_id = btn.attr('loading-display');
        var loading_display = $('#'+loading_display_id);
        loading_display.attr('style','display:block;');

	 	e.preventDefault();
        btn.button('loading');
	 	$.post(url, form.serialize(),
	 	  function(response){
            // console.log(response);
	 	    btn.removeClass('btn-primary').addClass('btn-success').text('Saving...'); 
            location.reload(true);
	 	  })
	 	.always(function() {  
            
            // btn.button('loading');
            // setTimeout(function () {
            //    // btn.siblings().trigger('click');
            //    // btn.button('reset');
            //    edit_btn.removeClass('disabled').removeAttr('disabled');
            //    btn.removeClass('btn-success').addClass('btn-primary');
            //    // window.location.href = window.location.href + "?refreshed";
            //    location.reload(true);
            // }, 1000);
        });

	 	return true;
	});

    // reset button on load 
    $('.loading-btn').button('reset');

    // Click function  
    $('.loading-btn').click(function () {
    var btn = $(this)
    btn.button('loading')
    // $.ajax(...).always(function () {
    //   btn.button('reset')
    // });
    });

    // Setup form validation on the #register-form element
    // $( "#main_search" ).submit(function( event ) {        
    //     if( $( "#main_search input:blank" ).length < 9 ){
    //         return true;
    //     }else{
    //         event.preventDefault();
    //         $('#empty_form_error').show();
    //         $('.loading-btn').button('reset');
    //         return false;
    //     }
    // });


 	});

        function validateActionForm(form){
            $(form).siblings().hide();
            var outcome_box_id = $(form).attr('outcome-box');
            var outcome_box = $('#'+outcome_box_id);
            console.log(outcome_box.find('textarea').val());
            if(!outcome_box.find('textarea').val())
            {
                outcome_box.show('slow');
                outcome_box.children('textarea').focus();
                outcome_box.children('button').click(function() {
                    $(form).submit();
                });
                return false;
            }
            else
            {
                $(form).find('input[name="outcome"]').val(outcome_box.find('textarea').val());
                return true;
            }
            
            
        }

 	</script>
 <?php if(ENVIRONMENT !== 'production'): ?>
 	<div class="alert alert-warning" role="alert">
 	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
 	</div>
 <?php endif; ?>
</body>

</html>