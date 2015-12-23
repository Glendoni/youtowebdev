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
var company_pipeline = $("input[name=company_pipeline]").val();

if ((this.value == '16' || this.value == '8') && (!source_check)) 
      {
$(".no-source").slideDown(600);
//$(".no-source").show();
//$(".disable_no_source").attr('disabled', 'disabled');
}
else
{
$(".no-source").slideUp(600);
//$(".no-source").hide();
//$(".disable_no_source").removeAttr('disabled', 'disabled');
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
//$(".disable_no_source").attr('disabled', 'disabled');
}
else
{
$(".no-source-pipeline").slideUp(600);
//$(".disable_no_source").removeAttr('disabled', 'disabled');
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

$( document ).ready(function() {
var source_explanation = $("input[name=source_explanation]").val();
var company_source = $("select[name=company_source]").val();
if (company_source=='8') {
$(".show_si_box").slideDown(600);
}
});
 

$(document).ready(function () {
    size_li = $("#campaignList a").size();
    x=15;
    $('#campaignList a:lt('+x+')').css('display', 'block');
    $('#loadMore').click(function () {
x= (x+5 <= size_li) ? x+20 : size_li;
$('#campaignList a:lt('+x+')').css('display', 'block');
    });
    
    
    ////////////////THE HOLY GRAIL
    
    var d = new Date();
d.setMonth(d.getMonth()+12);   //change retruned months here
      var   montheval =""+d.getMonth()+"" ;
      montheval =  montheval.substr(1, 1) ? d.getMonth() : '0'+d.getMonth() ;
      
      monthevalconcat = d.getFullYear()+"-"+(montheval)+"-01";
      
//console.log(monthevalconcat);
      
      
 
      ////////////////////THE HOLY GRAIL END
      $(' <option value=0>Please select</option>').appendTo('#mounthdue'); 

var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getUTCDate();
var year = dateObj.getUTCFullYear();

//newdate = year + "-" + month + "-" + day;
      newdate = year + "-" + month + "-01";
      
var start = new Date(newdate); //yyyy-mm-dd
var end = new Date(monthevalconcat); //yyyy-mm-dd
var mon =['January','Feburary','March','April','May','June','July','Auguast','September','October','November','December' ];
while(start <= end){

    var mm = ((start.getMonth()+1)>=10)?(start.getMonth()+1):'0'+(start.getMonth()+1);
    var dd = ((start.getDate())>=10)? (start.getDate()) : '0' + (start.getDate());
    var yyyy = start.getFullYear();
    var date = yyyy +"-"+mm+"-"+dd; //yyyy-mm-dd
if(dd == 01){
   
    
    //console.log(mon[(mm-1)]); 
    
    $(' <option value="'+date+'">' +mon[(mm-1)]+'</option>').appendTo('#mounthdue'); 
        
    
}
    start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
}
    
    
});
$(window).load(function(){
  $(".draggable-modal").draggable({
      handle: ".modal-header"
  });
});
