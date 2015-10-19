       </div>


    <!-- /#wrapper -->
    <!-- jQuery Version 1.11.0 -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript"  src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?php echo asset_url();?>js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript"  src="<?php echo asset_url();?>js/sb-admin-2.js"></script>


    <script type="text/javascript" src="<?php echo asset_url();?>js/ladda.min.js"></script>


    <script type="text/javascript"  src="<?php echo asset_url();?>js/pace.min.js"></script>     
    <!-- DATE TIME PICKER -->
    <!--<script type="text/javascript" src="https://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>-->
    <script type="text/javascript" src="<?php echo asset_url();?>js/moment.js"></script>

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
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker();

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
                    //icon: 'glyphicon glyphicon-check'
                },
                off: {
                    //icon: 'glyphicon glyphicon-unchecked'
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
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
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
                    textbtn.text('Watched by '+name ); 
                }else{
                    textbtn.text('No Longer Watching');
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
<!--ENABLE DATE SELECT VALIDATION ON ACTION-->
    <script>
                function dateRequired()     {
                    var contact_type = document.getElementById("action_type_planned").value;
                    if (contact_type > '0'){
                        $(".follow-up-date").attr('required', true)
                                            }     
                        else{
                        $(".follow-up-date").attr('required', false)
                            }        
                            }
                </script>


    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $(".include-exclude-drop").change(function(){
                                                $( ".include-exclude-drop option:selected").each(function(){
                                                    if($(this).val()=="exclude"){
                                                        $(".contacted-show").show();
                                                    }
                                                    if($(this).val()=="include"){
                                                        $(".contacted-show").hide();
                                                    }
                                                });
                                            });
                                        });
                                    </script>
 <?php if(ENVIRONMENT !== 'production'): ?>
    <div class="alert alert-warning" role="alert">
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
    </div> <?php endif; ?>
     <?php if((ENVIRONMENT == 'production') && ($current_user['id'] != '1') && ($current_user['id'] != '6')): ?>

 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64636609-1', 'auto');
  ga('send', 'pageview');

</script>
<?php endif; ?>
<script type="text/javascript">
$('.toggle').click(function (event) {
    event.preventDefault();
    var target = $(this).attr('href');
    $(target).toggleClass('hidden show');
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
  $(window).bind('scroll', function() {
    var navHeight = 300; // custom nav height
    ($(window).scrollTop() > navHeight) ? $('nav').addClass('goToTop') : $('nav').removeClass('goToTop');
  });
});
</script>
<!--MAKE MODALS WITH DRAGGABLE-MODAL CLASS DRAGGABLE-->
<script type="text/javascript">
$(window).load(function(){
  $(".draggable-modal").draggable({
      handle: ".modal-header"
  });
});

</script>
<!--AUTO DISMISS SUCCESS ALERTS-->
<script type="text/javascript">//<![CDATA[
$(window).load(function(){
window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);

});//]]> 

</script>

<!--MAKE ACTION DROP DOWN DISPLAY ALERT IF NO SOURCE IS SET-->
<script type="text/javascript">
$('#action_type_completed').change(function(){
var source_check = $("input[name=source_check]").val();
if ((this.value == '16' || this.value == '8') && (!source_check)) 
      {
        $(".no-source").slideDown(600);
        //$(".no-source").show();
        $(".disable_no_source").attr('disabled', 'disabled');
}
      else
      {
        $(".no-source").slideUp(600);
        //$(".no-source").hide();
        $(".disable_no_source").removeAttr('disabled', 'disabled');
}
});
</script>
<!--PIPELINE VALIDATION-->
<script type="text/javascript">
$(".pipeline-validation-check").change(function() {
var company_source = $("select[name=company_source]").val();
var company_pipeline = $("select[name=company_pipeline]").val();
var pipeline_check = $("input[name=pipeline_check]").val();
var company_class = $("select[name=company_class]").val();
if ((this.value !== 'Prospect' && this.value !== 'Lost') && (!company_source || company_source==0||company_class=='Unknown')) 
      {
        $(".no-source-pipeline").slideDown(600);
        //$(".no-source").show();
        $(".disable_no_source").attr('disabled', 'disabled');
}
      else
      {
        $(".no-source-pipeline").slideUp(600);
        //$(".no-source").hide();
        $(".disable_no_source").removeAttr('disabled', 'disabled');
}
});

$(".pipeline-validation-check").change(function() {
var company_source = $("select[name=company_source]").val();
if (company_source=='8') 
      {
        $(".show_si_box").slideDown(600);
        $(".source_explanation").prop('required',true);
        $(".disable_no_si").attr('disabled', 'disabled');

}
      else
      {
        $(".show_si_box").slideUp(600);
        $(".source_explanation").prop('required',false);
        $(".disable_no_si").removeAttr('disabled', 'disabled');
}
});
$(".source_explanation").keyup(function() {
var si_check = $("input[name=source_explanation]").val();
var company_source = $("select[name=company_source]").val();
if ((!si_check || si_check==0||si_check=='') && company_source=='8') {
$(".disable_no_si").attr('disabled', 'disabled');
}
else
{
$(".disable_no_si").removeAttr('disabled', 'disabled');
}
});
jQuery(window).on("load", function(){

$(".pipeline-validation-check").change();
$(".source_explanation").keyup();

});

</script>
<script type="text/javascript">
$(document).ready(function () {
    size_li = $("#campaignList a").size();
    x=15;
    $('#campaignList a:lt('+x+')').css('display', 'block');
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+20 : size_li;
        $('#campaignList a:lt('+x+')').css('display', 'block');
    });
});
</script>
  <hr>
  <?php if (isset($current_user)): ?>

        <div class="col-lg-12">
            <ul class="nav nav-pills nav-justified">
                <li>© <?php echo date("Y");?> Sonovate</li>
            </ul>
        </div>
        <?php endif; ?>
</body>

</html>