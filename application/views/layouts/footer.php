	    	</div>
	        <!-- /#page-wrapper -->
		</div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo asset_url();?>/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    
 	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 	<script src="http://cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>

 	<!-- Custom Theme JavaScript -->
    <script src="<?php echo asset_url();?>/js/sb-admin-2.js"></script>


    <script src="<?php echo asset_url();?>/js/ladda.min.js"></script>

    <!-- <script src="<?php echo asset_url();?>/js/pace.min.js"></script> -->
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

 	<script type="text/javascript">
 	$( document ).ready(function() {
 		
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
		 	.always(function() { textbtn.text('Assigned to '+name );  l.stop(); btn.attr('disabled','disabled'); });

		 	return false;
		});

        

		$('.submit_btn').click(function(e){
			
			var btn = $(this);
			var form = btn.closest('form');
			var url = form.attr('action');
            var edi_btn_id = btn.attr('edit-btn');
            var edit_btn = $('#'+edi_btn_id);
            edit_btn.button('loading');

		 	e.preventDefault();
            btn.button('loading');
		 	$.post(url, form.serialize(),
		 	  function(response){
		 	    
		 	  })
		 	.always(function() {  
                btn.removeClass('btn-primary').addClass('btn-success').text('Saved'); 

                setTimeout(function () {
                   btn.siblings().trigger('click');
                   btn.button('reset');
                   edit_btn.removeClass('disabled').removeAttr('disabled');
                   btn.removeClass('btn-success').addClass('btn-primary');
                   window.location.href = window.location.href + "?refreshed";
                }, 1000);
            });

		 	return false;
		});

        
          $('.loading-btn').click(function () {
            var btn = $(this)
            btn.button('loading')
            // $.ajax(...).always(function () {
            //   btn.button('reset')
            // });
          });

          // Setup form validation on the #register-form element
            $( "#main_search" ).submit(function( event ) {        
                if( $( "#main_search input:blank" ).length < 9 ){
                    return true;
                }else{
                    event.preventDefault();
                    $('#empty_form_error').show();
                    $('.loading-btn').button('reset');
                    return false;
                }
            });


 	});

// { ["main_search"]=> string(1) "1" ["agency_name"]=> string(0) "" ["turnover_from"]=> string(0) "" ["turnover_to"]=> string(0) "" ["employees_from"]=> string(0) "" ["employees_to"]=> string(0) "" ["company_age_from"]=> string(0) "" ["company_age_to"]=> string(0) "" ["sectors"]=> array(1) { [0]=> string(1) "0" } ["providers"]=> string(1) "0" ["mortgage_from"]=> string(0) "" ["mortgage_to"]=> string(0) "" ["submit"]=> string(10) "loading..." } 

 	</script>
 <?php if(ENVIRONMENT == 'development'): ?>
 	<div class="alert alert-warning" role="alert">
 	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
 	</div>
 <?php endif; ?>
</body>

</html>