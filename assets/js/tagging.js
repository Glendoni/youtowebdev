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
    

        $('.tagName').on('dblclick',function(){


        alert('Rename tag:  '+$(this).text());

            $( this ).off( event );

        })


        $('.create form').on('submit',function(e){
        var obj =  $(this).serialize();
        e.preventDefault()
        //alert(obj);
            //JS JASON WITH POST PARAMETER
             var para = obj;
              $.ajax({
                type: "POST",
                data: para,
                dataType: "json",
                url: "categories",
                success: function(data) {
                    if(data['error']){
                        $('.catError').text('');
                    var   p = data['error'] ; 
                    for (var key in p) {
                        if (p.hasOwnProperty(key)) {
                            $('.'+key).text(p[key]);

                            console.log(key);
                        }
                        }
                            console.log(data['error']['name']);
                        }else{
                             $('input').val('');
                            console.log('Sucesss');
                             loadCatList()
                        }
                        },
                            error: function() {
                            alert("There was an error. Try again please!");
                        }
                    });

        })


        $('.child form').on('submit',function(e){
        var obj =  $(this).serialize();
            var url;
        e.preventDefault()
        
        if($(".cr_switch").hasClass('create')){
        
        url = "categories";
        }else{
            
         url = "categories/sub";   
            
        }
        
        
        //JS JASON WITH POST PARAMETER
             var para = obj;
              $.ajax({
                type: "POST",
                data: para,
                dataType: "json",
                url: url,
                success: function(data) {
                    if(data['error']){
                        $('.catError').text('');
                    var   p = data['error'] ; 
                    for (var key in p) {
                        if (p.hasOwnProperty(key)) {
                            $('.'+key).text(p[key]);


                        }
                        }
                            console.log(data['error']['name']);
                        }else{
                             $('input').val('');
                            console.log('Sucesss');
                            
                        }
                        },
                            error: function() {
                            alert("There was an error. Try again please!");
                        }
                    });
            
           

        })

 

}

function loadCatList(){
    //console.log('Whhhhhy');
    $('#tagCatList').html('');
             $.ajax({
        type: "GET",
            dataType: "json",
        url: "test",
        success: function(data) {
            var action;
            var items = [];
             var idfk;

            $.each( data, function( key, val ) {
                  idfk = val.company_id;
          // val.action 
                items.push('<tr><th scope="row">'+(key +1)+'</th><td>'+val.name +'</td><td><a href="javascript:;" class="cr_switch_titler">@mdo</a></td><td>-</td><td >  <a href="#" class="edit edit_Cat" >Edit</a></td></tr>');  
            });
               
            $('#tagCatList').html(items.join( "" ));
        }

    });
    categoryListings()
}

function categoryListings(){
    
  
   $( ".cr_switch_titler" ).click(function(e){

      e.preventDefault();
       
       alert('Glen')
    })  
    

}

 loadCatList()
$(document).ready(function(){


  $('a').click(function(e){
      // loadCatList()
    e.preventDefault();
        alert('Glen'); 
    //$(this).addClass('edit_active');
      
  }) 

 
 

    $( ".cr_switch_title" ).click(function(){
        
        $('input').val('');
        
    $(".cr_switch").toggleClass("create");
    $('.cr_switch').toggleClass("create_sub");
    if($(".cr_switch").hasClass('create')){
$('.cr_switch_title').text('Add Sub Section');
        $('.itemName').text('Category Name');
    $('.tagtitle').text('Create Category')
    }else{
    $('.tagtitle').text('Create Sub Category') 
    $('.cr_switch_title').text('Add Category');
$('.itemName').text('Sub Category Name');
    }

 categoryListings();

    }); 

})
      