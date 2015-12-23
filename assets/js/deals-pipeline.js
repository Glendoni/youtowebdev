    
    ////////////////THE HOLY GRAIL
    var d = new Date();
      d.setMonth(d.getMonth()+3);   //change retruned months here
      var   montheval =""+d.getMonth()+"" ;
      montheval =  montheval.substr(1, 1) ? d.getMonth() : '0'+d.getMonth() ;
      
      monthevalconcat = d.getFullYear()+"-"+(montheval)+"-01";
      
    //console.log(monthevalconcat);

          ////////////////////THE HOLY GRAIL END

    var dateObj = new Date();
    var month = dateObj.getUTCMonth() + 1; //months from 1-12
    var day = dateObj.getUTCDate();
    var year = dateObj.getUTCFullYear();

    //newdate = year + "-" + month + "-" + day;
          newdate = year + "-" + month + "-01";

    var start = new Date(newdate); //yyyy-mm-dd
    var end = new Date(monthevalconcat); //yyyy-mm-dd
    var mon =['January','Feburary','March','April','May','June','July','Auguast','September','October','November','December' ];
        while(start <= end){

            var mm = ((start.getMonth()+1)>=10)?(start.getMonth()+1):'0'+(start.getMonth()+1);
            var dd = ((start.getDate())>=10)? (start.getDate()) : '0' + (start.getDate());
            var yyyy = start.getFullYear();
            var date = yyyy +"-"+mm+"-"+dd; //yyyy-mm-dd
            if(dd == 01){


                //console.log(mon[(mm-1)]); 

                $(' <div class="column" placement="sc'+date+'"><h2>'+mon[(mm-1)]+'<br/>SHOULD</h2></div>').appendTo('#pipleine_content'); 
                    $(' <div class="column" placement="wc'+date+'"><h2>'+mon[(mm-1)]+'<br/>WILL</h2></div>').appendTo('#pipleine_content'); 

            }
                start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
        }

  $(function() {
 
    $( ".column" ).sortable({
           
      connectWith: ".column",
      handle: ".portlet-header",
      cancel: ".portlet-toggle",
      placeholder: "portlet-placeholder ui-corner-all",
        receive : function(event, ui) {
				                //console.log($(this).data().uiSortable);
            
            var newMonth = $('.active').parent().attr('placement');
            var elementId = $('.active .portlet-header').text();
            var companyId  = $('.active').attr('company_id');
            
            var params = { 
                monthupdate:newMonth, 
                companyId:companyId };
            var str = jQuery.param( params );
            
            //console.log(newMonth);     
          //  var call = pipm();
          // console.log('Portal headers '+$('.active .portlet-header').text() + ' id '+$('.active').parent().attr('placement') );   
            //console.log('Portal header '+$('.active .portlet-header').text() + ' id '+$('.active').parent().attr('placement') );
            dragg(str);
            $('.portlet').removeClass('active');
						return true;
        },
             update: function( event, ui ) {
            
             }
    });
      
    $( ".portlet" )
      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
 
    $( ".portlet-toggle" ).click(function() {
      var icon = $( this );
      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
      icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();

    }); 
  });
        
   function replaceAll(str, find, replace) {

    if(str){
        return str.replace(new RegExp(find, 'g'), replace);
    }else{

        return false;

    }
}      
    $(document).ready(function(){
         initialize_dragg(); // get drag and drop entries from server    
    })
        function initialize_dragg()
        { //gets entries from server
               $.ajax({
                        dataType: "json",
                        url: "../../baselist/companies/drag",
                        success: function (data) {
                            
                                  var img = "https://sonovate.peoplehr.net/Files/Employee/210194/5013/d63f04039c6e473a980b71d316cdaa38.jpg";
                                 
                                  //var  updateinfo = "updated by: Richard Lester<br/> On: 20/11/2015"
                                  var placement_holder_prefix;                      
                            for (var key in data) {
                                if(data[key]['status']== 1 ){
                                placement_holder_prefix = 'sc';
                                }else{

                                   placement_holder_prefix = 'wc';  

                                }
     $('<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" company_id="'+data[key]['company_id'] +'"><div class="portlet-header ui-sortable-handle ui-widget-header ui-corner-all"><span class="ui-icon ui-icon-minusthick portlet-toggle"></span>'+ 
       data[key]['companyname'] +
         '</div><div class="portlet-content">'+ data[key]['owner'] +
         ' <img class="circle" src="'+ img +'"><br/></div></div>').appendTo("[placement="+placement_holder_prefix+data[key]['efffrom']+"]" );
   
                                    jsonBinder(); //binds listeners to JSON  generated elements retruned back from the server
                        }
                    }
            
    
             })
    
    }
    
        function  jsonBinder()
        { //binds listeners to JSON  generated elements retruned back from the server

            $('.portlet').click(function(){
                $(this).addClass('active');
            })

            $('.portlet').mouseup(function(){
                $('.portlet').removeClass('active');
                $(this).addClass('active');
                var placement = $(this).parent().attr('placement');
                //console.log('What was the original placement  '+ placement);
            })
        }
    