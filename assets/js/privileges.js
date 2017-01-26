function getMainObj(){
    $.ajax({
        type: "GET",
            dataType: "json",
        url: "Privilege/read_classes",
        success: function(data) {
            var action;
            var items = [];
             var idfk;
var i = 0;
            //console.log(data['count']);
            
            $.each( data, function( key, val ) {
            
                if(key !='count'){
                    items.push( '<div class="'+key+' clear privilege_cont"   ><strong>'+key+'</strong>  <span></span><br></div>');
                    
                    i= i+1;
                    get_methods(key);

                    if(i == data['count']){
                        
                        getGroupEdit()
                    }
                        
                }
            });
             
            
     
            $('#privileges').html(items.join( "<hr />" ));   
               
            //$('.eventcount').html(items.length); //update engagement counter
        }
  
    }) 
}
 function get_methods(url = false){ 
    if(url){
    $.ajax({
        type: "GET",
            dataType: "json",
        url: url+"/privilege",
        success: function(data) {
            var action;
            var items = [];
             var idfk;
            var i=0;
            $.each( data, function( key, val ) {
                 if(!i){
                     
                $('.'+url+' span').html('All <input  class="'+url+' wrapper" type="checkbox" value="'+ url + '" > '); 
                     
                 }
              
                if(key !='count'){
                    items.push( '<label class="checkbox-inline privilege_items"><input type="checkbox" name="'+url+'[]" class="'+url+' wrapper prevItems" id="'+url+'_'+key+'" value="'+url+'_'+key+'"> '+key + '</label>');          
                }
                
                i= i+1;
                
               
            });
             
            $('.'+url).append(items.join( "<span class='clear'></span>" ));
            ini_handler()
             
           
            //$('.eventcount').html(items.length); //update engagement counter
        }
    });
    }
     
 }   


function  ini_handler(){
        
    $('.wrapper').on('click', function(){
        
         $('#prevSubmit').removeClass('btn-success');
                     $('#prevSubmit').addClass('btn-primary');
        $('#prevSubmit').text('Save');
        var group  = $(this).val();
        if($(this).is(':checked')){
            $('.privilege_items .'+ group).prop('checked', true);
        } else {
            $('.privilege_items .'+ group).prop('checked', false);
        }
    })
        
}
     
     
    function  getGroupEdit() {

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "Privilege/getGroupPrev",
                success: function(data) {
                    $.each(data, function(key, val){
                    $('form #'+val).prop( "checked", true )
                    })
                }
            }) 

    };   




function setpagenumber(pagenum = 1){
    
    
    pageSize = 10;
 
$(function() {
  var pageCount = Math.ceil($(".results").size() / pageSize);

  for (var i = 0; i < pageCount; i++) {
    if (i == 0)
      $("#pagin").append('<li><a class="current" data="' + (i + 1) + '" href="javascript:;">' + (i + 1) + '</a></li>');
    else
      $("#pagin").append('<li><a href="javascript:;" data="' + (i + 1) + '">' + (i + 1) + '</a></li>');
  }


  showPage(pagenum);

  $("#pagin li a").click(function() {
    $("#pagin li a").removeClass("current");
    $(this).addClass("current");
    showPage(parseInt($(this).text()))
  });

})

 function showPage(page) {
  $(".results").hide();

  $(".results").each(function(n) {
    if (n >= pageSize * (page - 1) && n < pageSize * page)
      $(this).show();
  });
    
}
    
}



$(document).ready(function(){
   
  //getMainObj();
   
    
    $('.addnewuser').click(function(){
        
        $('.freset,#department,#password').val(''); 
        $('.emailuser').hide();
        $('#created_by_name,#updated_by_name,#temp_password').text('');
        $('.userverbiagechange').text('Add New');
        $('#formstatus').attr('data','addUser');

    })
  
get_users_info();
    
    
    $('#submit_user').on('submit', function(e){
        
        

        var para = $('#submit_user').serialize();
        var url = $('#formstatus').attr('data');
        e.preventDefault();
        
       if($(this).hasClass('edit')){}
            //JS JASON WITH POST PARAMETER
           
              $.ajax({
                type: "POST",
                  data: para,
                    dataType: "json",
                url: "Privilege/"+url,
                success: function(data) { 
                 //console.log(data); //error false
                   get_users_info();
                    
                    
                    
                    console.log('I ran');
                    $('.addnewuser').trigger('click');
                    
                   
                }
                  
                  
                });
                
            
          
     
        
    })

}) //end of document ready.


Array.prototype.contains = function ( needle ) {
   for (i in this) {
       if (this[i] == needle) return true;
   }
   return false;
}


function get_users_info(){
        
        $.ajax({
        type: "GET",
            dataType: "json",
        url: "privilege/getusers",
        success: function(data) {
            var action;
            var items = [];
            var idfk;
            var testkey = [];
            var indices = [];
            var array = []
            var element = 'a';
     
            $.each( data, function( key, val ) {
                
                testkey.push(val['department']);
                items.push( '<div class="col-lg-12 results"><div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">'+val['name']+ '</div><div class="col-xs-5 col-sm-5 col-md-5 col-lg-5"><span class="usergroup">'+val['department']+'</span></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><button class="btn btn-sm btn-warning btn-block edp"  data_sub="'+val['id']+'" >Edit</button></div><br><hr /></div>');    
            
            });
             
                $('#users').html(''); 
    $('#pagin').html('');
            $('#users').append(items.join( "" ));
            
                    var uniqueVals = [];  
                    var department = [];
                    $.each(testkey, function(i, el){
                        if($.inArray(el, uniqueVals) === -1){

                            uniqueVals.push(el);
                            department.push('<option value="'+el+'">'+el+'</option>');
                        }

            });
           
           $('#department').append(department.join( "" ));
                edituser();
                setpagenumber();
            }
    });
    
    
}



function edituser(){
    
  
        
        
   $('#users .edp').on('click', function(){
        //console.log($(this).attr('data_sub'));
        $('.userverbiagechange').text('Edit');
       $('#formstatus').attr('data','updateUser');
       
      
       
       
       var userID =  $(this).attr('data_sub');
        var para  = {'userid' : userID }
        
        var testkey = [];
       var dateval = [];
    $.ajax({
                type: "POST",
                  data: para,
                    dataType: "json",
                url: "Privilege/getUser",
                success: function(data) {
                    $('#created_by_name, #updated_by_name,#temp_password').text('');
                    $('.emailuser').hide();
                    $.each( data, function( key, val ) {
                    
                        
                      // if( key == 'department') console.log(val);
                        
                       if( key == 'eff_from' &&  val != null){
                      
                           dateval = val.split('-');
                           $('#submit_user #'+key).val(dateval[2]+'-'+dateval[1]+'-'+dateval[0]); 
                           
                       }else  if( key == 'eff_to' &&  val != null){
                      
                           dateval = val.split('-');
                           $('#submit_user #'+key).val(dateval[2]+'-'+dateval[1]+'-'+dateval[0]); 
                           
                       }else if(key == 'created_by_name'){
                           
                           $('#submit_user #'+key).text('Created By: '+val);  
                           
                           
                        }else if(key == 'updated_by_name' &&  val != null){
                          // console.log(key)
                           $('#submit_user #'+key).text('Updated By: '+val);  
                           
                           
                        }else if(key == 'temp_password' &&  val != null &&  val != '' ){
                          // console.log(key)
                           $('#submit_user #'+key).text('Temp Password: '+val);  
                            $('.emailuser').show();
                           
                       }else{
                           $('#submit_user #'+key).val(val); 
                       }
                        
                    })
                    
                   
               // console.log(testkey.join(''))
                }
        
                });
       
       
    })
    
    
    
}





   