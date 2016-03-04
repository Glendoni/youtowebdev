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
});
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


function getDealAvg(){
    
       var avg;
var sum =0;
var val = 0;
var count_lines  = $('.us-initial-rate').length;
    //loop thru totals
$('.us-initial-rate').each(function(){
    if(parseInt($(this).text())){
      val = parseInt($(this).text()) + val;
    }else{
      count_lines -1;
    }
});
val = val/count_lines;
//console.log(parseFloat( val.toFixed(3) ));
    
    avg = val ? 'Avg '+ parseFloat( val.toFixed(3) )+'%' : 'Avg 0%';
   $('.us-initial-rate-total').text(avg);
}

$( document ).ready(function() {
    

    getDealAvg(); //Get Deal Average used for user stats
 
    if($('.mainAddrType').length > 1) $('.copyRegAddr').remove(); // Removes add copy address check button if more than 1 address exist 
//counts the totals in team stats columns
var mycolumnArray = ["tw","lw","tm","lm"];
var mycolumnArrayLength = mycolumnArray.length;
var myStringArray = ["deals","proposals","demobookedcount","democount","meetingbooked","meetingcount","salescall","introcall","pipelinecount","key_review_added","key_review_occuring","duediligence"];
var arrayLength = myStringArray.length;

var total; 
var list;
for (var s = 0; s < mycolumnArrayLength; s++) {
for (var i = 0; i < arrayLength; i++) {
list = 	getlisttotal(myStringArray[i], mycolumnArray[s]);
};
};
////////End stats counter//////////////////////
var autopilotEmailCompany = window.location.href.split("id="); 

if((/dashboard/.test(window.location.href))) {
$.ajax({
type: "GET",
dataType: "json",
url: "Marketing/loaddata",
success: function(data) {
var action;
var items = [];
var idfk;
$.each( data, function( key, val ) {
idfk = val.company_id;
if(val.action == "4"){ action =  'Un-subscribed'; }else if(val.action == "2"){ action =  'Clicked'; }else{action  = 'Opened';}  
if( typeof idfk !== 'undefined'){              
items.push( '<div class="row record-holder"><div class="col-xs-8 col-sm-4 col-md-3"><a href="companies/company?id='+idfk+'">'+val.company+'</a></div><div class="col-xs-8 col-sm-4 col-md-2">'+val.campaign+'</div><div class="col-xs-4 col-sm-1 col-md-1 text-right"><span class="label pipeline label-Prospect">'+val.pipeline+'</span></div><div class="col-xs-6 col-sm-2 col-md-2"><a href="companies/company?id='+idfk+'#contacts">'+val.username+'</a></div><div class="col-xs-6 col-sm-3 col-md-2 align-right "> <span class="label label-primary">'+action+'</span></div><div class="col-xs-12 col-sm-2 col-md-2 contact-phone">'+val.date+'</div></div>' );
} 
}); 
$('#stat').html(items.join( "" ));
$('.eventcount').html(items.length); //update engagement counter
}

});
    
    
    
}
if(autopilotEmailCompany[1]){ 
var myParam = window.location.href.split("id=");
var action ;
$.ajax({
type: "GET",
dataType: "json",
url: "../Marketing/autopilotActions/"+myParam[1],
success: function(data) {
var action;
var items = [];
var idfks;
var  i = 0 
$.each( data, function( key, val ) {              
switch (val.action) {
case '1':
action  = '<span class="label label-success">Opened</span>'; 
break;
case '4':    
action  = '<span class="label label-success">Unsubscribed</span>'; 
break;
case '2':
action =  '<span class="label label-success">Clicked</span>';
break;
}
if( val.campaign !== null ){
if(val.action != '3'){
i++;
$( '<li class="list-group-item"><div class="row"><div class="col-xs-6 col-md-7"><h4 style="margin:0;">'+val.campaign_name+'<div class="mic-info">'+val.date+ ' by '+val.email+
'</div></h4></div><!--END COL-MD-4--><div class="col-xs-6 col-md-5" style="text-align:right;"><span class="label label-primary" style="font-size:11px;  ">'+val.first_name+ ' '+ val.last_name+
'</span> '+action+' </div></div></li>' ).prependTo('#marketing ul');
}
}
});
$('.marketingAcitonCtn').text(parseInt($('.marketingAcitonCtn').text()) + i);
$(items.join( "" )).prependTo('#marketing ul');
if(i) $('#outstanding h4,.actionMsg h4').hide();
}
});
}
var source_explanation = $("input[name=source_explanation]").val();
var company_source = $("select[name=company_source]").val();
if (company_source=='8') {
$(".show_si_box").slideDown(600);
}
$('#action_type_completed').on('change',function(){

if($('#action_type_completed').val() == 16 ){
$('.onInitialFee').addClass('col-md-2');
$('.initialfee').show();
$('.initialfee input').attr('required', 'required');
}else{
$('.onInitialFee').removeClass('col-md-2');

$('.initialfee input').val('').removeAttr('required');
$('.initialfee').hide();
}

})
});
//////////////Controls pipline pick date
var d = new Date();
var n = d.getMonth();
d.setMonth(d.getMonth()+(11-n));   //change retruned months here
var   montheval =""+d.getMonth()+"" ;
montheval =  montheval.substr(1, 1) ? d.getMonth() : '0'+d.getMonth() ;
monthevalconcat = d.getFullYear()+"-"+(montheval)+"-01";
////////////////////THE HOLY GRAIL END///////////
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
$(' <option value="'+date+'">' +mon[(mm-1)]+'</option>').appendTo('#mounthdue');    
}
start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
}
$(window).load(function(){
$(".draggable-modal").draggable({
handle: ".modal-header"
});
});
/*$(document).ready(function () {
size_li = $("#campaignList a").size();
x=15;
$('#campaignList a:lt('+x+')').css('display', 'block');
$('#loadMore').click(function () {
x= (x+5 <= size_li) ? x+20 : size_li;
$('#campaignList a:lt('+x+')').css('display', 'block');
});
});*/
$(window).load(function(){
$(".draggable-modal").draggable({
handle: ".modal-header"
});
});
function getlisttotal(col,item){
//used to count team stat column totals
var lm = 0;
$('.'+item+'-'+col).each(function(){
lm  = (lm+parseInt($(this).text()));
});
$('.'+item+'-'+col+'-total').text(lm);
return lm;
}
$('.tradingType').on('change', function() {
var trAddress =  $(this).val(); 
if(trAddress === "Registered Address"){ $('.tradingTypeOptions').show(); } else{ $('.tradingTypeOptions, .addrTrading').hide(); $(".def").prop("checked", true); $('.tradingAddress').val('');   }
}); 
$('.tradingArr').on('change', function() {
var trAddress =  $(this).val(); 
if(trAddress == 2){ $('.addrTrading').show();  $('#tradingAddress').attr('Required', 'Required')  } else{ $('.addrTrading').hide(); $('#tradingAddress').val(''); $('#tradingAddress').removeAttr('Required', 'Required')   }
});
if($('.popUpAddress').val() && $('.mainAddrType').text() != 'Trading Address'){$('.copyRegAddr').hide() }
$('#copymainaddr').click(function(){
if($(this).prop("checked")){ $('.popUpAddress').val($('.mainAddress').text()) }else{ $('.popUpAddress').val('') }
})

