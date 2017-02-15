  
<div class="row messageprev">
    <div class="col-lg-12">
        <div class="panel panel-default cr_switch create">
            <div class="panel-heading profile-heading">
                   <button type="submit" style="float:right;margin-top: -9px;" class="btn btn-primary addnewuser">Add User</button>
                <h3 class="tagtitle">User</h3>
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body panel-green">    
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 
                 
                 <form action="javascript:;"   id="submit_user" class="form-horizontal edit"  role="form">
		<div class="form-group">
            <legend><span class="userverbiagechange">Add</span> User</legend>
		</div>
 
   
	 <div class="form-group col-md-6">
                <label>Full Name *</label>
		<input type="text" class="form-control freset fresetname"  required="required" name="name" id="name" placeholder="Name">
	</div>
                     
           
                     
                           <div class="form-group col-md-6">
                  <label for="sel1">Role *</label>
                  <select class="form-control " name="role" required="required" id="role" >
                   <option value="">Please Select</option>
                  </select>
                </div> 
                     
                     
                     <div class="form-group col-md-6">
                <label>Email *</label>
		<input type="email" class="form-control freset"  required="required"   name="email" id="email" placeholder="Email">
	</div>
                     
           
                     
                     <div class="form-group col-md-6">
                <label>Mobile/Phone</label>
		<input type="number" class="form-control freset" name="mobile" id="mobile" placeholder="Mobile">
	</div>
                     <!--
                     <div class="form-group col-md-6">
                <label>LinkedIn Username</label>
		<input type="text" class="form-control freset"  name="linkedin" id="linkedin" placeholder="LinkedIn">
	</div>

-->

                       <div class="form-group col-md-6">
                  <label for="sel1">Department *</label>
                  <select class="form-control" name="department" required="required" id="department" >
                   <option value="">Please Select</option>
                  </select>
                </div>  
                 
   <div class="form-group col-md-3">
          <label for="sel1">Effective From Date *</label>
                       <input type="text" class="form-control follow-up-date planned_at planned_atdefault freset" value="" required="required" data-date-format="DD-MM-YYYY" id="eff_from" name="eff_from" placeholder="Active From Date">
              
                     </div>
                     
                  <div class="form-group col-md-3">
          <label for="sel1">Effective To Date </label>
                       <input type="text" class="form-control follow-up-date planned_at freset"   data-date-format="DD-MM-YYYY" id="eff_to" name="eff_to" placeholder="Active To Date">
          <input type="hidden" id="formstatus"   data="addUser">
                <input type="hidden" name="id" id="id" value="">  
                     </div>
                     
                     
                        <div class="form-group">
                            <div class="col-sm-6 ">
                        
                                <input type="submit"  value="Save" class="btn btn-primary "> 
                                <!--<input type="button"  value="Send Reminder To Change Temporary Password " class="btn btn-success emailuser"> -->
                            </div>
                            
                           <div class="col-sm-6 ">
                        
                                <div class="user_management_uf_np checkbox">
	<label>
		<input type="radio" name="market" class="market" value="np">
		First to Finance
	</label>
 
                                                                
	<label>
		<input type="radio" name="market" class="market" value="uf">
		Using Finance
	</label>
</div>


                            </div>
                            
                                      <div class="col-xs-6" style="text-align:right;">
                                            <span id="created_by_name"></span>
                                          <br><span id="temp_password"></span>
                                          <span id="updated_by_name"></span>
                                          

                                    </div>
                        </div>
</form> 
                    
             </div>
                
                
      

       </div>
            <!-- /.panel-body -->

        </div>
        <!-- /.panel -->
    </div>
</div>



 

 


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default cr_switch create">
         <div class="panel-heading profile-heading">
            <h3>Users</h3>
        </div>
                <!-- /.panel-heading -->
            <div class="panel-body panel-green usrheader ">    
             
                  <div class="col-lg-12"><div class="col-md-3"><strong>User</strong></div>
                        <div class="col-xs-5 col-sm-5 col-md-2"><strong>Effective From</strong></div>
                        <div class="col-xs-5 col-sm-5 col-md-2"><strong>Effective To</strong></div>
                      
                      <div class="col-xs-5 col-sm-5 col-md-2"><strong>Department</strong></div>
                      
                        <div class="col-xs-5 col-sm-5 col-md-2"><strong>Role</strong></div>
                      
                      <div class="col-xs-2 col-sm-3 col-md-1"></div><br><hr/>
                    <div id="users"></div>
                      
                      <ul id="pagin">

</ul>
             </div>
       </div>
            <!-- /.panel-body -->

        </div>
        <!-- /.panel -->
    </div>
</div>


 


<p>&nbsp;</p>

