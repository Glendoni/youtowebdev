$(document).ready(function(){
    
  
    
     gettags();
    $('.nav-tabs').click(function(){
        
        $('.active').removeClass('activein');
        $('.tadefault').hide()
        
        $('.indicatorshow').hide();
        $('.main .list-group-item').show()
//$('.sub .list-group-item').hide()  
    })
  $('#tagCatList').html('');
    
    
    if((/companies/.test(window.location.href))) {
             $.ajax({
        type: "GET",
            dataType: "json",
        url: 'fe_read_cat',
        success: function(data) {
            var action , items = [],idfk,sub, editBtn,main, category =[],sub_cat = [],parcat, parcatId = [], el,elId,valst;
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
     var tagcont = [];
             $.ajax({
        type: "GET",
            dataType: "json",
        url: 'fe_read_tag',
        success: function(data) {
    $(".loading_div").hide();

            data = data.sort()  
            var action,items = [],idfk,sub,editBtn,main,sort, category =[] ,sub_cat = [],parcat,parcatId = [],el,elId,i=1,vale,italicFont,subActive, parentcatname;
            var myParam = window.location.href.split("id=");
           var subcatName;
            $.each( data, function( key, val ) {
                
                    el = val['sub_cat_name']+'_'+val['parent_cat_name']+'_'+val['tac_sub_cat_id'];
                
                if(!$('.subcont div').hasClass('fetagsholder'+val['tac_sub_cat_id'])){
                    
                    subcatName = val['sub_cat_name'].replace(/\s/gi, "");
                    subcatName = subcatName.replace('(', '');
                    subcatName = subcatName.replace(')', '');
tagcont.push('<div class="col-xs-12 '+subcatName+' fetagsholder'+val['tac_sub_cat_id']+' added-tag-holder"><div class="category-name-holder" >'+val['sub_cat_name']+'</div><ul class="fetags'+val['tac_sub_cat_id']+' sub_ul"></ul></div>'); 
            }          
//console.warn('qqqqqqqqqsub_'+val['sub_cat_name']);
                
                vale = val;
                //console.log(val['cat_id'])
            if($.inArray(el, category) === -1) category.push(el);
            })
            tagcont = tagcont.sort();
             $('.subcont').prepend(jQuery.unique(tagcont).join(''));  
 category = category.sort()
              $.each( category, function( key, vals ) {

                 // console.log(vals);
                  sort = vals.split('_');
                   $('.main_'+sort[1].replace(' ', '')).append('<li class="list-group-item folder" data="'+sort[2]+'"> <span class="folIcon indicatorshow"></span>'+sort[0]+'</li>');   
                   $('.main_'+sort[1].replace(' ', '')).append('<ul class="subtags sub_'+sort[2]+'" ></ul>');  
                  
               // console.warn('sub_'+sort[2]);
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
                   
                   if(val['parent_cat_name'] == null){
                       
                     // console.log(val['category_name']+' '+val['name'])  
                      
                     parentcatname =   val['category_name'].replace(' ', '');
                       
                      $('.main_'+parentcatname).append('<li class="list-group-item parent  sub_group sub'+val['tac_sub_cat_id']+' tag" cat_id='+val['tac_sub_cat_id']+' sub="'+val['tag_id']+'"> '+val['name']+'</li>');  
                      
                   }
                   if(val['parent_cat_name']){
                 parentcatname =   val['parent_cat_name'].replace(' ', '')
              
              
                  $('.sub_'+val['cat_id']).append('<li class="list-group-item sub_group sub'+val['tac_sub_cat_id']+' inner tag" par-sub-id="'+val['cat_id']+'" sub="'+val['tag_id']+'">'+val['name']+'<span class="pull-right label label-master-category">'+val['category_name']+'</span> </li>');  
                       
                   }
                   
                  console.log($('.main_'+val['cat_id']+' .sub_'+val['cat_id']+ ' li').length);
                   
               })
                del_ini();
            gettags()
            tagSearch();
           //scScroll()
        
            $('.tagContainer .list-group-item').click(function(){
               if($(this).parents('.main').length){
                       $('.activeMain .folIcon').removeClass('indicatorshow');
               $('.list-group-item').removeClass('activeMain');
                   $('.folIcon').removeClass('indicatorshow');
                     if(!$(this).hasClass('parent')){
                 //        $('.folIcon .indicatorshow').hide();
                         $(this).addClass('activeMain');
                          $('.activeMain .folIcon').addClass('indicatorshow').show();
                         //console.warn('i was clicked')
                     }
               }
               
              $('.tadefault').hide()
                var subid = $(this).attr('data');
               $('sub_group').removeClass('subActive');
                
                if(!$(this).closest(".main").length ){
                    $(this).addClass('subActive');
                }
                 del_ini()
            if(!$(this).hasClass('sub_group')){
                 $('.parent').removeClass('sub_group');
                $('.sub_group').hide();
    //$('.subtags').hide()
                
                $('.sub'+subid).show("slide", { direction: "left" }, 200);
               $('.parent').addClass('sub_group');
            }else{
                    var myParam = window.location.href.split("id=");
                
                
              var   param =  checkUrlParam(myParam);
                var sub = $(this).attr('sub');
                  var par_sub_id = $(this).attr('par-sub-id');
                 $(this).addClass('subActive');
                    //JS JASON WITH POST PARAMETER
                     var para = {'tagid': sub, 'companyID': param};
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
                                
                                  gettags();
                                   $('.ta').show();
                              // $('.fetags'+par_sub_id).append('<li class="addedTag tag'+$('.subActive').attr('sub')+'" style="float:left;"><span class="tagName"></span>'+$('.subActive').text()+'<span class="tagRemove" data-tag="'+$('.subActive').attr('sub')+'">x</span><input type="hidden" name="tags[]" value=""></li>');
                            
                                    $('.tadefault').hide();
                                $('.tafixed').show();
                                   $('.sub_group').removeClass('subActive');
                                  $( ".sub_group").unbind( "subActive" );  
                                
                                
                                 
                                tagSearch();
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





    
    
     //var myParam = window.location.href.split("id=");
    
    
    var param;
    var para  = window.location.href.split("?id=");

   param =  checkUrlParam(para);
    
    
    
     var para = {'companyID': param};
             $.ajax({
        type: "POST",
            data: para,
            dataType: "json",
        url: 'fe_get_tag',
        success: function(data) {
            //console.log(data)
            
            
              $('.addedTag').remove();
             $.each( data, function( key, val ) {
          // console.log(val['parent_tag_id'])
           
           // console.log('fetags'+val['parent_tag_id'])
           
           $('.fetags'+val['parent_tag_id']).append('<li class="addedTag tag'+val['tag_id']+' " style="float:left;"><span class="tagName"></span>'+val['name']+'<span class="tagRemove" data-tag="'+val['tag_id']+'">x</span></li>');
           
           
           //console.log('<li class="addedTag tag'+val['tag_id']+' " style="float:left;"><span class="tagName"></span>'+val['name']+'<span class="tagRemove" data-tag="'+val['tag_id']+'">x</span></li>');
          
                //$('#fetags').append('<li class="addedTag tag'+val['tag_id']+' " style="float:left;"><span class="tagName"></span>'+val['name']+'<span class="tagRemove" data-tag="'+val['tag_id']+'">x</span></li>');
                  $('.tafixed').show()
             })        
                      
                       del_ini() 
                       unHighlightActiveSubITems()
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
          
          $('.tagRemove').on('click.disabled', false);
                 var myParam = window.location.href.split("id=");
          
          
          var param =  checkUrlParam(myParam);
             var dataTag =  $(this).attr('data-tag');
          
                   //JS JASON WITH POST PARAMETER
                    var para = {'datatagid':dataTag, 'comp_id': param};
                     $.ajax({
                       type: "POST",
                         data: para,
                           dataType: "json",
                       url: "fe_delete_tag",
                       success: function(data) {
                           
                      //  console.log(data);
                           
                           $('.tag'+data['success']).remove();
                             $('.activeMain .folIcon').removeClass('indicatorshow');
                              //alert($('.addedTag').length);
                           $('.sub li').hide()
 $('.addedTag').length ? $('.ta').show()+ $('.tadefault').hide() +$('.tafixed').show() :  $('.tadefault').show() + $('.ta').hide() + $('.tafixed').hide();
                           
                        unHighlightActiveSubITems();
                        $('.tagRemove').off('click.disabled');
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
 function tagSearch(){
    $("#filter").keyup(function(){
            $('.indicatorshow').hide();
            $('.filter-count').show();
            // Retrieve the input field text and reset the count to zero
                var filter = $(this).val(), count = 0;
                // Loop through the comment list
            $("ul.main_ProductType li").each(function(e,t){
                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
                    // Show the list item if the phrase matches and increase the count by 1
                    }else{
                        $(this).show();
                        count++;
                        if($('#filter').val() === ''){

                        $('.sub_group').hide();
                        $('.parent').show();

                        $(this).val(), count = 0;
                        $('.filter-count').hide();
                    }
                 }
            });
            // Update the count
            var numberItems = count;
            $("#filter-count").text(count+" Found");

            $('.filter-count-cancel').html('<span class="run">Cancel</span>');

            $('.run').click(function(){
                $('#filter').val('');
                $('.filter-count').hide();
                $('#filter').trigger('keydown');
                $('#filter').trigger('keyup');
            })
    });
 }

function unHighlightActiveSubITems(){
    
    $('.sub_group').css('opacity' , '1.0');
    
     $('.sub_group').css(' color' , 'rgba(0, 0, 0, 0.53)');
 
    var parid;
    var tagSecGroup;
    var subName;
    var subItemName;
    var subID;
    var subAttr;
    var tagSegGroup;
    var apendParName;
    $('.sub_group').each(function(){
    parid = $(this).attr('par-sub-id');
        if(parid){
            subName = $(this).text().trim();
            subID = $(this).attr('sub');
            subAttr = $(this).attr('sub');
            tagSegGroup = 'fetagsholder'+parid
            apendParName = $(this).find('span').text();
            $('.'+tagSegGroup+ ' .addedTag').each(function(i,e){
                subItemName = $(this).text().slice(0,-1);
                if(subItemName == subName.replace(apendParName, '')){
                    $('.sub_group').each(function(){
                        if($(this).attr('sub') == subAttr){
                            $(this).css('opacity', '0.6');
                        }
                    })
                }
            })
        }
    })
    
    
var parid;
var subid;
var parsubid;
var parname;
var test;
var testr;
$('.parent').each(function(){ 
    if($(this).attr('cat_id')){
        parid = $(this).attr('cat_id');
        parname = $(this).text();
        test = $(this).attr('sub')
        $('.fetagsholder'+parid+ ' .addedTag').each(function(){ 
        if(parname.trim() == $(this).text().slice(0,-1)){
            $('.sub'+parid).each(function(){
                if(test ==  $(this).attr('sub')){
                    $(this).css('color', 'rgb(212, 212, 212)');
                }
            })
        }
        })
    }
})

var capture
var apendParName;
 
    $('.category-name-holder').each(function(){
        apendParName = $(this).text().replace(/\s/gi, "");
        apendParName = apendParName.replace('(', '');
        apendParName = apendParName.replace(')', '');

        $('.'+ apendParName+ ' .sub_ul').each(function(){
            capture  = $('.'+ apendParName+ ' .sub_ul').text()
            if(!capture){
            $('.'+ apendParName).hide();
            }else{
                $('.'+ apendParName).show();
            }
        })
    });
}


function checkUrlParam(para){
    var param;
    param = para[1];
if(isInt(param)){
 
return param = para[1];
}else{
param  = param.split('&');

return param = param[0];
}
    
    
}



function isInt(n) {
   return n % 1 === 0;
}


 