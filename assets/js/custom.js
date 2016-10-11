function dateRequired()     {
    var contact_type = document.getElementById("action_type_planned").value;
    if (contact_type > '0'){
        $(".follow-up-date").attr('required', true)
    }     
    else{
        $(".follow-up-date").attr('required', false)
    }
}


  
$( document ).ready(function() {
      if((/contacts/.test(window.location.href))) {
            $("[data=contacts]").trigger('click')
    
      }
    //INVOICE FINANCE
$('.debmortgage').on('click', function(){
 
        event.preventDefault();
    var param = $('#debmortgage form').serialize();

 
    //JS JASON WITH POST PARAMETER
    
      $.ajax({
        type: "POST",
          data: param,
            dataType: "json",
        url: "../companies/notForInvoices",
        success: function(data) {
          $('#debmortgage').modal('toggle');
      
if(data.success){  
   // $('table .inv'+data.success).hide(); 

 $('table .cont'+data.success).removeClass('success'); 
     $('table .cont'+data.success).addClass('danger'); 
      
  if(data.debenturemortgage == 'P'){
                            $('.inv'+data.success).html('Probably Related To Invoice Finance');
                         $('table .cont'+data.success).removeClass('danger'); 
                         $('table .cont'+data.success).addClass('success'); 
      
       $('#morprov'+data.success).attr('providerstatus', 3)
      
  }
    
    if(data.debenturemortgage == 'N'){
       $('.inv'+data.success).html('Not Related To Invoice Finance');
       $('#morprov'+data.success).attr('providerstatus', 1)
      
  }
    
   
}
            
         if(data.debenturemortgage == 'Y'){   $('.inv'+data.success).show(); 
                        
                         $('table .cont'+data.success).removeClass('danger'); 
                         $('table .cont'+data.success).addClass('success'); 
                        
                         $('#morprov'+data.success).attr('providerstatus', 2)
                        // console.log('table Not_related_to_Invoice_Finance .inv'+data.error)
                            $('.inv'+data.success).html('Related To Invoice Finance');
                          }
                        }
      
        
        });
    
  

})
    
            $('.providerStatus').click(function(){
  $('#debenturemortgage').prop('checked', false); 
            var  outstandingID  = $(this).attr('data-id')
            var  providerStatus  = $(this).attr('providerStatus')

            
        // $('#debenturemortgage').prop('checked', true);   outstandingID
     
            $("#radio_"+providerStatus).prop('checked', true);
            
      
                
            var parid = GetUrlParamID();
                
            $('.providerid').val(outstandingID);
             $('.providercompanyid').val(parid);

            })








$('#debenturemortgage').change(function() {
    if(this.checked) {
   
        
      // $('#debmortgage form lable').text('Not related to Invoice Finance ');  
      
    }
});

function gettagscampList(param){
    
   
//console.debug(param)
  //var param = 154537;
     var parent_tag_name_holder = [];
    var parent_tag_name = [];
     var para = {'companyID': param};
             $.ajax({
        type: "POST",
            data: para,
            dataType: "json",
                 url: 'companies/fe_get_tag',
            success: function(data) {  
                $.each( data, function( key, val) {
                 //parent_tag_name_holder.push('<ul class="tagLists'+param+val['parent_tag_id']+'"><li>'+val['name']+'<li></ul>')  
 //console.log(parent_tag_name_holder.indexOf('tagLists'+val['parent_tag_id']))
//console.log(parent_tag_name_holder.indexOf(val['parent_tag_name']+val['parent_tag_id']) )
        if(parent_tag_name_holder.indexOf(val['parent_tag_name']) == -1){

        parent_tag_name_holder.push(val['parent_tag_name']);

        $('.tagLists'+param).append('<div class="col-xs-6 col-sm-3  tag_display_holder"><div class="tag-display-header">'+val['parent_tag_name']+'</div><ul class="listTagSummary tagLists'+param+val['parent_tag_id']+'"></ul></div>');
            //console.log("Needle found.");

        };
  })
                
                //console.log(parent_tag_name_holder.join(""));
                
                // $('.tagLists'+param).append(parent_tag_name_holder.join(""));
              populateGetTagsCampList(data,param)
if(data.length) $('.tagLists'+param).show(); 
                
            
               //console.log(parent_tag_name_holder.join())
        
            }
                  
        })
    }




function populateGetTagsCampList(data,param){
    
    
     var parent_tag_name_holder = [];
     var parent_tag_name = [];
     var para = {'companyID': param};
         $.each( data, function( key, val) {

                       if(val['parent_tag_name'] != null){
                              parent_tag_name =    val['parent_tag_name'].replace(' ', '');
                            //if(parent_tag_name != 'Downloads'){
                                   //console.log(val['name']);
                                $('.tagLists'+param+val['parent_tag_id']).append('<li>'+val['name']+'</li>');
                                        //parent_tag_name_holder.push(val['parent_tag_name']);
                              //  }
                       }
                 }) 
    
    
}

$(window).load(function(){
    window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove(); 
    });
    }, 2000);
});
$('#action_type_completed').change(function(){
                                                                         $('.action_verbiage').hide();
                                                                        var action_verbiage_text = $(this).val();

                                                                       $('.action_verbiage_text'+action_verbiage_text).show();


                                                                        console.log($(this).val())
  
    $('#action-error .editBoxInstruction').text('Source');
var source_check = $("input[name=source_check]").val();
    var phone_check = $("#phone").val();
    var contact_check = $(".companyDetailsContacts").length;
var company_pipeline = $("input[name=company_pipeline]").val();
    var sourceRequiredTitle = 'Source';
      var check = 'Source';

if ((this.value == '16' || this.value == '8' || this.value == '32') && (!source_check || ( this.value == '16' && phone_check== false) || ( this.value == '16' && contact_check== false))) 
{
 
 
   $('#add_action .disable_no_source').prop('disabled', 'true');
    $('.actionEvalPipeline').show()
    
            if(this.value == '16' || this.value == '8'){ 
                $('.completed-details').attr('required', 'required');
                $('.actionEvalPipeline').show();
                 $('.addActionOutcome').show();

            }else{
                $('.completed-details').prop('required', false);
                $('.actionEvalPipeline').hide();

                //$('.addActionOutcome').hide();
              //if (this.value ==32){ 
                                //  $('.addActionOutcome').hide();
                              //}else{
                                   $('.addActionOutcome').show();

                              //}
            }
    
    $('.sourceRequiredDropDownItem').text($('#action_type_completed option:selected').text());
    $(".no-source").slideDown(600);
    
    
   
    
    
    
    if(this.value == '16' && (!source_check) && (!phone_check)){
       
       
       
       }
    
     if(this.value == '16' && (!phone_check)){
      
         check = 'Phone Number';
         
         sourceRequiredTitle = check ;
    }
    
       if(this.value == '16' && (!source_check)){
      
       check =  'Source';
            sourceRequiredTitle = check ;
    }
    
           if(this.value == '16' && (!contact_check)){
      
       check =  'Contact';
                sourceRequiredTitle = check+' Details' ;
    }
    
    
    
    
      if(this.value == '16' && (!source_check) && (!phone_check) && (!contact_check)){
       
       check =  'Company Source Phone Number and Contact Details';
          
           sourceRequiredTitle = 'Source, Phone Number, Contact Details' ;
          
       }
    
   if(this.value == '16' && (source_check) && (!phone_check) && (!contact_check)){
       
        check =    'Company Phone Number and Contact Details';
       
       sourceRequiredTitle = 'Phone Number, Contact Details';
       
    }
    
    if(this.value == '16' && (phone_check) && (!source_check) && (!contact_check)){
       
        check =   'Company Source and Contact Details';
        
         sourceRequiredTitle = 'Source, Contact Details';

       
    }
    
    
    if(this.value == '16' && (contact_check) && (!source_check) && (!phone_check)){
       
        check =   'Source and Phone Number';
        
         sourceRequiredTitle = 'Source, Phone Number';
       
    }
    
    
    
    
    
   
    
   
    
  
    
  
    
    $(".sourceRequiredTitle").html(sourceRequiredTitle);
     $('#action-error .editBoxInstruction').html(check);
    
    
    
   /// console.log('the phone number  is '+$("#phone").val());
    
    //$(".no-source").show();
    //$(".disable_no_source").attr('disabled', 'disabled');
    }
    else
    {
    
        $(".no-source").slideUp(600);

        $('#add_action .disable_no_source').prop('disabled', '') ;


        var actionArr = ['31','32','33','34'];
        
    if (actionArr.indexOf(this.value) >=0){ 
         $('.completed-details').prop('required', false);
         $('#add_action .disable_no_source').prop('disabled', false);
         $('.actionEvalPipeline').hide();

                      //if (this.value ==32){ 
                        //  $('.addActionOutcome').hide();
                      //}else{
                           $('.addActionOutcome').show();

                      //}
         //
          
    }else{
        
        $('.completed-details').attr('required', 'required');
        $('.addActionOutcome').show();
        $('.actionEvalPipeline').show()
    }
    //$(".no-source").hide();
    //$(".disable_no_source").removeAttr('disabled', 'disabled'); 
if(!this.value){
    
    //alert();
    $('#add_action .disable_no_source').prop('disabled', true);
      $('.addActionOutcome').hide();
}


}
    
});

/*
$(".pipeline-validation-check").change(function() {
    
 
var company_source = $("select[name=company_source]").val();
var company_pipeline = $("select[name=company_pipeline]").val();
var pipeline_check = $("input[name=pipeline_check]").val();
var company_class = $("select[name=company_class]").val();
if ((this.value !== 'Prospect' && this.value !== 'Lost' && this.value !== 'Unsuitable') && (!company_source || company_source==0||company_class=='Unknown')) 
{
$(".no-source-pipeline").slideDown(600);
alert();
$(".disable_no_source").attr('disabled', 'disabled');
    
    alert();
}
else
{
$(".no-source-pipeline").slideUp(600);
//$(".disable_no_source").removeAttr('disabled', 'disabled');
}
});



*/

$(".pipeline-validation-check").change(function() {
        var company_source = $("select[name=company_source]").val();

            var companysourceArr = ['7','8','10','11']; //Source id to force user to enter special insight 


        if (companysourceArr.indexOf(company_source) >=0) 
        {
            $(".show_si_box").slideDown(600);
            $(".source_explanation").attr('required','required');
            $(".disable_no_si").attr('disabled', 'disabled');
        }
        else
        {
            $(".show_si_box").slideUp(600);
            $(".source_explanation").attr('required',false);
            $(".disable_no_si").removeAttr('disabled');
        }

          var company_class = $("select[name=company_class]").val();

        if (company_source==0 ) 
        {
            //$(".no-source-pipeline").slideDown(600);
            //$(".disable_no_source").attr('disabled', 'disabled');
        }
        else
        {
            $(".no-source-pipeline").slideUp(600);
            //$(".disable_no_source").removeAttr('disabled', 'disabled');
//console.log(company_source )
        if(company_source == "0" ){

            $(".disable_no_si").removeAttr('disabled');

        }


        }

 
    
});


        $(".source_explanation").keyup(function() {
            var si_check = $("input[name=source_explanation]").val();
            var company_source = $("select[name=company_source]").val();
            
            //    /^[a-z0-9]+$/i
            
            
              var companysourceArr =  ['2','3','4','5','6','7','8','9','14','15'];
            
     var str = si_check;
    var patt1 = /[^a-z\d]/i;
    var result = str.match(patt1);
 
            
            
            
           //console.log('Result: '+ result + ' siCheck '+si_check.trim().length + ' comapny of source'+ companysourceArr.indexOf(company_source))
        if (si_check.trim().length <= 0  &&  companysourceArr.indexOf(company_source) >=0) {

            // console.log('What the FALSE amn'+si_check);
            
            $(".disable_no_si").attr('disabled', 'disabled');
        }
        else
        {
            
            $(".disable_no_si").removeAttr('disabled');
        }
        });

 
    function getDealAvg(){

               var avg;
        var sum =0;
        var val = 0;
        var count_lines  = $('.us-initial-rate').length;
            //loop thru totals
        $('.us-initial-rate').each(function(){
            if(parseFloat($(this).text())){
              val = parseFloat($(this).text()) + val;
            }else{
              count_lines -1;
            }
            });
        val = val/count_lines;
        //console.log(parseFloat( val.toFixed(3) ));
        avg = val ? 'Avg '+ parseFloat( val ).toFixed(2)+'%' : '';
        $('.us-initial-rate-total').text(avg);
    }

  if((/companies\/create_company/.test(window.location.href))) {
        
        $('.company_class').change(function(){
            if($(this).val()  == 'PreStartUpWithoutAddress'){
                $('.cr_address, .cr_address_trading').hide();   
                
                $('.tradingType').prop( "disabled", true );

                $('#address').removeAttr('required');
            }else{
                    if(typeof $('#address').attr('required') === 'undefined'){
                       // $('#address').attr('required', 'required');
                    }
                 $('.tradingType').prop( "disabled", false );
                $('.cr_address').show();
            }
         }) 
    }


    
    
    
   if((/campaigns/.test(window.location.href)) ||(/companies/.test(window.location.href))) { 

            var regArray = [];
            $('.company-header a').each(function(e,i){

                gettagscampList($(this).attr('comp').trim());
                  //console.warn($(this).attr('comp').trim());
            })

 }
    
    
    
  
        

     if((/companies\/company/.test(window.location.href))) {
         
         
    if($('#source_explanation').val()){
       
       $('.show_si_box').show();
       
       }
         
         // event.preventDefault()
         
        // var simplemde = new SimpleMDE({ element: $(".completed-details")[0] });
         
         //simplemde.value("Add **Outcomer**");
       $(window).scroll(stickyActionsMenu);
      
         $('.other_sectors .button-checkbox .btn-checkbox, .target_sectors .button-checkbox .btn-checkbox').click(function(){ //Target sectors event visiual manager
             
            if($(this).hasClass('btn-default')){
                        $(this).addClass('tsector');
                        $(this).removeClass('active');
                        $(this).removeClass('btn-default');
                    }
            });
         
            $('.tsector').removeClass('tsector'); 
        $("form").submit(function () {
            if ($(this).valid()) {
            $(this).submit(function () {
            return false;
            });
            return true;
            }
            else {
            return false;
            }
            });
     }

//Prevents form from subitting     
    
            

    
    
    $('#add_action_request').click(function(e){
        
      
        var check  = /^\d+\.\d{0,2}?/.test($('#amount').val());
        if(check === false){ 
            $('#amount').val('')
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function (e) {
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "amount":
                            e.target.setCustomValidity("Decimal number required");
                            break;
                        }
                    }
                };
                elements[i].oninput = function (e) {
                }
            };
        }else{
       // console.log('Check me out '+check); 
            e.target.setCustomValidity("");  
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function (e) {
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "amount":
                            e.target.setCustomValidity("");
                            break;
                        }
                    }
                };
                elements[i].oninput = function (e) {
                e.target.setCustomValidity("");
                $('#amount').trigger('click');
              }
            }
            e.target.setCustomValidity("");
        }
});
    
     getDealAvg(); //Get Deal Average used for user stats
    ////////End stats counter//////////////////////
    var autopilotEmailCompany = window.location.href.split("id="); 

    if((/dashboard/.test(window.location.href))) {
        
         $('.mycampaignajaxcount').html('<img style="-webkit-user-select: none" src="assets/images/ajax-loader.gif">');
       
                $.ajax({
                type: "GET",
                    dataType: "json",
                url: "dashboard/private_campaigns_new_ajax",
                success: function(data) {
                    var action;
                    var items = [];
                     var idfk;
                   var uimage;
        if(data.success == 'not ok'){
             $('.mycampaignajaxcount').html('0');
        }else{
                    $.each( data, function( key, val ) {
                          idfk = val.company_id;
uimage = val.image.split(',')
 
                      
                        items.push( '<a href="campaigns/display_campaign/?id='+val.id+'" class="load-saved-search" title="" data-original-title="'+val.datecreated+'"><div class="row"><div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: '+uimage[1]+';font-size:8px; color: '+uimage[2]+'"><b>'+uimage[0]+'</b></span></div><div class="col-xs-9" style="min-height:30px;overflow:hidden">'+val.name+'<br><span style="font-size:9px;">Created: '+val.datecreated+'</span></div><div class="col-xs-1" style="padding: 0 0 0 0px; font-size: 11px;">'+val.percentage+'%</div></div></a>');
                  
                    
                    });
                       
                    $('.mycampaignajax').html(items.join( "" ));
                    //$('.mycampaignajaxcount').html('<img style="-webkit-user-select: none" src="http://localhost:8888/baselist/assets/images/ajax-loader.gif">');
                    $('.mycampaignajaxcount').html(items.length); //update engagement counter
                }
                }
            });
            
        
        
        
        
        
             $.ajax({
        type: "GET",
            dataType: "json",
        url: "dashboard/getActionsProposals",
        success: function(data) {
            var planned_at;
            var  createdAt; 
            var pipleine =  ['intents', 'proposals'];
 $.each( pipleine, function(  index, keyval ) {
            
             $.each( data[keyval], function( key, val ) {
                 
               createdAt = val.intent ? val.intent : val.proposal;
                 
    $('.record-holder-'+keyval).append('<div class="row record-holder"><div class="col-xs-2 col-sm-2 col-md-2">'+createdAt+'</div><div class="col-xs-4 col-sm-4 col-md-4"><a href="companies/company?id='+val.id+'">'+val.name+'</a></div><div class="col-xs-2 col-sm-2 col-md-2  "><span class="pipeline ">'+(val.planned ? val.planned : '') +'</span></div><div class="col-xs-2 col-sm-2 col-md-2  "><span class="pipeline ">'+ (val.action ? val.action : '')  +'</span></div><div class="col-xs-2 col-sm-2 col-md-2  "><span class="pipeline ">'+(val.by ? val.by : '')   +'</span></div></div>')
           
             })
                    var record_holder_propsals_length =    $('.record-holder-'+keyval+' .record-holder').length;
                    record_holder_propsals_length = record_holder_propsals_length ? record_holder_propsals_length :'0';
                    $('.eventcount'+keyval).text(record_holder_propsals_length);
             })
        }

    });
        
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
            var company = val.company.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});
            var pipeline = val.pipeline.charAt(0).toUpperCase() + val.pipeline.slice(1);    
            items.push( '<div class="row record-holder"><div class="col-xs-8 col-sm-4 col-md-3"><a href="companies/company?id='+idfk+'">'+company+'</a></div><div class="col-xs-8 col-sm-4 col-md-2">'+val.campaign+'</div><div class="col-xs-4 col-sm-1 col-md-1 text-right"><span class="label pipeline label-'+pipeline+'">'+pipeline+'</span></div><div class="col-xs-6 col-sm-2 col-md-2"><a href="companies/company?id='+idfk+'#contacts">'+val.username+'</a></div><div class="col-xs-6 col-sm-3 col-md-2 align-right "> <span class="label label-primary">'+action+'</span></div><div class="col-xs-12 col-sm-2 col-md-2 contact-phone">'+val.date+'</div></div>' );
            } 
        }); 
        $('#stat').html(items.join( "" ));
        $('.eventcount').html(items.length); //update engagement counter
        }

        });

        //GET TEAM STATS VIA JSON
       $.ajax({
            type: "GET",
                dataType: "json",
            url: "dashboard/getTeamStats",
            success: function(data) {
                $.each( data, function( key, val ) {
            //key = tslastweek, tscurrentmonth , tslastmonth
                   $('#ts'+key).html(val);
                   
                })  
               tsTotalConfig();
            }
        });
        
        
        
           $.ajax({
            type: "GET",
                dataType: "json",
            url: "dashboard/getTeamStats/uf",
            success: function(data) {
                $.each( data, function( key, val ) {
            //key = tslastweek, tscurrentmonth , tslastmonth
                   
                    $('#uts'+key).html(val);
                })  
               tsTotalConfig();
            }
        });
         //GET TEAM STATS END 
            getUserFavourites();   
        $('.sortform form select').change(function(){
            getUserFavourites(); 

})
        
        
        
    }
    if(autopilotEmailCompany[1]){ 
    var myParam = window.location.href.split("id=");
    var action ;
    $.ajax({
    type: "GET",
    dataType: "json",
    url: "../Marketing/autopilotActions/"+GetUrlParamID(),
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
            //$('#sidebar').hide();
        
       // show();
       // $(window).scroll(show);
    });
    $('.marketingAcitonCtn').text(parseInt($('.marketingAcitonCtn').text()) + i);
    $(items.join( "" )).prependTo('#marketing ul');
    //if(i) $('#outstanding h4,.actionMsg h4').hide();
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
            //checkInitialFee()
        }else{
            $('.onInitialFee').removeClass('col-md-2');
            $('.initialfee input').val('').removeAttr('required');
            $('.initialfee').hide();
        }

    })

 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
});



    
    
      function addActionChange(){
        //console.log('france')
               $('.actionrequired').click(function(){


//console.log()
                        if($('#action-error').css('display') != 'none'){
                        event.preventDefault();
                        }


})
               
               
}


function getUserFavourites(){ // Dashbord favorites
    
    var order = $('.sortform form select').val();
    var pipeline = [];
        var favourites = [];
        $.ajax({
            type: "GET",
                dataType: "json",
            url: "dashboard/refactorFavourites/"+order,
            success: function(data) {
                
                $.each( data, function( key, val ) {
                    pipeline =   val.pipeline ? val.pipeline : '';
                    favourites.push('<a href="companies/company?id='+val.id+'" class="load-saved-search"> <div class="row"> <div class="col-xs-8">'+val.name+'</div><div class="col-xs-4"> <span class="label label-'+pipeline+'" style="margin-top: 3px;"> '+pipeline+' </span> </div></div></a>');     
                }) 
                
                    $('#assigned .panel-body').html('');
                    $('#assigned .panel-body').prepend(favourites.join(""));

                    var favouritesCount =  $('#assigned .panel-body a').length;

                    if(favouritesCount != 0){
                        var favouritesCount = $('#assigned .panel-body a').length;
                        $('.favouritesCount').text(favouritesCount);
                        $('.sortform').show();
                    }else{

                        $('.sortform').hide();
                        $('.favouritesCount').text(0);
                        $('#assigned .panel-body').prepend('<div class="col-md-12"> <div style="margin:10px 0;"> <h4 style="margin: 50px 0 40px 0; text-align: center;">You have no recent activity.</h4> </div></div>');

                    }
            }
        });  
    
}

    function tsTotalConfig(){

        if($('.mainAddrType').length > 1) $('.copyRegAddr').remove(); // Removes add copy address check button if more than 1 address exist 
            //counts the totals in team stats columns
            var mycolumnArray = ["tw","lw","tm","lm","sr","utw","ulw","utm","ulm","usr"];
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


    }

function timerounder(incomingtime){
  var s = [];
 incomingtime =   incomingtime.split(':')
   var minutes = incomingtime[1];
var hours = incomingtime[0];
var m = (parseInt((minutes + 7.5)/15) * 15) % 60;
var h = minutes > 52 ? (hours === 23 ? 0 : ++hours) : hours; 
    if(m ===0) s=0;
    return h+':'+m+s;
    
}








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
if(trAddress == 2){ $('.addrTrading').show();  $('#tradingAddress').attr('Required', 'Required');  } else{ $('.addrTrading').hide(); $('#tradingAddress').val(''); $('#tradingAddress').removeAttr('Required', 'Required');   }
});
if($('.popUpAddress').val() && $('.mainAddrType').text() != 'Trading Address'){$('.copyRegAddr').hide() }
$('#copymainaddr').click(function(){
if($(this).prop("checked")){ $('.popUpAddress').val($('.mainAddress').text()) }else{ $('.popUpAddress').val('') }
})
function triggerOpenEditbox(){
    
    $('.mainedit').trigger('click');
    
    
}
