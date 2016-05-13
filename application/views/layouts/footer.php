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
    <!-- #wrapper -->
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
<script type="text/javascript" src="<?php echo asset_url();?>js/jquery.sticky.js"></script>
 <script src="<?php echo asset_url();?>js/bootbox.js"></script>

 
 
    <script src="<?php echo asset_url();?>js/fe_tagging.js"></script>
    
 


 
<script type="text/javascript">
    
$(document).ready(function(){
    
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
    


$('.timeline-header .showText').click(function(){
var activeMenu =  $('.activeMenu').attr('data');
   // alert(activeMenu);
        var status =  $('.actionMsg').css('display');
        
        //alert(status)
        if(status == 'inline'){
            $('.actionMsg').hide();  
              $('.showText').text('Show/Comment');

        }else{
        $('.actionMsg').show();
             $('.showText').text('Hide/Comment');
        }
    })
    $('.showCommentAddBtn').hide();
    $('.showText').hide();
    
    $('.showCommentAddForm').hide();
    
})

</script>



<!--EMAIL DUPLICATE CHECK-->
 <script type="text/javascript">
    $(document).ready(function() {
            $('#message').hide();
        /// make loader hidden in start
        $("#email").bind('keyup paste', function() {
        var email_val = $("#email").val();
        var filter = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9]+.[a-z]/;
        if(filter.test(email_val)){
            // show loader
            $.post("<?php echo site_url()?>contacts/email_check", {
                email: email_val
            }, function(response){
        //if (response.message==null) {
            //$(".addcontact").prop("disabled", false);
            //} else {
            // $(".addcontact").prop("disabled", true);
            //}
                $('#message').html('').html(response.message).show().delay(4000).fadeOut();
            });
            return false;

        }
           
            
            });
        $('.showCommentAddBtn').on('click', function(){
            var blockStatus  = $('.showCommentAddForm').css('display');
             
            if(blockStatus === "block"){
                $('.showCommentAddForm').toggle(false);
       // console.log('true')
            }else{
                //console.log('flase')
                 $('.showCommentAddForm').toggle(true);
            }
        })
        
    
        $('#actionSendComment').submit(function(e){

            e.preventDefault();
            
           var param =  $('#actionSendComment').serialize();
          
                $.ajax({
                  type: "POST",
                    data: param,
                      dataType: "json",
                  url: "../Actions/addActionsComment",
                  success: function(data) {
                      console.log(data);
                      
                 $('.timeline_inner').html('');
                      $('#commentcontent').val('');
                      
                     getActionData('comment',true);
                      $('.actionAll').trigger('click');
                      
                      
                       $('.showCommentAddForm').hide();
                      
                      
                      
                      
        //$('.actionIdComment').append('<div class="timeline-label"> <div class="mar-no pad-btm"><h4 class="mar-no pad-btm"><a href="#" class="text-danger">Comment  </a>   </h4><span class="label label-warning"></span><div class="classActions" style="float:right; margin-top:0; margin-left:3px;"></div></div><div class="actionMsgText"><span class="actionMsg commentsComment" style="display: none;">Demand for contract and interim senior level positions in London is at a record high, according to new research from UK</span></div><div class="mic-info"> Created By: Richard Lester on 10:23am 6th May 2016  </div></div>')              
                      
                  }
                  });
              
            $('.timeline-entry').show();
            
        })
       var scope = getActionData();
    }); 
     
    function add_outcome(){
        
        
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
                     //alert(data);
                        
                        
                          //$('.outcome'+ outcomeId).remove();
                         //$('.timeline-entry').show();
                      
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
                $.ajax({
                  type: "POST",
                    data: param,
                      dataType: "json",
                  url: "../companies/getCompletedActions",
                  success: function(data) {
                      
                     // console.warn(data[0]['action_type_id'])
                  var obj= data     
                      var i = 1 ;
                        $.each( obj, function( k, action ) {
             //console.debug(val[0]['action_types_array']);
               if(i===1){
                   
                     $('.outcomeMsg'+action['follow_up_action_id']).append('<br /><hr />')
                   
               }
                     console.info(action['follow_up_action_id'])       
                    if(action['action_type_id'] == 11  && action['follow_up_action_id'] != null ){
                     
                   followUpCompleteddate = '<span class="label label-warning" style="margin-right: 10px;">Follow up planned : '+ formattDate(action['planned_at'])+' </span>';
                        
                        
                        console.warn('plannnnned'+followUpCompleteddate)
                        
                    }
                            
                            
                            
                             if(action['action_type_id'] == 11  && action['follow_up_action_id'] != null && action['planned_at'] == null && typeof action['planned_at'] != 'undefined' && typeof action['planned_at'] != null){
                                followup = '<span class="label label-warning" style="margin-right: 10px;"> Follow Up Action:  '+formattDate(action['planned_at'])+' </span>';
                            }
                            
                              if(action['action_type_id'] == 11  && action['follow_up_action_id'] != null && typeof action['planned_at'] != 'undefined' && typeof action['planned_at'] != null){
                                  if(action['first_name'] != null){
                                      
                                     contactDetails = ' <span class="label label-primary"style="float: right;"> '+action['first_name']+' '+action['last_name']+' </span><br>';
                                      
                                  }
                                 
                              }
                            
                            
                             if(action['action_type_id'] == 11 ){
                                 
                                 
                                 
                                  overdueStatus = '<span class="label label-danger">Overdue</span>' ;
var dateCompare = (new Date() - Date.parse(action['planned_at'])) >= 1000 * 60 * 30;
if(dateCompare == false && typeof action['planned_at'] != 'undefined'){
    overdueStatus = '';
   // alert(action['planned_at'])
}
                                 
                                 
                                 
                                 if(typeof action['outcome'] == 'undefined'  || action['outcome'] == null    ){
                                     
                                     actionOutcome = ''
                                 }else if(typeof action['outcome'] == 'undefined'  || action['outcome'] == null    ){
                                     
                                     
                                 }else{   actionOutcome = '<strong>Outcome: </strong>'+action['outcome'];
                                     
                                 }
                                 
                                 
                                 
    $('.outcomeMsg'+action['follow_up_action_id']).append('<div class="followcont" style="background: #fff; padding: 10px; margin-bottom: 5px; margin-top:5px;">'+followup+ ' ' +followUpCompleteddate+contactDetails+
                                                                                        ' <span class="comments"><br><strong>Action: </strong>'+action['comments']+'<br>'+actionOutcome+
                                                                                        '</span><hr /></div>');  
                            
                        }
                            followUpCompleteddate = '';
                 i++;


            })
     
        
    } 
    
    })
       
                
    $('.callbackActionTextBox form').submit(function(e){
      //  alert($(this).serialize())
            e.preventDefault();
    var url = $(this).attr('action');
           var outcomeId = $(this).attr('data');
        
             // alert(outcomeId) 
            //JS JASON WITH POST PARAMETER
            var para = $(this).serialize();
            $.ajax({
            type: "POST",
            data: para,
            dataType: "json",
            url: "../"+url,
            success: function(data) {
console.log(data)
            //alert($(this).serialize())

getActionData();
                
                var submittedFormId = data.follow_up_action_id;
                
                 $('.box'+submittedFormId+ ' .actionContact').val('')
                 $('.box'+submittedFormId+ '  .planned_at').val('');
                 $('.box'+submittedFormId+ ' textarea').val('');
                 
                  
                 $('.outcome'+ outcomeId).hide();
                
                // getActionData('comment',true);
                // $('.followupactionBtn'+submittedFormId).trigger('click'); 
                
           
            }
            });

        })

    }
     
     function getActionData(scope = false){
        
         $.ajax({
    type: "GET",
    url: "<?php echo base_url(); ?>companies/getAction/",
    success: function(data) {
        $('.timeline_inner').html('');
    // $('.timeline-entry').hide();
       
       
       $('.timeline_inner').append(writeactions(data)); 
          
        //ADD ALL AFTER LOAD BINGING HERE
        callbackActionTextBox();
        getemailengagement();
        bindAddCallBackToCompletedAction();
        add_outcome();
        bindPillerTitles();
        removeOutsandingAction()
         $('.follow-up-date').datepicker();
        
       var visibility;
    
         //$('.timeline-entry').hide()
        if(visibility === true){
            
            //$('.timeline-entry').show();
        }else{
            //$('.timeline-entry').hide();  
        }
        
             $('.form .actionContact').clone().prependTo('.actionForm');
    } //end success
    
  
       
});   
         
     $('.timeline-entry').show();
         
         
     }
     
     function bindPillerTitles(){
         
         $('.pillerTitle').click(function(){
 var dat = $(this).attr('data');
           
           //$('.actionMsg'+dat).toggle(true);
            //$('.outcomeMsg'+dat).toggle(true);
           
             var blockStatus  = $('.piller'+dat).css('display');
        
            // console.log('=========='+blockStatus+'  ==== '+dat);
            if(blockStatus === "inline"){
                $('.piller'+dat).toggle(false);
                $('.box'+dat).toggle(false);
              
       // console.log('true')
            }else{
                //console.log('flase')
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
                       // $('.callbackContacts .actionContact').remove()
               // console.log('true')
                    }else{
                        //console.log('flase')
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
    url: "<?php echo base_url(); ?>companies/autopilotActions/",
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
              contactName = '<div class="label label-primary" style="float:right; margin-top:0; ">'+val.first_name+ ' '+ val.last_name+'</div>';
                }
        
        if( val.campaign !== null ){
            if(val.action != '3'){
                i++;
                
                
              
                
                /*
                $( '<li class="list-group-item"><div class="row"><div class="col-xs-6 col-md-7"><h4 style="margin:0;">'+val.campaign_name+'<div class="mic-info">'+val.date+ ' by '+val.email+
                '</div></h4></div><!--END COL-MD-4--><div class="col-xs-6 col-md-5" style="text-align:right;"><span class="label label-primary" style="font-size:11px;  ">'+val.first_name+ ' '+ val.last_name+
                '</span> '+action+' </div></div></li>' ).prependTo('#marketing_action ul'); */
        $('.timeline_inner').append('<div class="timeline-entry   actionIdactions_marketing" style="dislay:none;"> <div class="timeline-stat"> <div class="timeline-icon label-danger " style="color: white;"><i class="fa fa-comment fa-lg"></i></div><div class="timeline-time ">'+val.date+ 
                                            ' </div></div><div class="timeline-label"> <div class="mar-no pad-btm"><h4 class="mar-no pad-btm"><a href="javascript:;" class="text-danger"> '+val.campaign_name+' <span class"eeprefix">(Marketing)</span> </a>   </h4>'+
                                            '<span class="label label-warning">'+val.date+'</span></div><div style="float:right; margin-top:-4px; margin-left:3px;">'+action+
                                            '</div>'+contactName+'<div class="actionMsgText"><span class="actionMsg commentsComment">what a laugh</span><hr></div><div> <div class="mic-info"> by '+val.email+'</div></div></div>')
                
                
            }
        }
            //$('#sidebar').hide();
        
      //  show();
        //$(window).scroll(show);
    });
    $('.marketingAcitonCtn').text(parseInt($('.marketingAcitonCtn').text()) + i);
    $(items.join( "" )).prependTo('#marketing_action ul');
    //if(i) $('#outstanding h4,.actionMsg h4').hide();
    }
    });  
         
         
         
     }
     
     
     
     
     
     
     
     function writeactions(data, scope = false){
         
    //dealTemplate()
              var useractionsections;
      var action_types_array;
        var  action_types_list;
        var actionType;
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
        
        stickMenu()
        
      
        
        var obj= data //$.parseJSON(data)
   
        
   
       
       // console.warn(obj)
        
      
            $.each( obj, function( k, val ) {
             //console.debug(val[0]['action_types_array']);
                action_types_array  =   val[0]['action_types_array']
               if(typeof action_types_array !== 'undefined'){ 
                   action_types_list  = action_types_array; 
                   //console.log(pipeline);
                }   
            })
          
            
              // console.warn(obj)
            
             //  callbackActionTextBox();
        //console.debug(action_types_list[4]); 
            jQuery.each( obj, function( k, val ) {
                    useractionsections  =  val[0];
                 if( typeof useractionsections === "object" && !Array.isArray(useractionsections) && useractionsections !== null){
                   jQuery.each( useractionsections, function( kp, valp ) {
                    //getAction
                        
                    
                       jQuery.each( valp, function( kpt, action ) {  
                          
                           
                  // console.warn(valpt);
                  //console.log('---Key----- '+kp+' -- Value '+valp); 
                     
                    actionType = action_types_list[action['action_type_id']];
                         //console.log(kp)  
                     switch (kp) {
                    case 'actions':
                        //console.info('actions-- '+actionType + action['image']);
                    // console.error(obj[0]);
                    break;
                    case 'actions_outstanding':
                        //console.info('Outstanding-- '+actionType+ action['image']);
                    if(action['initial_rate']){
                        
}                    initial_fee = (parseFloat(action['initial_rate']*100).toFixed(1));
                           // console.log(action['initial_rate'])
                            
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
                        console.info('comments-- '+actionType+ action['comments']);     
                            comments = action['comments'];    
                    break;
                    }
              
                if (typeof action['image'] !== 'undefined' || actions_cancelled !='' || comments !=''){   
                        
                          if(pipeline != 'Pipeline changed to Customer' ){
                        
                        pipeline = false;
                    }
                
                    icon =  getIcon(actionType);
                    
                    
             actionresults  =    actionProcessor(actionType ,action,icon,initial_fee,pipeline,actions_outstanding,actions_cancelled,comments,kp);
                 
actionresult.push(actionresults)

                      // $('.timeline_inner').append(actionresults);
                    
                    actions_outstanding = '';
                    //actions_cancelled = '';
                }
                      
            // $('.actionMsg'+action['follow_up_action_id']).append('<span class="actionMsg'+actionType+'  comments">'+action['comments']+'</span>');
         // $('.actionMsg50159').append('<hr /><span class="actionMsg  commentsCallback" style="display:inline;">demo</span>');
              })
                   
           
        })
             if(scope)
                        $('.'+scope).trigger('click');
                  
                    }
             
     });  //loop end
       actionresult = actionresult.join("");
         
       
           return actionresult;         
         
        
         
         
    
         //actionresults =  actionresult.join();
         //
       
            
    //console.log(data);
 
        
        
         
        // console.log('kjsalkfkasdf'actionresult);
        
         
       
   //$('.timeline_inner').append(actionresult);         
         
         
       //alert();
         
     }
     
     
     
     function stickMenu(){
      
            $('.sticky li a').click(function(){
                    
                //callbackActionTextBox();
                  $('.showText').show(); 
                $('.sticky a').removeClass('activeMenu');
                $('.actionMsg').hide();
                  $('.showCommentAddForm').hide();
                $(".callbackActionTextBox").hide();
                
                // $('.callbackContacts .actionContact').remove()
                
                
                $('html,body').animate({
            scrollTop: $("#stickMenu").offset().top},
            'slow');
                   $('.timeline-entry').hide()
                   var action =  $(this).attr('data');  
                   $('.actionId'+action).show();
                        $('.pipeline').hide();     
                  
                //alert(action)

                                var acctionqty  = '<span class="circle" style="margin-top: 0px;margin-left: 10px;width: 40px;height: 64px;border-radius: 15px;font-size: 13px;/* line-height: 20px; */text-align: center;font-weight: 700;/* background-color:#999; */color:#ffffff;">'+$('.actionId'+action).length+'</span>'
               
                                
                    if(action == 'actions_marketing') action = 'Marketing';   
                if(action == 'actions_cancelled') action = 'Cancelled';  
                if(action == 'actions_outstanding') action = 'Outstanding';  
                  if(action == 'actions_completed') action = 'Completed';  
                     $('.actiontitle').html(action+ acctionqty);
                                
                
                
                $('.showText').html('Show/Text');

                $(this).addClass('activeMenu');

                 if(action  == 'All'){
                                 $('.showText').hide();    
                                        $('.timeline-entry').show();
                                        $('.actiontitle').html('History');
                                         $('.pipeline').show();
                                   }else if(action == 'Marketing'){
                                        $('.showText').hide();
                    
                                        }else{
                                         $('.showText').show(); 
                                   } 


                              if(action  == 'Comment'){  
                                      $('.showCommentAddBtn').show();
                              }else{
                                 $('.showCommentAddBtn').hide();
                              }

              if(action == 'actions_marketing'){
                      $('.showText').hide();
                    
                    
                } 
                
              
if(action  == 'actions_marketing' ){
                    
                
                    
}
              
            })
            
           
     }
     
     
    
     
     function getIcon(actionType){
         
      
         
         var icon;
              switch (actionType){
                    case 'Email':
                       // console.info('actions-- '+actionType + action['image']);
                           icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                        
                    break;
                    case 'Callback':case 'Call':
                         icon = '<div class="timeline-icon label-danger "style="color: white;"><i class="fa fa-phone fa-lg"></i></div>';
                        
                    break;

                    case 'Pipeline Update':
                      
                    break;
                    case 'actions_cancelled':
                   
                   //console.warn('final '+actions_cancelled);  
                        //console.info('actions_cancelled-- '+actionType+ action['image']);
                    break;
                    case 'comments':
                        //console.info('comments-- '+actionType+ action['image']);
                     icon = '<div class="timeline-icon label-danger "style="color: white;"><i class="fa fa-comment fa-lg"></i></div>';
                    break;
                       case 'Deal':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>'  ;
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
            
            
                  console.info('comments222222-- '+ comments);
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
     
           function callbackActionTextBox(){
       $('.callbackAction').on('click', function(){
           
     
            var dat = $(this).attr('data');
           
           
            $('.textarea'+dat).attr('placeholder', 'Add outcome');
           
           
              if($('#callBackActionStatus'+dat).val() == 'cancelled'){
                  
                 $('#callBackActionStatus'+dat).val('completed'); 
              }else{ 
  $('#callBackActionStatus'+dat).val('completed');
           
           
           $('.actionMsg'+dat).toggle(true);
            $('.outcomeMsg'+dat).toggle(true);
           
            $('#callBackActionStatus'+dat).val('completed');
           
             var blockStatus  = $('.box'+dat).css('display');
        
            if(blockStatus === "block"){
                $('.box'+dat).toggle(false);
                
                   $('.actionMsg'+dat).toggle(false);
            $('.outcomeMsg'+dat).toggle(false);
                 $('#callBackActionStatus'+dat).val('');
               // $('.callbackContacts .actionContact').remove()
       // console.log('true')
            }else{
                //console.log('flase')
                 $('.box'+dat).toggle(true);
                
            }
                  
        }
        })
       
       
       
       
        
 
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
//console.warn(initial_fee);
         var kpStr = [];
         var outcome = [];
         var contactName = [];
         var actionTypeName= [];
         var followupAlert = [];
         var created_by  = [];
         var actionId = [];
         
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
             
             outcome = '<span class="actionMsg piller'+actionId+' outcomeMsg'+actionId+' comments'+actionType+'"><strong>Initial Outcome: </strong>'+ action['outcome'] +'</span>'; 
            
         } 
         
        
         
         actionTypeName = actionType;
         if(action['first_name'] != null){
             
             contactName = '<span class="label label-primary" style="float: right;"> '+action['first_name']+' '+action['last_name']+'</span>';
             
             
         }
         if(action['comments']){
    tagline = '<span class="actionMsg piller'+actionId+' actionMsg'+actionId+  ' comments'+actionType+'"><strong>Initial Comment: </strong>'+action['comments']+contactName+'</span><hr>'+outcome;
         }
         if(actionType == 'Deal') actionTypeOverwrite = actionType+'@'+initial_fee+'%';
         
         if(!actions_cancelled){
         badge = '<span class="circle" style="float: left;margin-top: 0px;margin-right: 10px;width: 20px;height: 20px;border-radius: 15px;font-size: 8px;line-height: 20px;text-align: center;font-weight: 700;background-color:'+actionImg[1]+'; color:'+actionImg[2]+';">'+actionImg[0]+'</span>';
         }
        // if(actionType == 'actions_outstanding') alert()
         header = '<a href="javascript:;" class="text-danger pillerTitle" data="'+actionId+'">'+(actionTypeOverwrite ? actionTypeOverwrite : actionType)+'  </a> ';
//if(actionType == 'Email'  ||  actionType == 'Demo'  && typeof action['outcome'] != 'undefined'   ) {
    
 
//}
         
         
         
         
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

            
            calenderbtn = '<small>'+calendarBtnDetail +' </small><span class="label label-success callbackAction" style="font-size:10px; margin:0 0px;" data="'+action['action_id']+'">Add Outcome</span> <span class="label label-danger removeOutsandingAction" data="'+action['action_id']+'" >Remove</span>';
                                  
                             
    
           if(action['action_id'])                                                                                                                                          
  textbox= '<div class="form-group callbackActionTextBox box'+action['action_id']+'" style="display:none">'+
           '<form action="Actions/addOutcome" class="outcomeform" data="'+action['action_id']+'" ><textarea class="form-control box'+action['action_id']+'  textarea'+action['action_id']+' " name="outcome" placeholder="Add outcome" rows="2" style="margin-bottom:5px;"></textarea>'+
           '<input type="hidden" name="outcomeActionId" value="'+action['action_id']+'" /><input type="hidden" name="status" id="callBackActionStatus'+action['action_id']+'" value="" /> <input type="submit" class="btn btn-primary btn-block actionSubmit box'+action['action_id']+' submit'+action['action_id']+'" "  style="float:right;" value="Add Outcome"></form><br /></div>';

//console.log('box_'+action['action_id'])
 overdueStatus = '<span class="label label-danger">Overdue</span>' ;
var dateCompare = (new Date() - Date.parse(action['planned_at'])) >= 1000 * 60 * 30;
if(dateCompare == false && typeof action['planned_at'] != 'undefined'){
    overdueStatus = '';
   // alert(action['planned_at'])
}
planned_at = formattDate(action['planned_at']);
                                                                                             
       }
         
         if((false))
         outcomeRemove ='<span class="label label-success" style="font-size:10px; margin:0 0px;">Add Outcome</span> <span class="label label-danger">Remove</span>';
         
         
         if((actions_cancelled)) {
         outcomeRemove ='<span class="label label-danger" style="font-size:10px; margin:0 0px;">Cancelled on '+action['cancelled_at']+'</span>';
            
          badge = '';   
             overdueStatus = '';
         }
         
         
          if(comments !=''){
             //console.warn('Play '+comments);
         outcomeRemove ='<span class="label label-info boxAction" style="font-size:10px; margin:0 0px;" data="'+action['id']+'">Add Comment</span>';
                outcomeRemove = '';
                badge = ''; 
           
               icon = '<div class="timeline-icon label-danger "style="color: white;"><i class="fa fa-comment fa-lg"></i></div>';
              
              
              
               //textbox= '<div class="form-group boxcom commentActionTextBox boxcom'+action['id']+'" style="display:none">'+'<div class="form-group boxcom boxActionTextBox boxcom'+action['id']+'" style="display:none">'+'<input type="date" class="form-control boxcom follow-up-date boxcom'+action['id']+'" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="" style="width:30%; float:left; margin-bottom:10px;">'+'<textarea class="form-control boxcom boxcom'+action['id']+'" name="outcome" placeholder="Add callback action" rows="3" style="margin-bottom:5px;"></textarea>'+'<button class="btn btn-primary boxcom btn-block boxcom'+action['id']+'" style="float:right;">Add Comment</button><br /></div> </div>';
              
        //action['id'] //ok 50127
          }
         
         
         
       
         /* $('.timeline_inner').append(header+'<div class="mar-no pad-btm"> '+deal+' <span  class="label label-success" style="font-size:10px; margin-left:10px;">Completed on Tuesday 13th April 2016 @ 17:06 </span> </div><div class="mic-info"> Created By: Richard Lester on Wednesday 13th April 16 @ 16:43 </div>    <div style="float:right; margin-top:0; margin-left:3px;"><small><a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&amp;text=Callback+%7C+Sonovate+Limited&amp;dates=20160429T170600/20160429T170600Z&amp;details=Meeting+with+Matt+Boyle%0Amboyle%40sonovate.com+%0D%0Dhttp%3A%2F%2Fbaselist.herokuapp.com%2Fcompanies%2Fcompany%3Fid%3D154537%0D%0DAny changes made to this event are not updated in Baselist. %0D%23baselist" target="_blank" rel="nofollow" style="margin-top:0; font-size:10px;">Add to Calendar</a></small><span class="label label-success" style="font-size:10px; margin:0 0px;">Add Outcome</span><span class="label label-danger">Remove</span></div></div></div>') */
       
           
        
        if(actionType == 'Callback' && typeof action['action_id'] != 'undefined' || actionType == 'Call' && actions_outstanding == true && typeof action['action_id'] != 'undefined') 
           overdueStatus = overdueStatus ; 
         //console.log(action['first_name']);
         
         
         classCompleted = 'outcome'+action['action_id'];
         
         
         if(action['action_type_id'] == 11  && actionTypeName == 'Callback' && action['follow_up_action_id'] !== null){
             
             //console.log('This is an asscociated item '+action['comments'] );
             //console.log('Class .actionMsg'+action['follow_up_action_id']);
            // $('.actionMsg'+action['follow_up_action_id']).append('<span class="actionMsg'+actionType+'  comments">'+action['comments']+'</span>');
           //<strong>Outcome: </strong> $('.actionMsg50159').append('<hr /><span class="actionMsg actionMsg50166 commentsDemo" style="display: inline;">demo</span>');
             
     followupAlert = '<span class="label label-primary" style="float:right;" title="Follow Up Action">+</span>';
             
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
                                            '<input type="hidden" name="follow_up_action_id" value="'+action['id']+'" >'+
                                            '<input type="hidden" name="done" value="'+done+'" >'+
                                            '<input type="hidden" name="campaign_id" value="'+campaign_id+'" >'+
                                            '<input type="hidden" name="class_check" value="'+class_check+'" >'+
                                            '<input type="hidden" name="source_check" value="'+source_check+'" >'+
                                            '<input type="hidden" name="sector_check" value="'+sector_check+'" >'+  
                                        '<div class="form-group form-inline actionForm">'+
                                        '<input type="hidden" name="action_type_planned" value="11" >'+
                                            '<input type="text" class="form-control follow-up-date planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="Follow Up Date">'+
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
             
             kpStr = '<span class="label label-success" style="margin-left:3px;">Action Completed at '+formattDate(action['actioned_at'])+'</span>';
               
              // console.log()
             actionType =kp;
           
               
         }else if(kp == 'actions_cancelled'){
             
             actionType = kp;
             
             
                  }else if(kp == 'actions_outstanding'){
             
             actionType = kp;
                      
                      
         }else{
             
             
         }
         
         
      
         console.log('Actio logggggg '+actionType +  ' ' + actionTypeName);
         
      if(actionTypeName != 'Pipeline Update')   
  actions  = '<div class="timeline-entry actionId'+actionType+'  '+classCompleted+'"> <div class="timeline-stat"> '+icon+'<div class="timeline-time ">'+formattDate(createdAt, true)+'</div></div><div class="timeline-label"> <div class="mar-no pad-btm"><h4 class="mar-no pad-btm">'+header+deal+badge+'  <span class="label label-warning">'+planned_at+'</span>'+overdueStatus+'<span class="classActions" style="float:right; margin-top:0; margin-left:3px;">'+calenderbtn+outcomeRemove+ kpStr+'</span></h4></div><div class="actionMsgText">'+tagline+'</div>'+textbox+'<div class="mic-info"> Created By: '+created_by+' on '+formattDate(createdAt, true)+followupAlert+' </div></div></div>';
         
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
     
     
     
     
     
     
     
     
     

        
 
</script>

<!--AUTO COMPLETE-->


<style>
    .toLowerCase{ text-transform:capitalize;}
</style>

<script type="text/javascript">
// AJAX SEARCH AUTOCOMPlETE
function ajaxSearch() {
    var input_data = $('#agency_name').val();
    
   input_data =  input_data.replace("'", "&#39;");
    //input_data =  input_data.replace("&", "&amp;");
    
    if (input_data.length < 1) {
$('#suggestions').hide();
$('#agency_name').removeClass('autocomplete-live');
    } else {
        input_data =  input_data.replace("\'", "");
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
              input_data =  input_data.replace("\'", "");
         getCompany(input_data);     
       }
    }
});
    }
}
function getCompany(input_data){
    
     input_data =  input_data.replace(" ", "");
    
     input_data = input_data.replace('\'', ''); 
    input_data = input_data.replace('&#39;', ''); 
    
    
    $.ajax({type:"GET",url:"<?php echo base_url(); ?>companies/getCompanyHouseDetails/"+input_data,success:function(data){var obj=$.parseJSON(data);var i=0;var text="";var preview=[];var out=[];while(obj.items[i]){if(obj.items[i].company_status=='active'){out+='<a href="javascript:;" company_number="'+obj.items[i].company_number+'" title="'+obj.items[i].title+'" postal_code="'+obj.items[i].address.postal_code+'" address_line_1="'+obj.items[i].address.address_line_1+'" locality="'+obj.items[i].address.locality+'" snippet="'+obj.items[i].snippet+'" company_type="'+obj.items[i].company_type+'" company_status="'+obj.items[i].company_status+'" description="'+obj.items[i].description+'" date_of_creation="'+obj.items[i].date_of_creation+'" class="companyHouseRegNum"><li class="autocomplete-item autocomplete-company toLowerCase ch_drop_title"><strong>'+ucwords(obj.items[i].title)+'</strong><br><small>Add to Baselist</small></li></a>';preview+='<a target="_blank" href="https://beta.companieshouse.gov.uk/company/'+obj.items[i].company_number+'"><li class="autocomplete-item autocomplete-contact preview_slogan" > View at Companies House   <i class="fa fa-external-link"></i><br><small>&nbsp;</small></li></a>';}
i++;if(i===7){break;}}
$('#suggestions').show();$('#autoSuggestionsList').addClass('auto_list');$('#autoSuggestionsList').html('<div class="autocomplete-full-holder"><div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 clearfix no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading"><i class="fa fa-caret-square-o-down"></i> Companies</li>'+out+'</ul></div><div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading autocomplete-no-results"><i class="fa fa-times"></i> Preview</li>'+preview+'</ul></div></div>');if(i==0){$('#autoSuggestionsList').html('<div class="autocomplete-full-holder"><div class="col-xs-12 col-sm-12 col-md-5 col-lg-12 no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading autocomplete-no-results"><i class="fa fa-times"></i> No records found</li></ul></div></div>');}
$('#agency_name').addClass('autocomplete-live');saveCompanyHandler();}});}
function saveCompanyHandler(){$('.ch_drop_title').css('background','#7fe3d5');$('.ch_drop_title').css('color','#2d2d2d');$('.ch_drop_title strong').css('font-weight','300');$('.companyHouseRegNum').click(function(){var mode="create";var user_id=<?php echo $current_user['id'];?>;var data={"registration":$(this).attr('company_number'),"date_of_creation":$(this).attr('date_of_creation'),"name":$(this).attr('title'),"postal_code":$(this).attr('postal_code'),"address":$(this).attr('snippet'),"user_id":user_id,"company_status":$(this).attr('company_status'),"address_line_1":$(this).attr('address_line_1'),"company_type":$(this).attr('company_type'),"description":$(this).attr('description'),"date_of_creation":$(this).attr('date_of_creation'),};bootbox.confirm("Are you sure want to add this company?",function(result){if(result){data=$.param(data);$.ajax({type:"POST",dataType:"json",url:"<?php echo base_url(); ?>companies/getCompany",data:data,success:function(data){if(data.status==200){window.location.href="<?php echo base_url(); ?>companies/company?id="+data.message;}}});}else{}})});};
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
$('.planned_at').datetimepicker();
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
 <?php //if(ENVIRONMENT !== 'production'): ?>
  <?php if($current_user['permission'] == 'admin'): ?>
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

    $('.nav-tabs a').click(function (e) {
    // No e.preventDefault() here
    $(this).tab('show');
});
</script>
<script type="text/javascript">
        $(document).ready(function() {
            $('.tr-actions').click(function(){
$('.c-a-m').trigger('click');
});
            // Javascript to enable link to tab
var hash = document.location.hash;
var prefix = "tab_";
if (hash) {
    $('.nav-tabs [href='+hash.replace(prefix,"")+']').tab('show');
} 
// Change hash for page-reload
$('.nav-tabs ').on('shown.bs.tab', function (e) {
    //window.location.hash = e.target.hash.replace("#", "#" + prefix);
});
      });    
    function ga(){}
        </script>

    <script type="text/javascript">//<![CDATA[
$(window).load(function(){
$(document).ready(function(){
   
});
});//]]> 

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