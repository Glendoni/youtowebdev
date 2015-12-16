
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog small-modal">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Company</h4>
                </div>
            
                <div class="modal-body">
                   
                    <p>Are you sure you want to add this company?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default confirm_delete_cancel btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-8">
                    <a class="btn btn-warning btn-ok btn-block confirm_ch_add btn-warning">Add</a>
                    </div>
                  </div>
            </div>
        </div>
    </div>
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
 <script src="<?php echo asset_url();?>js/bootbox.js"></script>

<!--AUTO COMPLETE-->


<style>

    .toLowerCase{ text-transform:capitalize;}
</style>

<script type="text/javascript">
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
        
        //alert();
     
// return success
// console.log(data.html);
$('#suggestions').show();
$('#autoSuggestionsList').addClass('auto_list');
$('#autoSuggestionsList').html(data.html);
$('#agency_name').addClass('autocomplete-live');
        
        
          if (data.callCH ===true) { 
          // alert('I worked');
          
         getCompany(input_data);
              
              
              
       }
    }
});
    }
}
   
    
    

    
function  getCompany(input_data){
    // 08245800

     $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>companies/getCompanyHouseDetails/"+input_data,
            //data: post_data,
            success: function(data) {
             var obj =   $.parseJSON(data);
                
            var i = 0;
            var text = "";
                var preview = [];
            var out = [];
                
                
 
            while ( obj.items[i]) {

                if(obj.items[i].company_status == 'active' ){
             out += '<a href="javascript:;" company_number="'+obj.items[i].company_number+'" title="'+obj.items[i].title+'" postal_code="'+obj.items[i].address.postal_code+'" address_line_1="'+obj.items[i].address.address_line_1+'" locality="'+obj.items[i].address.locality+'" snippet="'+obj.items[i].snippet+'" company_type="'+obj.items[i].company_type+'" company_status="'+obj.items[i].company_status+'" description="'+obj.items[i].description+'" date_of_creation="'+obj.items[i].date_of_creation+'" class="companyHouseRegNum"><li class="autocomplete-item autocomplete-company toLowerCase ch_drop_title"><strong>' + ucwords(obj.items[i].title) + '</strong><br><small>Add to Baselist</small></li></a>';  
                     
                
                preview += '<a target="_blank" href="https://beta.companieshouse.gov.uk/company/'+obj.items[i].company_number+'"><li class="autocomplete-item autocomplete-contact preview_slogan" > View at Companies House   <i class="fa fa-external-link"></i><br><small>&nbsp;</small></li></a>'; 
                }
                
                


               i++;

                if (i === 7) { break; }


            }    
                
                
                            

 
                

                            $('#suggestions').show();
            $('#autoSuggestionsList').addClass('auto_list');
            $('#autoSuggestionsList').html('<div class="autocomplete-full-holder"><div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 clearfix no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading"><i class="fa fa-caret-square-o-down"></i> Companies</li>'+out+'</ul></div><div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading autocomplete-no-results"><i class="fa fa-times"></i> Preview</li>'+preview+'</ul></div></div>');
            $('#agency_name').addClass('autocomplete-live');
                             saveCompanyHandler();
            }
            });
    
    
    
   
    
   
    
    
}
    
    //$('#confirm-delete .modal-footer button').hide()

    
    
    
    
    
    
    
    
    
    //   $('#confirm-delete').modal('show');
    
 
   
    function saveCompanyHandler(){
        $('.ch_drop_title').css('background','#7fe3d5');
        $('.ch_drop_title').css('color' ,'#2d2d2d');
        $('.ch_drop_title strong').css('font-weight' ,'300'); 

        $('.companyHouseRegNum').click(function(){

            
           var mode =  "create";
                var user_id  =  <?php echo $current_user['id']; ?> ; 

 
                var data = {
                "registration": $(this).attr('company_number'),
                "date_of_creation": $(this).attr('date_of_creation'),
                "name": $(this).attr('title'),
                "postal_code": $(this).attr('postal_code'),
                "address": $(this).attr('snippet'),
                "user_id" : user_id,
                "company_status": $(this).attr('company_status'),
                "address_line_1": $(this).attr('address_line_1'),
                "company_type": $(this).attr('company_type'),
                "description": $(this).attr('description'),
                "date_of_creation": $(this).attr('date_of_creation'),
                };
            
            bootbox.confirm("Are you sure want to add this company?", function(result) {
             

                if(result){


               
                data = $.param(data);

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url(); ?>companies/getCompany",
                        data: data,
                        success: function (data) {

                        if(data.status == 200){
                            // alert('redirect');
                            //var milliseconds = 2000;
                            //if ((new Date().getTime() - start) > milliseconds){
                            window.location.href = "<?php echo base_url(); ?>companies/company?id="+data.message;
                            } 
                        }
                    });


                }else{


                }                


            })

        }); 
    }; 

    
    function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
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
    btn.addClass('btn-primary').removeClass('btn-success').text('Save');
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

<script type="text/javascript" src="<?php echo asset_url();?>js/custom.js"></script>



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
<!--COMBINE MULTIPLE JS FILES-->
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