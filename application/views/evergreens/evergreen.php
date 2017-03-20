

      <div class="panel-default panel-heading " style="
    background-color: #2B4461;
#2B4461
    color: #fff;
    color: #fff;
">
          <button type="submit" style="float:right;margin-top: -9px;" class="btn btn-primary add_evg_user get_evegreen_results_users">Add User</button>
              <h3 class="panel-title">Evergreens<span class="badge pull-right">13</span></h3>
              </div>




<div class="row record-holder-header get_evegreen_results" style="font-size: 12px;">
    <div class="col-md-3" style=""><strong>Campaign Description</strong></div>
            <div class="col-md-2" style="">
            <strong>Date Created</strong></div>
            <div class="col-md-1"><strong>Users</strong></div>
            <div class="col-md-4"><strong>Updated At</strong></div>
            <div class="col-md-1  "><strong></strong></div>
            <div class="col-md-1 "><strong></strong></div>
    </div>



<div class="row record-holder-header get_evegreen_results_users" style="font-size: 12px;">
    <div class="col-md-3" style=""><strong>Users</strong></div>
            <div class="col-md-2" style="">
            <strong>Campaign Description</strong></div>
            <div class="col-md-2"><strong>Created At</strong></div>
          
    </div>

<div id="get_evegreen_results"></div>



<div id="get_evegreen_results_detail">
<form action="javascript:;" method="post" class="form-horizontal" id="evegreen_form">
<fieldset>

<!-- Form Name -->
 

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Description</label>  
  <div class="col-md-4">
  <input id="textinput" name="description" type="text" placeholder="eg: Sales - FF Fresh" class="form-control input-md evg_description">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="max_allowed">Max Allowed</label>  
  <div class="col-md-4">
  <input id="max_allowed" name="max_allowed" type="text" placeholder="eg: 1000" class="form-control input-md evg_max_allowed" required="">
        <input   name="id" type="hidden"  value="" id="evg_id" class="form-control input-md evg_id" required>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">SQL</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="evg_sql" name="sql" style="margin: 0px -288.344px 0px 0px;height: 350px;width: 674px;"></textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-8">
    <button  name="" id="evg_save" class="btn btn-success evg_save">Save</button>
    <button id="button2id" name="button2id" class="btn btn-danger evg_cancel">Cancel</button>
  </div>
</div>

</fieldset>
</form>


</div>
    
        

<div id="get_evegreen_results_users"></div>

<div id="add_evegreen_results_detail">
<form action="javascript:;" method="post" class="form-horizontal" id="add_user_to_campaign">
<fieldset>

<!-- Form Name -->
 

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
        

        
        
        
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Description</label>  
  <div class="col-md-4">
 <select id="description_dropdown" class="form-control"></select>
    
  </div>
</div>

        
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="max_allowed">User</label>  
  <div class="col-md-4">
  <select   class="form-control" value="" name="user_evergreen_dropdown_id" id="user_evergreen_dropdown"></select>
        <input   name="id" type="hidden"  value="" id="evg_id_ropdown" class="form-control input-md evg_id" required>
    
  </div>
</div>
 
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-8">
    <button  name="" id="evg_save" class="btn btn-success evg_add_user_save">Save</button>
    <button id="button2id" name="button2id" class="btn btn-danger evg_cancel">Cancel</button>
  </div>
</div>

</fieldset>
</form>


</div>    
    
    
    

   


</div>
 