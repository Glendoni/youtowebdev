function dateRequired()     {
    var contact_type = document.getElementById("action_type_planned").value;
    if (contact_type > '0'){
$(".follow-up-date").attr('required', true)
    }     
else{
$(".follow-up-date").attr('required', false)
    }
    }
    
$(window).load(function(){
window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
$(this).remove(); 
    });
}, 5000);

});//]]> 
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
$(".pipeline-validation-check").change(function() {
var company_source = $("select[name=company_source]").val();
var company_pipeline = $("select[name=company_pipeline]").val();
var pipeline_check = $("input[name=pipeline_check]").val();
var company_class = $("select[name=company_class]").val();
if ((this.value !== 'Prospect' && this.value !== 'Lost' && this.value !== 'Unsuitable') && (!company_source || company_source==0||company_class=='Unknown')) 
{
$(".no-source-pipeline").slideDown(600);
$(".disable_no_source").attr('disabled', 'disabled');
}
else
{
$(".no-source-pipeline").slideUp(600);
$(".disable_no_source").removeAttr('disabled', 'disabled');
}
});

$(".pipeline-validation-check").change(function() {
var company_source = $("select[name=company_source]").val();
if (company_source=='8') 
      {
$(".show_si_box").slideDown(600);
$(".source_explanation").prop('required',true);
//$(".disable_no_si").attr('disabled', 'disabled');
}
      else
      {
$(".show_si_box").slideUp(600);
$(".source_explanation").prop('required',false);
//$(".disable_no_si").removeAttr('disabled', 'disabled');
}
});
//$(".source_explanation").keyup(function() {
//var si_check = $("input[name=source_explanation]").val();
//var company_source = $("select[name=company_source]").val();
//if ((!si_check || si_check==0||si_check=='') && company_source=='8') {
//$(".disable_no_si").attr('disabled', 'disabled');
//}
//else
//{
//$(".disable_no_si").removeAttr('disabled', 'disabled');
//}
//});
jQuery(window).on("load", function(){

$(".pipeline-validation-check").change();
$(".source_explanation").keyup();

});
$(document).ready(function () {
    size_li = $("#campaignList a").size();
    x=15;
    $('#campaignList a:lt('+x+')').css('display', 'block');
    $('#loadMore').click(function () {
x= (x+5 <= size_li) ? x+20 : size_li;
$('#campaignList a:lt('+x+')').css('display', 'block');
    });
});
$(window).load(function(){
  $(".draggable-modal").draggable({
      handle: ".modal-header"
  });
});
