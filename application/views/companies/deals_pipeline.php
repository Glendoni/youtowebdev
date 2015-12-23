<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <!--<link rel="stylesheet" href="/resources/demos/style.css"> -->
  <style>
 
  .column {
    width: 200px;
    float: left;
    padding-bottom: 100px;
  }
  .portlet {
    margin: 0 1em 1em 0;
    padding: 0.3em;
  }
  .portlet-header {
    padding: 0.2em 0.3em;
    margin-bottom: 0.5em;
    position: relative;
     font-size: 11px;
    background: #F0AD4E;
    color: #fff;
      font-weight:100;
          font-family: 'Open Sans', sans-serif;
  }
  .portlet-toggle {
    position: absolute;
    top: 50%;
    right: 0;
    margin-top: -8px;
  }
  .portlet-content {
    padding: 0.1em;
          font-size: 9px;
    font-weight: 600;
          font-family: 'Open Sans', sans-serif;
  }
  .portlet-placeholder {
    border: 1px dotted black;
    margin: 0 1em 1em 0;
    height: 50px;
  }
   
      #pipleine_content h2{
          
          font-size: 11px;
             text-align: center;
      }
      
   #pipleine_content img{
          float:left; 
          padding-right:3px; 
          width: 23%;
      }
      
      #pipe{
              padding-left: 2%;
      }
      
  </style>
    
 <script>
    function  dragg(str){
//console.log(str);

 //console.log('Portal headers '+$('.active .portlet-header').text() + ' id '+$('.active').parent().attr('placement')+ ' company ID: '+ $('.active').attr('company_id')); 
 //alert('drag258'+str);

        if($('.active').parent().attr('placement') == 'delete'){
            
          $('.active').hide();
        }
        
        
if(str){

$.ajax({
type: "POST",
dataType: "json",
url: "../companies/dragupdate",
data: str,
success: function (data) {
    //alert('From Server')
    }
    })
       
}
        
    }
    </script> 


<div class="row ">
    <h2 class="company-header">
		Deals Pipeline 	</h2>
<div  class="mainboxs ">
 
 
    
    <div id="pipe">
        <div id="pipleine_content">
            
            <span class="column glyphicon glyphicon-trash" style="width:50px; height:90px; font-size: 30px;" placement="delete" aria-hidden="true"></span>
 </div>
        </div>
    

    
    
</div>
</div>

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

 <script type="text/javascript"  src="<?php echo asset_url();?>js/deals-pipeline.js"></script> 
  <script>
 

        
        
    </script>
