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

<!--AUTO COMPLETE-->

<script type="text/javascript">
        // // VALIDATION FOR CONTACT FORM
        // function validateContactForm(){
        //     alert('sds');
        //     return false;
        //     var url =  form.attr('action');
            
        //     $.ajax({
        //             type: "POST",
        //             url: url,
        //             data: form.serialize(),
        //             success: function(data) {
        //                 // return success
        //                 console.log(data.html);
        //                 alert('sd');
        //             }
        //         });
        //     return false;

        // }

        // AJAX SEARCH AUTOCOMPlETE
        function ajaxSearch() {
            var input_data = $('#agency_name').val();
            if (input_data.length < 1) {
                $('#suggestions').hide();
                $('#agency_name').removeClass('autocomplete-live');
            } else {

                var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>companies/autocomplete/",
                    data: post_data,
                    success: function(data) {
                        // return success
                        // console.log(data.html);
                        $('#suggestions').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data.html);
                        $('#agency_name').addClass('autocomplete-live');
                    }
                });

            }
        }

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
    // VALIDATION FOR CONTACT FORM 
	$('.submit_btn').click(function(e){
		
		var btn = $(this);
		var form = btn.closest('form');
		var url = form.attr('action');

        var loading_display_id = btn.attr('loading-display');
        var loading_display = $('#'+loading_display_id);
        loading_display.attr('style','display:block;');

	 	e.preventDefault();
        btn.button('loading');
	 	$.post(url, form.serialize(),
	 	  function(response){
	 	    btn.removeClass('btn-primary').addClass('btn-success').text('Saving...');
	 	  })
        .fail(function(response) {
            var error = jQuery.parseJSON(response.responseText)
            console.log(error['error']);
            form.find('#error_box').html(error['error']);
            form.find('#error_box').show();
            btn.addClass('btn-primary').removeClass('btn-success').text('Save changes');
            btn.button('reset');
        })
        .success(function(){
            location.reload(true); 
        })
	 	.always(function() {  
            
        });

	 	return true;
	});

    // reset button on load 
    $('.loading-btn').button('reset');

    // Click function  
    $('.loading-btn').click(function () {
    var btn = $(this)
    btn.button('loading')
    });

    // Email pop up form 
    $('.template_selector').change(function() {
        form = $(this).closest("form");
        form.find(".info_box").hide();
        form.find(".template_"+$(this).val()).show();
    });


 	});
        // Email pop up form 
        // function validate_form_email(form){
        //     if(form.)
        //     return false;
        // }

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