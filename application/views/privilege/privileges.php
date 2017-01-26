<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default cr_switch create">
            <div class="panel-heading profile-heading">
                   <button type="submit" style="float:right;margin-top: -10px;" class="btn btn-primary addnewuser">Add User</button>
                <h3 class="tagtitle">User</h3>
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body panel-green">    
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 
                 
                 <form action="javascript:;"   id="submit_user" class="form-horizontal edit"  role="form">
		<div class="form-group">
            <legend><span class="userverbiagechange">Add New</span> User</legend>
		</div>
 
   
	 <div class="form-group col-md-6">
                <label>Full Name *</label>
		<input type="text" class="form-control freset"  required="required" name="name" id="name" placeholder="Name">
	</div>
                     
                     <div class="form-group col-md-6">
                <label>Role *</label>
		<input type="text" class="form-control freset" required="required"  name="role" id="role" placeholder="Role">
	</div>
                     
                     
                     <div class="form-group col-md-6">
                <label>Email *</label>
		<input type="text" class="form-control freset"  required="required"   name="email" id="email" placeholder="Email">
	</div>
                     
           
                     
                     <div class="form-group col-md-6">
                <label>Mobile</label>
		<input type="text" class="form-control freset" name="mobile" id="mobile" placeholder="Mobile">
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
                       <input type="text" class="form-control follow-up-date planned_at freset" required="required" data-date-format="DD-MM-YYYY" id="eff_from" name="eff_from" placeholder="Active From Date">
              
                     </div>
                     
                  <div class="form-group col-md-3">
          <label for="sel1">Effective To Date </label>
                       <input type="text" class="form-control follow-up-date planned_at freset"  data-date-format="DD-MM-YYYY" id="eff_to" name="eff_to" placeholder="Active To Date">
          <input type="hidden" id="formstatus"   data="addUser">
               <input type="hidden"  name="password"  id="password" >       
                     </div>
                     
                     
                        <div class="form-group">
                            <div class="col-sm-6 ">
                        
                                <input type="submit"  value="Submit" class="btn btn-primary"> 
                                <!--<input type="button"  value="Send Reminder To Change Temporary Password " class="btn btn-success emailuser"> -->
                            </div>
                            
                            <div class="col-sm-1 ">
                        
                                
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
            <div class="panel-heading profile-heading" >
                  
                <h3 class="tagtitle">Users</h3>
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body panel-green">    
             
                  <div class="col-lg-12"><div class="col-xs-5 col-sm-5 col-md-5 col-lg-5"><strong>User</strong></div>
                      <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5"><strong>User Group</strong></div>
                      
                      <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2"></div><hr/>
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

