$(document).ready(function(){

        $('.timeline-header .showText').click(function(){
            
            $('.callbackActionTextBox').toggle(false);
            var activeMenu =  $('.activeMenu').attr('data');
                   var status =  $('.actionMsg').css('display'); 
            
        
            if(status == 'block' || status == 'inline'){
                $('.actionMsg').hide();  
                $('.showText').text('Show/Comment');

            }else{
                $('.actionMsg').show();
                $('.showText').text('Hide/Comment');
            }
        });
        
            $('.showCommentAddBtn').hide();
           // $('.showText').hide();
  
            $('.showCommentAddForm').hide();
       

       $('.showCommentAddBtn').on('click', function(){
           
            var blockStatus  = $('.showCommentAddForm').css('display');
            if(blockStatus === "block"){
                $('.showCommentAddForm').toggle(false);
            }else{
                 $('.showCommentAddForm').toggle(true);
            }
        });
        
    
        $('#actionSendComment').submit(function(e){
            e.preventDefault();
           var param =  $('#actionSendComment').serialize();
          
                $.ajax({
                  type: "POST",
                    data: param,
                      dataType: "json",
                  url: "../Actions/addActionsComment",
                  success: function(data) {  
                 $('.timeline_inner').html('');
                      $('#commentcontent').val('');
                      
                     getActionData('comment',true);
                      $('.actionAll').trigger('click');
                      
                      
                       $('.showCommentAddForm').hide();
                      
                  }
                  });
              
            $('.timeline-entry').show();
            
        })
        
        getActionData(); //Get actions
      
  });
function getActionData(scope = false){ //get all actions in multidimentional json array
        if((/companies/.test(window.location.href))) {
        $.ajax({
            type: "GET",
            url: "../companies/getAction/",
            success: function(data) {
                $('.timeline_inner').html('');
                $('.timeline_inner').append(writeactions(data)); 

                //ADD ALL AFTER LOAD BINGING HERE
                callbackActionTextBox();
                getemailengagement();
                bindAddCallBackToCompletedAction();
                add_outcome();
                bindPillerTitles();
                removeOutsandingAction();
                mainMenuQty()
                //$('.follow-up-date').datepicker();
$('.actiondate').datetimepicker();
                $('.form .actionContact').clone().prependTo('.actionForm');

                //bindfollowUpInfoBtn(); 

            } //end success
        });   

        $('.timeline-entry').show();
            
        }
            
     }
function writeactions(data, scope = false){

    //dealTemplate()
        var useractionsections;
        var action_types_array;
        var  action_types_list;
        var actionType = [];
        var icon;
        var initial_fee=[] ;
        var initial_fee_cal;
        var  actions_outstanding = false;
        var actions_cancelled = false;
        var comments = [];
        var pipeline;
        var commentMenu =  [];
        var actionresulted = [];
        var actionresult = [];
        var actionresults = [];

        stickMenu() // sticky menu  check to see if still valid ==
        var obj= data //$.parseJSON(data

            $.each( obj, function( k, val ) {

                if( val[0]['action_types_array'] !== 'undefined'){
                        action_types_array  =   val[0]['action_types_array'];
                }

               if(typeof action_types_array !== 'undefined'){
                   action_types_list  = action_types_array; 
                   //console.log(pipeline);
                }   
            })

            jQuery.each( obj, function( k, val ) {
                useractionsections  =  val[0];
                 if( typeof useractionsections === "object" && !Array.isArray(useractionsections) && useractionsections !== null){
                   jQuery.each( useractionsections, function( kp, valp ) {
                    //getAction
                       jQuery.each( valp, function( kpt, action ) { 

                            actionType = action_types_list[action['action_type_id']] ;

                            switch (kp) {
                                case 'actions':

                                break;
                                case 'actions_outstanding':

                                if(action['initial_rate']){
                                    initial_fee = (parseFloat(action['initial_rate']*100).toFixed(1));
                                }                    

                                    actions_outstanding = action['action_id']?action['action_id'] : '';

                                       // console.warn('outstanding--------------------------------'+action['action_id'])
                                break;
                                case 'actions_completed':
                                    //console.info('actions_completed-- '+actionType+ action['image']);
                                          //console.log('  waaaaaarn '+action['comments'])
                                            pipeline =  action['comments'];   
                                break;
                                case 'actions_cancelled':
                                    //console.info('actions_cancelled-- '+actionType+ action['image']);
                                        actions_cancelled = action['comments'];
                                         //console.warn('actions_cancelled-------------------------------'+actions_cancelled);
                                break;
                                case 'comments':

                                        comments = action['comments'];    
                                break;
                            }

                            if (typeof action['image'] !== 'undefined' || actions_cancelled !='' || comments !=''){   

                                  if(pipeline != 'Pipeline changed to Customer' ){

                                        pipeline = false;
                                    }

                            if(typeof actionType !== 'undefined'){

                                icon =  getIcon(actionType);

                                actionresults  =    actionProcessor(actionType ,action,icon,initial_fee,pipeline,actions_outstanding,actions_cancelled,comments,kp);

                                actionresult.push(actionresults)

                                  // $('.timeline_inner').append(actionresults);
                                actions_outstanding = '';
                                //actions_cancelled = '';

                            }


                    }

              })

        })
                        if(scope){
                            $('.'+scope).trigger('click');
                        }
        }

     });  //loop end
       actionresult = actionresult.join("");

           return actionresult;         

}
    function callbackActionTextBox(){
        $('.callbackAction').on('click', function(){

            var dat = $(this).attr('data');
              var blockStatus  = $('.box'+dat).css('display');
            
                $('.textarea'+dat).attr('placeholder', 'Add outcome');

            if($('#callBackActionStatus'+dat).val() == 'cancelled'){
                $('#callBackActionStatus'+dat).val('completed'); 
            }else{ 
                    $('#callBackActionStatus'+dat).val('completed');

                    $('.actionMsg'+dat).toggle(true);
                    $('.outcomeMsg'+dat).toggle(true);
                    $('#callBackActionStatus'+dat).val('completed');

                    if(blockStatus === "block"){
                        $('.box'+dat).toggle(false);

                        $('.actionMsg'+dat).toggle(false);
                        $('.outcomeMsg'+dat).toggle(false);
                        $('#callBackActionStatus'+dat).val('');
                    }else{
                        $('.box'+dat).toggle(true);
                    }
            }
        })
    }
    function add_outcome(){ //Redundent function
        
        $('.callbackActionTextBox_ form').submit(function(e){
            e.preventDefault();
            var urll = $(this).attr('action');
            //alert(urll)
            var outcomeId = $(this).attr('data');
           // alert(outcomeId) 
          //JS JASON WITH POST PARAMETER
                 var para = $(this).serialized();
                  $.ajax({
                        type: "POST",
                          data: para,
                            dataType: "json",
                        url: urll,
                        success: function(data) {
                         getActionData(true);
                        }
                    }); 
            
                $('.actionAll').trigger('click');
        })
    } 
function bindAddCallBackToCompletedAction(){
    var followUpCompleteddate = [];
    var param =  $(this).serialize();
    var followup = [];
    var contactDetails = [];
    var actionOutcome = [];
    var overdueStatus = [];
    var cancellation = '';
        $.ajax({
          type: "POST",
          data: param,
          dataType: "json",
          url: "../companies/getCompletedActions",
          success: function(data) {
                   var obj= data     
                   var i = 1 ;

                      $.each( obj, function( k, action ) {
                            //console.debug(val[0]['action_types_array']);
                       if(i===1){
                         $('.outcomeMsg'+action['followup_action_id']).append('<br /><hr />')
                       }

                        if(action['action_type_id'] == 11  && action['followup_action_id'] != null && action['followup_action_id'] != null ){

                            followUpCompleteddate = '<span class="label label-warning" style="margin-right: 10px;">Follow up planned: '+ formattDate(action['planned_at'])+' </span>';
                           if(action['cancelled_at'] != null){
                                     cancellation = '<span class="label label-danger" style="margin-left: 5px;">Cancelled: '+formattDate(action['cancelled_at'])+ '</span>';
                           }
                       }

                      if(action['action_type_id'] == 11  && action['followup_action_id'] != null && action['planned_at'] == null && typeof action['planned_at'] != 'undefined' && typeof action['planned_at'] != null){
                                followup = '<span class="label label-warning" style="margin-right: 10px;"> Follow Up Action:  '+formattDate(action['planned_at'])+' </span>';
                            }

                      if(action['action_type_id'] == 11  && action['followup_action_id'] != null && typeof action['planned_at'] != 'undefined' && typeof action['planned_at'] != null){

                          if(action['first_name'] != null){

                             contactDetails = ' <span class="label label-primary"style="float: right;"> '+action['first_name']+' '+action['last_name']+' </span><br>';

                          }

                      }

                       if(action['action_type_id'] == 11 ){

                            overdueStatus = '<span class="label label-danger">Overdue</span>' ;
                          var dateCompare = (new Date() - Date.parse(action['planned_at'])) >= 1000 * 60 * 30;
                            
                          if(dateCompare == false && typeof action['planned_at'] != 'undefined'){
                                overdueStatus = '';
                          }

                         if(typeof action['outcome'] == 'undefined'  || action['outcome'] == null){
                             actionOutcome = ''
                         }else{ 
                             actionOutcome = '<strong>Outcome: </strong>'+action['outcome'];

                         }           

                            $('.outcomeMsg'+action['followup_action_id']).append('<div class="followcont" style="background: #fff; padding: 10px; margin-bottom: 5px; margin-top:5px;">'+followup+ ' ' +followUpCompleteddate+cancellation+contactDetails+
                                                                                ' <span class="comments"><br><strong>Action: </strong>'+action['comments']+'<br>'+actionOutcome+
                                                                                '</span><hr /></div>'); 
                        }
                        followUpCompleteddate = '';
                        cancellation = '';
                        i++;
                })


            } 

        })

        $('.callbackActionTextBox form').submit(function(e){
           
                e.preventDefault();
                var url = $(this).attr('action');
               var outcomeId = $(this).attr('data');
 
                //JS JASON WITH POST PARAMETER
                var para = $(this).serialize();
                $.ajax({
                    type: "POST",
                    data: para,
                    dataType: "json",
                    url: "../"+url,
                    success: function(data) {

                        getActionData();

                        var submittedFormId = data.followup_action_id;

                         $('.box'+submittedFormId+ ' .actionContact').val('')
                         $('.box'+submittedFormId+ '  .planned_at').val('');
                         $('.box'+submittedFormId+ ' textarea').val('');

                         $('.outcome'+ outcomeId).hide();
                    }
                });

            })

}
    function bindPillerTitles(){

        $('.pillerTitle').click(function(){
            var dat = $(this).attr('data');
            var blockStatus  = $('.piller'+dat).css('display');
            
            if(blockStatus === "inline"){
                $('.piller'+dat).toggle(false);
                $('.box'+dat).toggle(false);
              
                
           // $('.textarea'+dat).toggle(false);
            }else{
           if($(this).hasClass('showOutstandingForm')){
                 $('.box'+dat).toggle(true);
           }
                $('.piller'+dat).toggle(true);
            }

        });
    }
     function removeOutsandingAction(){
         
          $('.removeOutsandingAction').click(function(){
             var dat = $(this).attr('data');
                $('.textarea'+dat).attr('placeholder', 'Add cancellation reason'); 
              if($('#callBackActionStatus'+dat).val() == 'completed'){
                 $('#callBackActionStatus'+dat).val('cancelled');   
              }else{ 
                $('#callBackActionStatus'+dat).val('cancelled'); 
                $('.actionMsg'+dat).toggle(true);
                $('.outcomeMsg'+dat).toggle(true);
                 var blockStatus  = $('.box'+dat).css('display');
                if(blockStatus === "block"){
                     $('.outcome'+dat+ ' .box'+dat).toggle(false);
                     $('.actionMsg'+dat).toggle(false);
                     $('.outcomeMsg'+dat).toggle(false);
                     $('#callBackActionStatus'+dat).val('');
                }else{
                     $('.outcome'+dat+ ' .box'+dat).toggle(true);
                 }
              }
            });
         
         //getActionData();
         
     }
function getemailengagement(){
     //actionresults =  actionresult.join();
    var myParam = window.location.href.split("id=");
    var action ;
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../companies/autopilotActions/",
        success: function(data) {

            var action;
            var items = [];
            var idfks;
            var  i = 0
            var contactName = [];
            $.each( data, function( key, val ) {              
                switch (val.action) {
                    case '1':
                    action  = '<span class="label label-success">Opened</span>'; 
                    break;
                    case '4':    
                    action  = '<span class="label label-danger">Unsubscribed</span>'; 
                    break;
                    case '2':
                    action =  '<span class="label label-success">Clicked</span>';
                    break;
                }


                  if(val.first_name != null){
                      contactName = '<div class="label label-primary hint--top-right"   data-hint="Name" style="float:right; margin-top:0; ">'+val.first_name+ ' '+ val.last_name+'</div>';
                        }

                if( val.campaign !== null ){
                    if(val.action != '3'){
                        i++;
                        /*
                        $( '<li class="list-group-item"><div class="row"><div class="col-xs-6 col-md-7"><h4 style="margin:0;">'+val.campaign_name+'<div class="mic-info">'+val.date+ ' by '+val.email+
                        '</div></h4></div><!--END COL-MD-4--><div class="col-xs-6 col-md-5" style="text-align:right;"><span class="label label-primary" style="font-size:11px;  ">'+val.first_name+ ' '+ val.last_name+
                        '</span> '+action+' </div></div></li>' ).prependTo('#marketing_action ul'); */
                $('.timeline_inner').append('<div class="timeline-entry   actionIdactions_marketing" style="dislay:none;"> <div class="timeline-stat"> <div class="timeline-icon label-danger " style="color: white;"><i class="fa fa-comment fa-lg"></i></div><div class="timeline-time ">'+val.date+  ' </div></div><div class="timeline-label"> <div class="mar-no pad-btm"><h4 class="mar-no pad-btm"><a href="javascript:;" class="text-danger"> '+val.campaign_name+' <span class"eeprefix">(Outbound Marketing)</span> </a>   </h4>'+'<span class="label label-warning">'+val.date+'</span></div><div style="float:right; margin-top:-4px; margin-left:3px;">'+action+'</div>'+contactName+'<div class="actionMsgText"><span class="actionMsg commentsComment">what a laugh</span><hr></div><div> <div class="mic-info"> by '+val.email+'</div></div></div>')
                    }
                }
                    //$('#sidebar').hide();

                //  show();
                //$(window).scroll(show);
            });
            
            $('.marketingAcitonCtn').text(parseInt($('.marketingAcitonCtn').text()) + i);
            
            $(items.join( "" )).prependTo('#marketing_action ul');
            //if(i) $('#outstanding h4,.actionMsg h4').hide();
            mainMenuQty()
            
                
        }


    });
}
    function mainMenuQty(){

        var action;
        var qtyaction;
        var i =0;
        $('.nav-stacked li a').each(function(){
            action  = $(this).attr('data');
            
            qtyaction = $('.actionId'+action).length;
            $('.qty'+action).text(qtyaction);
            //console.debug($('.actionId'+action).length)
            i = (qtyaction+i);

        })
       
        $('.qtyAll').text(i)


var overdueStatus = $(".overdueAction").length;
if(overdueStatus){
$('.qtyactions_outstanding').css({'background': '#d9534f','color': '#ffffff', 'font-weight' : '600'});
 

}
 
   intefaceVisibility();
     $('.actionMsg').show();    

    } 
function intefaceVisibility(){
    
         if(parseInt($(".qtyAll").text()) == 0){

$('#sidebar').hide();
 $('.timeline').hide();
             $('.noactionmsg').show();

}else{
 $('#sidebar').show();
 $('.timeline').show(); 
     $('.noactionmsg').hide();
    
    
}
    
    
}
     function stickMenu(){
            $('.sticky li a').click(function(){
        var    showtext  = $(this).attr('data'); 
                
              
                    
                  //callbackActionTextBox();
                $('.showText').show(); 
                $('.sticky a').removeClass('activeMenu');
                $('.actionMsg').hide();
                $('.showCommentAddForm').hide();
                $(".callbackActionTextBox").hide();
                
                // $('.callbackContacts .actionContact').remove(
                 $('html,body').animate({ scrollTop: $("#stickMenu").offset().top},'slow');
                   $('.timeline-entry').hide()
                   var action =  $(this).attr('data');  
                   $('.actionId'+action).show();
                        $('.pipeline').hide();     
                  
                //alert(action)
                var numberofactions  = $('.actionId'+action).length
                var acctionqty  = '<span class="circle actionTotal">'+numberofactions+'</span>'
                      
                if(action == 'actions_marketing') action = 'Marketing';   
                if(action == 'actions_cancelled') action = 'Cancelled';  
                if(action == 'actions_outstanding') action = 'Scheduled';  
                if(action == 'actions_completed') action = 'Completed';  
                $('.actiontitle').html(action+ acctionqty);
      
                
            
                $('.showText').html('Show/Text');

                $(this).addClass('activeMenu');

                 if(action  == 'All'){
                   
                     $('.showText').html('Show/Text');   
                            $('.timeline-entry').show();
                            $('.actiontitle').html('History');
                             $('.pipeline').show();
                       }
                  if($('.qty'+showtext).text() != 0){
// alert($('.qty'+showtext).text());
                         
               
           
                if(action == 'Marketing'){
                            $('.showText').hide();

                    } 
                                
                    if(action  == 'Comment'){  
                            $('.showCommentAddBtn').show();
                        }else{
                            $('.showCommentAddBtn').hide();
                      }

                    if(action == 'actions_marketing'){
                        $('.showText').hide();
                    }
                  }else{
                      $('.actiontitle').html('actions found (0)' );
                        
                       $('.showText').hide();
                       if( action  == 'Comment'){
                       $('.actiontitle').html('no comments' );
                     $('.showCommentAddBtn').show();
                    
                    
                }
                  }
                
               
                
                
            })
            
         }
    (function($) {
        $.fn.goTo = function() {
        $('html, body').animate({
        scrollTop: $(this).offset().top + 'px'
        }, 'fast');
        return this; // for chaining...
        }
        })(jQuery);
     function bindfollowUpInfoBtn(){
                $('.follow_up_action_btn_').on('click' , function(){
                    var   actionId = $(this).attr('data');
                    //$("a[data='actions_completed']" ).trigger('click');
                    scroller(parseInt(actionId));
                });
                   
    }
     function scroller(actionId){
         //alert(actionId)
         var tech = parseInt(actionId);
            //a[data='"+tech+"']
         $("a[data='actions_completed']" ).trigger('click');
          $('a[data='+actionId+']').trigger('click');
            $('a[data='+actionId+']').goTo(20);
         
     }
     function getIcon(actionType){
            console.log(actionType)
         var icon;
              switch (actionType){
                      
                      
                    case 'Attempted Call':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                       case 'Callback':case 'Call':case 'Called Us':
                         icon = '<div class="timeline-icon label-info "style="color: white;"><i class="fa fa-phone fa-lg"></i></div>';
                    break;
                    case 'Campaign - Lack of Info':
                           icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                    case 'Check-In Call':
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                    case 'Deal':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Demo':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Email':
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                    case 'InMail':
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                       case 'Intro Call':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Meeting':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Met at Event':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                      case 'Proposal Sent':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Quote Requested':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Sales Ledger Due Diligence':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Comment':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-comment fa-lg"></i></div>';
                    break;
                    case 'Web Form - Demo Requested':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                      case 'Web Form - Call Me Requested':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    default: 
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
              }
                     //console.debug(icon);
     
           return icon;
         
     }
     function actionProcessor(actionType = 0 ,action = 0 ,icon = 0,initial_fee,pipeline =0,actions_outstanding=0,actions_cancelled=0,comments=0,kp=0){
         

        var actionImg;
        //var icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>'  ;
        var actionImg = []
        var actionsummary = [];



        if(comments != false || typeof action['image'] !== 'undefined' || actions_cancelled != '') {

            var createdAt  = action['created_at'];
            var updated_at  = action['updated_at'];

            if(comments  == false){
            //console.warn(actionType);
            if(!actions_cancelled ){
            actionImg =   action['image'];
            actionImg =   actionImg.split(',');
            }
            }
            //console.debug(actionImg[0]);

            actionsummary = actionSummary(actionImg,icon,actionType,createdAt,initial_fee,pipeline,actions_outstanding,updated_at,actions_cancelled, comments,action,kp);
        }
        //}
        //}
        //callbackActionTextBox();
        boxActionTextBox();

        return   actionsummary;
     
     } 
     function boxActionTextBox(){
       $('.boxAction').on('click', function(){

            var dat = $(this).attr('data');
           
           
             var blockStatus  = $('.boxcom'+dat).css('display');
             
            if(blockStatus === "block"){
                $('.boxcom'+dat).toggle(false);
       // console.log('true')
            }else{
                //console.log('flase')
                 $('.boxcom'+dat).toggle(true);
            }
        })
 
     }
     function showmenu_(){
         
         
   
     }
     
     function actionSummary(actionImg =0,icon=0,actionType=0,createdAt=0,initial_fee=0,pipeline =0, actions_outstanding=false, updated_at = 0, actions_cancelled=false, comments=0,action=0,kp){
         // console.log(actions_outstanding)
        boxActionTextBox();
         var header;
         var deal = [];
         var tagline = [];
         var calenderbtn = [];
         var outcomeRemove = [];
         var overdueStatus = [];
         var actions = []
         var icon ;
         var badge = ''
         var textbox;
         var actionTypeOverwrite = false;
         var actions_outstanding = (actions_outstanding);
         var planned_at = [];
         var cancelled_at = [];
         var textbox = [];
         var classCompleted = '';
         var kpStr = [];
         var outcome = [];
         var contactName = [];
         var actionTypeName= [];
         var followupAlert = [];
         var created_by  = [];
         var actionId = [];
         var showOutstandingForm = [];
         if(typeof action['name'] !== 'undefined'  && action['name'] !== null &&  action['name'] !== 'null'   ){
            created_by = action['name'];
         }else{
             created_by = action['created_by'];   
         }
         
         actionId = action['action_id'];
         if(typeof action['id'] != 'undefined'){
            actionId = action['id'];
          }
         
         if(typeof action['outcome'] !== 'undefined'  && action['outcome'] !== null &&  action['outcome'] !== 'null'   ){
             outcome = '<span class="actionMsg piller'+actionId+' outcomeMsg'+actionId+' comments'+actionType+'"><strong>Outcome: </strong>'+ action['outcome'] +'</span>'; 
            
         } 
        
         actionTypeName = actionType;
         
         if(action['first_name'] != null){
             contactName = '<span class="label label-primary" style="float: right;" > '+action['first_name']+' '+action['last_name']+'</span>';  
         }
         
         if(action['comments']){
             tagline = '<span class="actionMsg piller'+actionId+' actionMsg'+actionId+  ' comments'+actionType+'"><strong>Comment: </strong>'+action['comments']+contactName+'</span><hr>'+outcome;
         }
         
         if(actionType == 'Deal') actionTypeOverwrite = actionType+'@'+initial_fee+'%';
         
         if(!actions_cancelled){
            badge = '<span class="circle" style="float: left;margin-top: 0px;margin-right: 10px;width: 20px;height: 20px;border-radius: 15px;font-size: 8px;line-height: 20px;text-align: center;font-weight: 700;background-color:'+actionImg[1]+'; color:'+actionImg[2]+';">'+actionImg[0]+'</span>';
         }
        // if(actionType == 'actions_outstanding') alert()
         
         
            if(kp == 'actions_outstanding'  ){
             
                showOutstandingForm = 'showOutstandingForm';
                
            }
         
         header = '<a href="javascript:;" class="text-danger '+showOutstandingForm+' pillerTitle" data-hint="'+actionType+'" data="'+actionId+'">'+(actionTypeOverwrite ? actionTypeOverwrite : actionType)+'  </a> ';
         
        if( actions_cancelled == '' && typeof action['action_id'] != 'undefined' || actions_outstanding == true &&  actions_cancelled == '' && typeof action['action_id'] != 'undefined' ){ 

        var planned_at = '2016-05-20 15:46:00';
        planned_at = planned_at.replace(/-/g, "");
        planned_at = planned_at.replace(/ /g, "T");
        planned_at = planned_at.replace(/:/g, ""); 
        var  pageAddress = window.location.href;

        pageAddress = pageAddress.split('#');

        pageAddress = pageAddress[0];

        var  msg = 'Callback+%7C+Sonovate+Limited';
        var contact =  action['first_name']+ ' '+action['last_name'];
        var email = action['email'];
        var calendarBtnDetail;
        var detail = 'Meeting+with+'+contact+'%0A'+email+'+%0D%0D'+pageAddress; 

            
            
            
            
            
        calendarBtnDetail = '<a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&amp;text='+msg+'&amp;dates='+ planned_at +'/'+ planned_at +'Z&amp;details='+detail+'%0D%0DAny changes made to this event are not updated in Baselist. %0D%23baselist" target="_blank" rel="nofollow" style="margin-top:0; font-size:10px;">Add to Calendar</a>';


        calenderbtn = '<small>'+calendarBtnDetail +' </small><span class="btn btn-default btn-xs label label-success callbackAction hint--top-right"  data-hint="Add Action Outcome" style="font-size:10px; margin:0 0px;" data="'+action['action_id']+'">Add Outcome</span> <span class="btn btn-default btn-xs label label-danger removeOutsandingAction hint--top-right"  data-hint="Cancel Callback Action" data="'+action['action_id']+'" >Remove</span>';


            
          

        if(action['action_id'])                                                                                                                                          
            textbox= '<div class="form-group callbackActionTextBox  box'+action['action_id']+'" style="display:none">'+
                '<form action="Actions/addOutcome" class="outcomeform" data="'+action['action_id']+'" ><textarea class="form-control box'+action['action_id']+'  textarea'+action['action_id']+' " name="outcome" placeholder="Add outcome" rows="2" style="margin-bottom:5px;"></textarea>'+
                '<input type="hidden" name="outcomeActionId" value="'+action['action_id']+'" /><input type="hidden" name="status" id="callBackActionStatus'+action['action_id']+'" value="" /> <input type="submit" class="btn btn-primary btn-block actionSubmit box'+action['action_id']+' submit'+action['action_id']+'" "  style="float:right;" value="Add Outcome"></form><br /></div>';

        //console.log('box_'+action['action_id'])
        overdueStatus = '<span class="label label-danger overdueAction ">Overdue</span>' ;
        var dateCompare = (new Date() - Date.parse(action['planned_at'])) >= 1000 * 60 * 30;
       
        if(dateCompare == false && typeof action['planned_at'] != 'undefined'){
            overdueStatus = '';
        }
        planned_at = formattDate(action['planned_at']);

        }

        if((false))
        outcomeRemove ='<span class=" btn btn-default btn-xs label label-success" style="font-size:10px; margin:0 0px;">Add Outcome</span> <span class="btn btn-default btn-xs label label-danger">Remove</span>';

        if((actions_cancelled)){
            outcomeRemove ='<span class="label label-danger" style="font-size:10px; margin:0 0px;">Cancelled on '+action['cancelled_at']+'</span>';
            badge = '';   
            overdueStatus = '';
        }
        if(comments !=''){
            //console.warn('Play '+comments);
            outcomeRemove ='<span class="label label-info boxAction" style="font-size:10px; margin:0 0px;" data="'+action['id']+'">Add Comment</span>';
            outcomeRemove = '';
            badge = ''; 
 
        }
        if(actionType == 'Callback' && typeof action['action_id'] != 'undefined' || actionType == 'Call' && actions_outstanding == true && typeof action['action_id'] != 'undefined') 
        overdueStatus = overdueStatus ; 
    
        classCompleted = 'outcome'+action['action_id'];

        console.info(parseInt(action['followup_action_id']));
        if(parseInt(action['action_type_id']) == 11  && actionTypeName == 'Callback' && isNaN(action['followup_action_id']) == false &&   action['followup_action_id'] != null){

 

        followupAlert = '<span class="label label-primary follow_up_action_btn hint--top-right" style="float:right;" onClick="scroller('+parseInt(action['followup_action_id'])+')" data="'+action['followup_action_id']+'"  " data-hint="Click to Go To &#10; Follow Up Group">+</span>';

        }
            
           if(kp == 'actions_completed'){
               
               
                if(actionType === 'Callback'){
                      
             
                   var company_id =    $("form input[name='company_id']").val()
                    var user_id =   $("form input[name='user_id']").val()
                    var done =   $("form input[name='done']").val()
                    var campaign_id =   $("form input[name='campaign_id']").val()
                    var class_check =   $("form input[name='class_check']").val()
                    var source_check =    $("form input[name='source_check']").val()
                    var sector_check =    $("form input[name='sector_check']").val()
                    
                    calenderbtn = '<span class="label label-primary callbackAction appendCallbackContacts followupactionBtn'+action['id']+' " style="font-size:10px; margin:0 0px;" data="'+action['id']+'">+ Follow Up Action</span>';
                  
                  textbox= '<div class="form-group callbackActionTextBox callbackContacts box'+action['id']+'" style="display:none">'+
                                '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'+
                                    '<form   action="Actions/addActionsCallback" id="formcallback'+action['id']+'" class="" role="form" data="'+action['action_id']+'" >'+
                                            '<input type="hidden" name="company_id" value="'+company_id+'">'+
                                            '<input type="hidden" name="user_id" value="'+user_id+'" >'+
                                            '<input type="hidden" name="followup_action_id" value="'+action['id']+'" >'+
                                            '<input type="hidden" name="done" value="'+done+'" >'+
                                            '<input type="hidden" name="campaign_id" value="'+campaign_id+'" >'+
                                            '<input type="hidden" name="class_check" value="'+class_check+'" >'+
                                            '<input type="hidden" name="source_check" value="'+source_check+'" >'+
                                            '<input type="hidden" name="sector_check" value="'+sector_check+'" >'+  
                                        '<div class="form-group form-inline actionForm">'+
                                        '<input type="hidden" name="action_type_planned" value="11" >'+
                                            '<input type="text" class="form-control actiondate" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="Follow Up Date">'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            ' <textarea class="form-control box'+action['action_id']+'" name="comment" placeholder="Add outcome"  rows="3" required="required"></textarea>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            ' <input type="submit" class="btn btn-primary btn-block" value="Add Outcome">'+
                                        '</div>'+
                                   '</form>'+
                               '</div>'+
                       '</div>'+
                        '</div>';
               }
             
             kpStr = '<span class="label label-success" style="margin-left:3px;">Completed '+formattDate(action['actioned_at'])+'</span>';
               
              // console.log()
             actionType =kp;
           
               
         }else if(kp == 'actions_cancelled'){
             
             actionType = kp;
             
                  }else if(kp == 'actions_outstanding'){
             
             actionType = kp;         
         }else{
        
         }
         
         
       
         
      if(actionTypeName != 'Pipeline Update')   
            actions  = '<div class="timeline-entry actionId'+actionType+'  '+classCompleted+'"> <div class="timeline-stat"> '+icon+'<div class="timeline-time ">'+formattDate(createdAt, true)+'</div></div><div class="timeline-label"> <div class="mar-no pad-btm"><h4 class="mar-no pad-btm">'+header+deal+badge+'  <span class="label label-warning">'+planned_at+'</span>'+overdueStatus+'<span class="classActions" style="float:right; margin-top:0; margin-left:3px;">'+calenderbtn+outcomeRemove+ kpStr+'</span></h4></div><div class="actionMsgText">'+tagline+'</div>'+textbox+'<div class="mic-info"> Created: '+created_by+' on '+formattDate(createdAt, true)+followupAlert+' </div></div></div>';
         
        if(actionTypeName == 'Pipeline Update' ){
              actions  = '<div class="timeline-entry actionId'+actionType+' '+classCompleted+'" > <div class="timeline-label pipe"> <div class="mar-no pad-btm" ><h4 class="mar-no pad-btm">'+header+' <span class="classActions" style="margin-top:0; margin-left:3px;">'+calenderbtn+outcomeRemove+ kpStr+'</span></h4>'+overdueStatus+'</div><div class="actionMsgText"></div></div></div>';  
         }
         
         
        return actions;
       }
          
    function formattDate(createdAt, showtime = true){
        
        
     
        
        // Split timestamp into [ Y, M, D, h, m, s ]
var t = createdAt.split(/[- :]/);

// Apply each element to the Date function

  var now =  new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
  var dateSuffix = 'th';
var day = now.getDate();
if(day == 1 || day == 21 || day == 31) dateSuffix = 'st';
// Create an array with the current month, day and time
  var date = [now.getDate()+dateSuffix, monthNames[now.getMonth()+ 0] ,  now.getFullYear() ];

// Create an array with the current hour, minute and second date.join("")
  var time = [ now.getHours(), now.getMinutes()];

// Determine AM or PM suffix based on the hour + suffix
  var suffix = ( time[0] < 12 ) ? "am" : "pm";

// Convert hour from military time
  time[0] = ( time[0] < 12 ) ? time[0] : time[0] - 12;

// If hour is 0, set it to 12
  time[0] = time[0] || 12;

// If seconds and minutes are less than 10, add a zero
  for ( var i = 1; i < 3; i++ ) {
    if ( time[i] < 10 ) {
      time[i] = "0" + time[i];
    }
  }

// Return the formatted string
       // console.log(showtime)
        
 return (showtime? time.join(":")+suffix : '') + " " + date.join(" ") + " " ; 
    } 
     
     
 function GetUrlParamID(){
var para = window.location.href.split("id=");
    var param;
        param = para[1];
    if(isInt(param)){
//console.log('jinn'+param[1])
        return param = para[1];
    }else{
        param  = param.split('&');

    if(!isInt(param)){
        param  = param[0].split('#');  

    }


    }
    return param = param[0]; 
}        














/**
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * @author Ariel Flesler
 * @version 2.1.1
 */
;(function(f){"use strict";"function"===typeof define&&define.amd?define(["jquery"],f):"undefined"!==typeof module&&module.exports?module.exports=f(require("jquery")):f(jQuery)})(function($){"use strict";function n(a){return!a.nodeName||-1!==$.inArray(a.nodeName.toLowerCase(),["iframe","#document","html","body"])}function h(a){return $.isFunction(a)||$.isPlainObject(a)?a:{top:a,left:a}}var p=$.scrollTo=function(a,d,b){return $(window).scrollTo(a,d,b)};p.defaults={axis:"xy",duration:0,limit:!0};$.fn.scrollTo=function(a,d,b){"object"=== typeof d&&(b=d,d=0);"function"===typeof b&&(b={onAfter:b});"max"===a&&(a=9E9);b=$.extend({},p.defaults,b);d=d||b.duration;var u=b.queue&&1<b.axis.length;u&&(d/=2);b.offset=h(b.offset);b.over=h(b.over);return this.each(function(){function k(a){var k=$.extend({},b,{queue:!0,duration:d,complete:a&&function(){a.call(q,e,b)}});r.animate(f,k)}if(null!==a){var l=n(this),q=l?this.contentWindow||window:this,r=$(q),e=a,f={},t;switch(typeof e){case "number":case "string":if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)){e= h(e);break}e=l?$(e):$(e,q);if(!e.length)return;case "object":if(e.is||e.style)t=(e=$(e)).offset()}var v=$.isFunction(b.offset)&&b.offset(q,e)||b.offset;$.each(b.axis.split(""),function(a,c){var d="x"===c?"Left":"Top",m=d.toLowerCase(),g="scroll"+d,h=r[g](),n=p.max(q,c);t?(f[g]=t[m]+(l?0:h-r.offset()[m]),b.margin&&(f[g]-=parseInt(e.css("margin"+d),10)||0,f[g]-=parseInt(e.css("border"+d+"Width"),10)||0),f[g]+=v[m]||0,b.over[m]&&(f[g]+=e["x"===c?"width":"height"]()*b.over[m])):(d=e[m],f[g]=d.slice&& "%"===d.slice(-1)?parseFloat(d)/100*n:d);b.limit&&/^\d+$/.test(f[g])&&(f[g]=0>=f[g]?0:Math.min(f[g],n));!a&&1<b.axis.length&&(h===f[g]?f={}:u&&(k(b.onAfterFirst),f={}))});k(b.onAfter)}})};p.max=function(a,d){var b="x"===d?"Width":"Height",h="scroll"+b;if(!n(a))return a[h]-$(a)[b.toLowerCase()]();var b="client"+b,k=a.ownerDocument||a.document,l=k.documentElement,k=k.body;return Math.max(l[h],k[h])-Math.min(l[b],k[b])};$.Tween.propHooks.scrollLeft=$.Tween.propHooks.scrollTop={get:function(a){return $(a.elem)[a.prop]()}, set:function(a){var d=this.get(a);if(a.options.interrupt&&a._last&&a._last!==d)return $(a.elem).stop();var b=Math.round(a.now);d!==b&&($(a.elem)[a.prop](b),a._last=this.get(a))}};return p});