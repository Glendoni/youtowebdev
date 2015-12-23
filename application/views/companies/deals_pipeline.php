<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <!--<link rel="stylesheet" href="/resources/demos/style.css"> -->
  <style>
 
  .column {
    padding-bottom: 50px;
    background-color: #D7DEE6;
    padding-top: 10px;
        border-bottom-left-radius:4px;
        border-bottom-right-radius:4px;
  }
  .portlet {
     padding: 10px;
    width: 96%;
    margin: auto;
  }
  .portlet:hover {
    cursor: pointer; 
  }
  .portlet-header {
    margin-bottom: 0.5em;
    position: relative;
      font-weight:100;
      background: none;
border-bottom:1px solid #9797A6;
border-top: none;
border-right: none;
border-left: none;
border-radius: 0;
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
    height: 100px;
    display: block;
    text-indent: -9999px;
  width: 96%;
  background: url(../assets/images/plus.svg) #D8D8D8;
  background-size: 100px 82px;
  background-repeat: no-repeat;
  background-position: center;
  margin: auto;
  }

      #pipeline_labels h2{
          
          font-size: 14px;
             text-align: left;
             color: #778794;
                         text-transform: uppercase;

      }
      
   #pipeline_content img{
          float:left; 
          padding-right:3px; 
          width: 23%;
      }
      
      #pipe{
              /*padding-left: 2%;*/
      }
      .ui-sortable-helper {
-webkit-box-shadow: 10px 10px 75px -16px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 10px 75px -16px rgba(0,0,0,0.75);
box-shadow: 10px 10px 75px -16px rgba(0,0,0,0.75);
      }
      .colum-header {
        background-color: #D7DEE6;
        border-top-left-radius:4px;
        border-top-right-radius:4px;
            padding: 1px 10px 8px 10px;
            border-bottom: 1px #CAD1DB solid;
      }
      .p-holder {
            background-color: red;
    height: 10px;

      }
      .reduced-padding {
        padding: 0 5px;
      }
      .header-bold {
        font-weight: 800;
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

<div  class="mainboxs " style="overflow:hidden;">
<div class="row ">

<div class="col-md-2">
<span class="column glyphicon glyphicon-trash" style="width:50px; height:90px; font-size: 30px;" placement="delete" aria-hidden="true"></span>
</div>
<div class="col-md-8"><h2 class="company-header">Deals Pipeline</h2></div>
<div class="col-md-2"></div>
</div>
<div class="row"]>
<div class="col-md-12">
<div id="pipeline_labels">
</div>
</div>
<div class="col-md-12">

<div id="pipe">

<div id="pipeline_content">
            
           
 </div>
        </div>
    </div>
    </div><!--END ROW-->

    
    
</div>
</div>

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

 <script type="text/javascript"  src="<?php echo asset_url();?>js/deals-pipeline.js"></script> 
  <script>
 

        
        
    </script>
