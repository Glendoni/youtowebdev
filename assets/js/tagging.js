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
    
    
$('form').submit(function(e){
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
                        $('#'+key).text(p[key]);
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