<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <!--<link rel="stylesheet" href="/resources/demos/style.css"> -->
  <style>
 html {
       overflow-y: scroll;
}
  .column {
    padding-bottom: 50px;
    background-color: #D7DEE6;
    padding-top: 10px;
        border-bottom-left-radius:4px;
        border-bottom-right-radius:4px;
  }
  .portlet {
    padding: 20px 10px;
    width: 96%;
    margin: auto;
    background-color: #ffffff !important;
  }
  .portlet:hover {
    cursor: move; 
  }
  .portlet-header {
  /*  margin-bottom: 0.5em; */
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
              font-size: 1.4em;
             text-align: left;
            color: #FFFFFF;
            text-transform: capitalize;
              font-weight: 100;
          letter-spacing: 2px;
    font-family: inherit;
          text-align: center;

      }
      
   #pipeline_content img{
          float:left; 
          padding-right:3px; 
          width: 23%;
      }
      .ui-widget-content {
        background: none;
      }
      #pipe{
              /*padding-left: 2%;*/
      }
      .ui-widget-content.ui-sortable-helper {
        background-color: rgba(255, 255, 255, 0.7) !important;
      }
      .ui-sortable-helper {
-webkit-box-shadow: 10px 10px 75px -16px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 10px 75px -16px rgba(0,0,0,0.75);
box-shadow: 10px 10px 75px -16px rgba(0,0,0,0.75);
      }
      .colum-header {
        background-color: #2B4461;
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
      font-weight: 300;
    text-transform: capitalize;
      }
      .delete {
        background-color: red;
        border-radius: 50%;
  width:60px;
    background: url(../assets/images/bin.svg) #FB6174;
    background-size: 25px;
    background-repeat: no-repeat;
        background-position: center;
  height: 60px; 
  margin-left: 30px;
  padding-top: 0;
  transition: width 2s;
      }
      
       .delete .portlet-placeholder {
        background-color: red;
        border-radius: 50%;
  width:80px;
    background: url(../assets/images/bin.svg) #FB6174;
    background-size: 25px;
    background-repeat: no-repeat;
        background-position: center;
  height: 80px; 
  margin-left: -10px;
  margin-top: 0;
  
  }
.ui-widget-header {
     border: none;
    
      }
#pipeline_labels h2  {
    
    font-weight: 500;
}
.pipe-user{
    cursor: move;
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


<div class="row">
          <div class="col-sm-9 col-sm-offset-3 " style="margin-bottom:20px;">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs dashboard" role="tablist">
                <li><button role="tab" class="button btn btn-primary btn-sm deals_pipeline" style="margin-right:10px;" onclick="window.location ='<?php echo base_url(); ?>dashboard'">Dashboard</button></li>
                <li  class=""><button role="tab" class="button btn btn-primary btn-sm deals_pipeline" style="margin-right:10px;" onclick="window.location ='<?php echo base_url(); ?>companies/pipeline'">Upcoming Deals</button></li>
              </ul>

          </div>
          <div class="col-sm-9 col-sm-push-3">
          </div>
        </div>


<div  class="mainboxs " style="overflow:hidden;">
<div class="row ">

<div class="col-md-2">
<div  class="column delete" placement="delete" aria-hidden="true">
</div>
</div>
<div class="col-md-8"><h2 class="company-header">Deals Forecast</h2></div>
<div class="col-md-2"></div>
</div>
<div class="row" style="margin-top:20px;">
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

<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript"  src="<?php echo asset_url();?>js/deals-pipeline.js"></script> 
