var arr = [
];
var subspan;
$('.tagName').each(function(e,i){
    
 //subspan = $(this).children('span').text(); //shows the x at the end of the 

    item =$(this).text();
    
  //item  =   reverseString(item);
    //subspan
    
    
   // alert(item);
  //arr.push()
})

// display all values
for (var i = 0; i < arr.length; i++) {
    console.log(arr[i]);
}


function glen(){
    
    alert('Glen');
}


function reverseString(str) {
    return str.split('').reverse().join('');
}


function editName(){
    
        $('.cr_switch form').on('submit',function(event){
        event.preventDefault()
        // $( this ).off( event );
        var obj =  $(this).serialize();
            var url = false;
            
        if($(".cr_switch").hasClass('create')){
            url = "tag_categories/create";
              }else if($(".cr_switch").hasClass('edit_cat')){
            url = "tag_categories/edit";   
    
        }else if($(".cr_switch").hasClass('add_tag')){
            url = "tag_categories/addTag";   
    
        }else{
            
            
        }
            
        if($(".cr_switch").hasClass('create_sub') ){
            url = "tag_categories/sub";   
          }
            
            if($(".cr_switch").hasClass('edit_tag') ){
            url = "tag_categories/editTag";   
          }
        
       // alert(url);
        //JS JASON WITH POST PARAMETER
            
        if(url){
         
          $.ajax({
            type: "POST",
            data: obj,
            dataType: "json",
            url: url,
            success: function(data) {
                if(data['error']){
                                $('.catError').text('');
                            var   p = data['error'] ; 
                            for (var key in p) {
                                if (p.hasOwnProperty(key)) {
                                    $('.'+key).text(p[key]);
                                    if(key == 'missing_action') alert('contact admin error code: '+p[key]);
                                }
                            }
                         console.log(data['error']['name']);
                    }else{
                         //$('input').val('');
                        $('.catError').text('');
                        console.log('Sucesss');
                        $('#activeform').val('');
                        $( ".cr_switch form").unbind( "submit" );
                        loadCatList();
                    }
                    },
                        error: function() {
                        alert("There was an error. Try again please!");
                    }
                });
    }

 
     $('#sender').attr("disabled", false)
    })

}

function loadCatList(test = 'tag_cat'){
    //console.log('Whhhhhy');
    $('#tagCatList').html('');
             $.ajax({
        type: "GET",
            dataType: "json",
        url: test,
        success: function(data) {
            var action;
            var items = [];
             var idfk;
            var sub;
            var editBtn;
            var main;
            $.each( data, function( key, val ) {
                  idfk = val.company_id;
          // val.action 
                 main = '<a href="javascript:;" sub-data="'+val.id+'" class="cr_switch_titler">'+val.name+'</a>';
                
                if(val.sub_name != null ) {
                     
                    sub = '<a href="javascript:;" sub-data="'+val.sub_master_id+'" class="cr_switch_titler">'+val.sub_name+'</a>';
                 editBtn = '<button class="edit edit_cat" tag-data="'+val.sub_master_id+'_'+val.name+'_'+val.cat_eff_from+'_'+val.cat_eff_to+'_'+val.sub_name+'_'+val.id+'" >Edit</button> <button sub-data="'+val.id+'_'+val.name+'_'+val.id+'" class="addSubCatOne">Add New Sub</button> ';
                    swticher()
                }else{
                    editBtn = '-';
                    sub = '-';
                     editBtn = '<button sub-data="'+val.id+'_'+val.name+'" class="addSubCatOne">Add Sub Category</button>';
                    swticher()
                }
                   
                
                items.push('<tr><th scope="row">'+(key +1)+'</th><td>'+main +'</td><td colspan="2">'+sub+'</td><td> '+editBtn+' </td></tr>');  
                
           
            });
               
            // $('#tagCatList').html( "" );
            
            $('#tagCatList').html(items.join( "" ));
             // $( ".cr_switch_title" ).trigger('click');
 //$( ".cr_switch_title" ).trigger('click');
                     $('#name').val('');
      $('#eff_from').val('');
     $('#eff_to').val('');
             
            
            if($(".cr_switch").hasClass('edit_tag') == true || $(".cr_switch").hasClass('add_tag') == true){
                
                var tagID = $('#master').val();
                getTags(tagID);
            }
            
            $(".cr_switch").removeClass('add_tag');
            
            
            
            
            btn()
            rta()
             swticher();
             editName()
            
       
            
        }

    });
  
}


function removeTag(tagid){
    
    
    
             $.ajax({
        type: "GET",
            dataType: "json",
        url: tagid,
        success: function(data) {
            //alert(data);
            return 'ok';
        }
                 
             })
    
    
}

function getTags(id = false){
             if(id){
    $.ajax({
        type: "GET",
            dataType: "json",
        url: 'showtags/'+id,
        success: function(data) {
            var action;
            var items = [];
             var idfk;
            var sub;
            var eff_to  = '';
            $('.tags').html('');
            $.each( data, function( key, val ) {
               
              // console.log(val[key])
               
               if(val.eff_to != null ){
                   eff_to = val.eff_to;
               }
             
    $('.tags').prepend('<li class="addedTag" tag-data="'+val.tag_id+'_'+val.name+'_'+val.tac_sub_cat_id+'_'+val.sub_cat_name+'_'+val.sub_parent_cat_id+'_'+val.parent_cat_name+'_'+val.eff_from+'_'+eff_to+' " ><span class="tagName" ></span>'+val.name+' <span  class="tagRemove">x</span><input type="hidden" name="tags[]" value="'+val.name+'"></li>')
     
            });
               
         tags()
          tagRemove()
            
        }

    });
             }
}


    function tagRemove(){

        $('.tagRemove').on('click',function(){
             
            //removeTag('../distroy')
            var response;
            var item  = $(this).parent().attr('tag-data');
            item = item.split('_');
            console.log(item[0])
            //alert();  
            //response =    removeTag('distroy/'+item[0]);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'distroy/'+item[0],
                success: function(data) {
                    getTags(item[2])
                }

            })

        })

    //onclick="$(this).parent().remove();"
    }


function tags(){
    
    
    $('.addedTag').on('dblclick',function(){
 $('#sender').attr("disabled", false)
        $('input').attr("disabled", false)
    var edit = $(this).attr('tag-data');
        var master;
        $(".cr_switch").removeClass('add_tag');
$(".cr_switch").addClass('edit_tag');
    console.log(edit)
    edit = edit.split('_');
    // alert('Rename tag:  '+$(this).text());
//12_Charge Nurse_41_Nurse  Doctor_7_NHS_2016-03-30_2016-04-25 
    //alert(edit[5])
    $('#itemid').val(edit[0]); 
        //alert(edit[2])
        master  = edit[2]? edit[2] : edit[4];
    $('#master').val(master); 

    $('.tagtitle').html('Edit Tag: <strong>'+edit[1]+'</strong>');

    $('#name').val(edit[1]);  

    $('#eff_from').val(edit[6]);
    if(edit[7] != 'null') {$('#eff_to').val(edit[7])}

    //$(this).addClass('edit_active');
    $("html, body").animate({ scrollTop: 0 }, "slow");

    }) 

    $( this ).off( event );
    
}


function btn(){
    
   // $("html, body").delay(2000).animate({scrollTop: $('#listings').offset().top }, 2000);
    //SUB CATEGORY ADD SECTION
    
    $('.addSubCatOne').click(function(e){
$('.addTagBtn').hide();
        $('#sender').attr("disabled", false);
        $('input').attr("disabled", false);
         $('.addTagBtn').attr("disabled", 'disable');
         $('#name').val('');
      $('#eff_from').val('');
     $('#eff_to').val('');
           defaultEffToDate()
        $('.addTagBtn').attr("disabled", 'disable');
         $('.tagstitle').html('&nbsp;');
                $('.tags li').hide();

        $(".cr_switch").removeClass("create");
        $(".cr_switch").removeClass("edit_cat");
        $(".cr_switch").addClass('create_sub');

        e.preventDefault();

        var edit  = $(this).attr('sub-data');
        edit = edit.split('_');
 
        $('#itemid').val(edit[0]); 
        
            master  = edit[0]? edit[0] : edit[2];
    $('#master').val(master); 
       
        $('.tagtitle').html('Add Sub Category To: <strong>'+edit[1]+'<strong>');
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })
            
            $('.edit').click(function(e){
                $('.addTagBtn').hide();

                    $('#sender').attr("disabled", false)
               $('input').attr("disabled", false)
                e.preventDefault();
                var edit  = $(this).attr('tag-data');
                $(".cr_switch").removeClass('add_tag');
                $(".cr_switch").removeClass("create");
                $(".cr_switch").removeClass("create_sub");
                  $(".cr_switch").removeClass('edit_tag');
                $(".cr_switch").addClass("edit_cat");
                 $('.addTagBtn').attr("disabled", 'disable');
                $('.tagstitle').html('&nbsp;');
                $('.tags li').hide();
                    edit = edit.split('_');

            $('input').val('');

            //alert(edit[5])
        $('#itemid').val(edit[0]); 
        $('#master').val(edit[5]); 
$('.tagtitle').html('Edit Sub Category Of: <strong>'+edit[1]+'</strong>')

        if($(".cr_switch").hasClass('edit_cat')){

           // $(".cr_switch").addClass('edit_cat')
            $('#name').val(edit[4]);   

        }else{

            $('#name').val(edit[1]);
        }

        $('#eff_from').val(edit[2]);
        if(edit[3] != 'null') {$('#eff_to').val(edit[3])}
        console.log(edit[3]); 
        //$(this).addClass('edit_active');

        $("html, body").animate({ scrollTop: 0 }, "slow");

        }) 
            
          
    swticher()
   
}
function categoryListings(){
     
   $( ".cr_switch_titlerss" ).click(function(e){

      e.preventDefault();
       
       //alert('Glen')
    })  

}
    function rta(){ // deal with setting up the inteface and manging changes      
        $( ".cr_switch_title" ).click(function(){
         
      $('#sender').attr("disabled", false)
       $('input').attr("disabled", false)         
  
    if( $('.edit').hasClass('edit_cat')){
       
       
        
     $('.edit').removeClass('edit_cat');
    $('.edit').addClass('create_sub');
       
       }else{
       
          $('.edit').addClass('edit_cat');
    $('.edit').removeClass('create_sub');
       
       }
 
    });  
    }  
function addTag(){
    
    var tagCatId  = $('.addTagBtn').attr('tag-cat-id');
      $('#name').val('');
      $('#eff_from').val('');
     $('#eff_to').val('');
    
    
    
   $('.addTagBtn').click(function(){  
         $('#name').val('');
      $('#eff_from').val('');
     $('#eff_to').val('');
       defaultEffToDate()
         $('#sender').attr("disabled", false)
       $('input').attr("disabled", false)
        $(".cr_switch").removeClass('create');
        $(".cr_switch").removeClass('edit_cat');
        $(".cr_switch").removeClass('create_sub');
        $(".cr_switch").removeClass('edit_tag');
        $(".cr_switch").addClass('add_tag');

       
       $('.itemName').text('Add Tag: ');
       $('#name').attr('placeholder', 'Add Tag Name');
       $('.cr_switch_title').text('');
       $('.tagtitle').html('Sub Category: <strong>'+$('.addTagBtn').attr('tag-name')+'<strong>');
       //alert('addTagBtn Clicked');
     
       
       
       
       $('#itemid').val(tagCatId); 
        $('#master').val(tagCatId); 
       
       ;
       
             $("html, body").animate({ scrollTop: 0 }, "slow");
   })
}

function swticher(){
    
 
    $('.tagtitle').html('&nbsp;');
    
    $('#sender').attr("disabled", 'disable')
     $('input').attr("disabled", 'disable')
    
    $('.edit').addClass('edit_cat');
 
         $('.cr_switch_titler').click(function(){
             
              $('.addTagBtn').show();
              $('#sender').attr("disabled", 'disable')
     $('input').attr("disabled", 'disable')
     
      $('.tagtitle').html('&nbsp;');
              $('.addTagBtn').attr("disabled", false);

             
             var subID =  $(this).attr('sub-data');
             var tag_title = $(this).text();
             
             
             
             if(subID){
                 
                $(".cr_switch").removeClass('create') 
                  $('.edit').addClass('edit_cat');
             }
             
             
               $('input').val('');
             
               $('.cr_switch_title').attr('tag-cat-id',subID);
             $('.addTagBtn').attr('tag-cat-id',subID);
             $('.addTagBtn').attr('tag-name',tag_title);
             
    $('.tagstitle').html('Sub Category: <strong>'+tag_title+'</strong> Tags');
            // alert(subID);
            if(!$(".cr_switch").hasClass('add_tag')) {
        // loadCatList('gettags/29');
            }
                getTags(subID)
                addTag()
                $("html, body").animate({ scrollTop: 272 }, "fast");
         })
}

$(document).ready(function(){
  
    
//Teporary Hack to make list visible 

 
    
     loadCatList()
      //categoryListings();

 //rta()

 
    
  

    
})

function defaultEffToDate(){
    
 var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = (day<10 ? '0' : '') + day +  '-' +
(month<10 ? '0' : '') + month + '-' +
d.getFullYear() ;

$("#eff_from").val(output);

$('#eff_from').datetimepicker({
    language: 'en',
    format: 'dd-MM-yyyy'
});
    
}
