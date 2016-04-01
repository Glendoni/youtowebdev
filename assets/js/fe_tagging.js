$(document).ready(function(){
    
     gettags();
    $('.nav-tabs').click(function(){
        
        $('.active').removeClass('activein');
        $('.tadefault').hide()
        $('.main .list-group-item').show()
       $('.sub .list-group-item').hide()  
    })
  $('#tagCatList').html('');
    
    
    if((/companies/.test(window.location.href))) {
             $.ajax({
        type: "GET",
            dataType: "json",
        url: 'fe_read_cat',
        success: function(data) {
            var action;
            var items = [];
             var idfk;
            var sub;
            var editBtn;
            var main;
            var category =[] ;
            var sub_cat = [];
            var parcat;
              var parcatId = [];
            var el;
              var elId;
            var valst;
             var i=1;
            $.each( data, function( key, val ) {
                if (val['par_name']  ){
                // category.push();  
                el = val['par_name'];
                     elId = val['cat_id'];
                //console.log(val['cat_id'])
                    if($.inArray(el, category) === -1) category.push(el);
                    if($.inArray(elId, parcatId) === -1) parcatId.push(elId);
                }
                //parcat =  val['parent_cat_name']; // val['par_name']
            })
                 $.each( category, function( key, vals ) {

                    $('.cat'+(key+1)).text(vals).css('text-transform','uppercase');
valst = vals.replace(' ', '');
                    $('#cat'+(key+1)+ ' .main').addClass('main_'+valst);
                    $('#cat'+(key+1)+ ' .sub').addClass('sub_'+valst);
                    $('#cat'+(key+1)+ ' .item').addClass('item_'+valst);


                   // console.warn(key['name']);
                    i++;
                 })
             populate()  
            
        } 
    })    
    }
})

function populate(){
    
             $.ajax({
        type: "GET",
            dataType: "json",
        url: 'fe_read_tag',
        success: function(data) {
            var action;
            var items = [];
             var idfk;
            var sub;
            var editBtn;
            var main;
            
            var sort; 
            var category =[] ;
            var sub_cat = [];
            var parcat;
              var parcatId = [];
            var el;
              var elId;
             var i=1;
            var vale;
           var italicFont;
             var subActive; 
             var parentcatname;
            var myParam = window.location.href.split("id=");
            $.each( data, function( key, val ) {
                
                    el = val['sub_cat_name']+'_'+val['parent_cat_name']+'_'+val['tac_sub_cat_id'];
                vale = val;
                //console.log(val['cat_id'])
            if($.inArray(el, category) === -1) category.push(el);
            })
            
              $.each( category, function( key, vals ) {

                 // console.log(vals);
                  sort = vals.split('_');
                  $('.main_'+sort[1].replace(' ', '')).append('<li class="list-group-item" data="'+sort[2]+'">'+sort[0]+'</li>');   
                 })
              // $('.tadefault').show();
             $('.tadefix').hide();
               $.each( data, function( key, val ) {
                      if(val['company_id'] != null ){
                     italicFont  = 'italicFont';
                          if(myParam[1]==val['company_id']){
                         
                          //console.log(val['ct_eff_to'])
                          
                          // showTagEval(val['ct_eff_to'])
                            $('.tadefault').hide();
                             
                              $('.tadefix').show();
                              
                         
                          //$('.addedTag').length ? $('.ta').show() + $('.tafixed').show() :   $('.tadefault').show() +$('.tafixed').hide();
                              
                          }
                      }
                 parentcatname =   val['parent_cat_name'].replace(' ', '')
              
              
                  $('.sub_'+parentcatname).append('<li class="list-group-item sub_group sub'+val['tac_sub_cat_id']+' " sub="'+val['tag_id']+'">'+val['name']+'</li>');  
                   
                  
                   
               })
                del_ini();
            
           //scScroll()
        
            $('.list-group-item').dblclick(function(){
               
              $('.tadefault').hide()
                var subid = $(this).attr('data');
               $('sub_group').removeClass('subActive');
                
                if(!$(this).closest(".main").length ){
                    $(this).addClass('subActive');
                }
                 del_ini()
            if(!$(this).hasClass('sub_group')){
                $('.sub_group').hide();
                $('.sub'+subid).show("slide", { direction: "left" }, 200);
              
            }else{
                    var myParam = window.location.href.split("id=");
                var sub = $(this).attr('sub');
                
                   $(this).animate({backgroundColor: "#fff"}, 'slow');
                 $(this).addClass('subActive');
                    //JS JASON WITH POST PARAMETER
                     var para = {'tagid': sub, 'companyID': myParam[1]};
                      $.ajax({
                        type: "POST",
                          data: para,
                            dataType: "json",
                        url: "fe_add_tag",
                        success: function(data) { 
                            if(data['error']){
                                 
                                 $('.addedTag').remove();
                                gettags();
                           subActive = $('.subActive').text();
                                
                                $('.sub_group').removeClass('subActive');
                                  $( ".sub_group").unbind( "subActive" ); 
                                
                                //console.error(data['error']);
                                
                            }else if (data['success']){
                                   $('.ta').show();
                              $('#fetags').append('<li class="addedTag tag'+$('.subActive').attr('sub')+'" style="float:left;"><span class="tagName"></span>'+$('.subActive').text()+'<span class="tagRemove" data-tag="'+$('.subActive').attr('sub')+'">x</span><input type="hidden" name="tags[]" value=""></li>');
                            
                                    $('.tadefault').hide();
                                $('.tafixed').show();
                                   $('.sub_group').removeClass('subActive');
                                  $( ".sub_group").unbind( "subActive" );      
                                  del_ini();
                              
                            }
                                
                        }
                    });
                
                
            }
})
                        
        } 
    })               
             
}


function gettags(){
    
    var autopilotEmailCompany = window.location.href.split("id="); 

if((/companies/.test(window.location.href))) {
             $.ajax({
        type: "GET",
            dataType: "json",
        url: 'fe_get_tag',
        success: function(data) {
            console.log(data)
             $.each( data, function( key, val ) {
           
                $('#fetags').append('<li class="addedTag tag'+val['tag_id']+' " style="float:left;"><span class="tagName"></span>'+val['name']+'<span class="tagRemove" data-tag="'+val['tag_id']+'">x</span></li>');
                  $('.tafixed').show()
             })        
                      
                       del_ini() 
                       
                        if(!$('.addedTag').length)  $('.tadefault').show() +  $('.txtline').show() 
                    }
        
        })
}
    
    
}

  function scScroll(){
           $('.list-group-item').mouseenter(function(){
              
              //stopScroll()
               $( ".tagContainer").unbind( "mousewheel" );
           })
           
           
              $('.list-group-item').mouseleave(function(){
               $( "body").unbind( "mousewheel" ); 
           })
           
 }


function del_ini(){
   
      $('.tagRemove').click(function(){
                 var myParam = window.location.href.split("id=");
             var dataTag =  $(this).attr('data-tag');
          
                   //JS JASON WITH POST PARAMETER
                    var para = {'datatagid':dataTag, 'comp_id': myParam[1]};
                     $.ajax({
                       type: "POST",
                         data: para,
                           dataType: "json",
                       url: "fe_delete_tag",
                       success: function(data) {
                           
                      //  console.log(data);
                           
                           $('.tag'+data['success']).remove();
                           
                              //alert($('.addedTag').length);
                           $('.sub li').hide()
 $('.addedTag').length ? $('.ta').show()+ $('.tadefault').hide() +$('.tafixed').show() :  $('.tadefault').show() + $('.ta').hide() + $('.tafixed').hide() +  $('.main .list-group-item').hide() ;
                       }
                       });       
             })  
}

function stopScroll(){
    
    $('body').on({
    'mousewheel': function(e) {
        if (e.target.id == 'el') return;
        e.preventDefault();
        e.stopPropagation();
    }
})
    
}


function startScroll(){
    
     $( "body").unbind( "mousewheel" );
}

function showTagEval(dateEval =true){
    
    Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy  + '-' + (mm[1]?mm:"0"+mm[0]) + '-' +(dd[1]?dd:"0"+dd[0]); // padding
  };

d = new Date();
d.yyyymmdd();


var x = new Date(d.yyyymmdd());
var y = new Date(dateEval);

 
var plainDate =   x <= +y; //boolen true or false
//console.log(plainDate + '- ' + dateEval)
 

if(dateEval == null ) return true;
return plainDate;
    
    
}
 