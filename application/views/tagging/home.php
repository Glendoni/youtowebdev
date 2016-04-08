<style>


ol,
ul { list-style: outside none none; }

#container {
  margin: 0 auto;
  width: 60rem;
}


p { color: #ccc; }

h1 {
  color: #6b6b6b;
  font-size: 1.5em;
}
    
    .form-control{
        
        
        text-transform: capitalize;
    }
    
    .cr_switch_title{
        display:;
        
    }
    
    .addTagBtn{
        
        display:none;
        
    }
</style>

<!-- Parent Category-->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default cr_switch create">
        <div class="panel-heading profile-heading" style="background-color: #FC6F65;">
          
            <h3 class="tagtitle">&nbsp;</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php  
            $attributes = array( 'class'=>'form-horizontal new_category');
            $hidden = array();
            echo form_open('/add_category',$attributes,$hidden); 
            ?>
            <div class="form-group">

                <div class="col-sm-6">
                    <label class="control-label itemName" for="name" >Category Name</label>
                    <input type="text" class="form-control"  required="required" name="name" id="name" placeholder="" value="<?php echo isset($_POST['name'])?$_POST['name']:''; ?>"><span class="catError catName"></span>
                </div>

                <div class="col-sm-3">
                    <label for="emp_count" class="control-label">Effective From</label>
                    <?php

                    $catStatus = array('opt1'=>'active','opt2'=>'non-active' );
                    //echo form_dropdown('company_class', $catStatus, (isset($_POST['company_class'])?$_POST['company_class']:'') ,'class="form-control"');
                    ?>
                    <input type="text" class="form-control follow-up-date planned_at" required="required" id="eff_from" data-date-format="DD-MM-YYYY" name="eff_from" placeholder="date"><span class="catError eff_from"></span>
                </div>


                <div class="col-sm-3">
                    <label for="emp_count" class="control-label">Effective To (optional)</label>
                    <?php

                    $catStatus = array('opt1'=>'active','opt2'=>'non-active' );
                    // echo form_dropdown('company_class', $catStatus, (isset($_POST['company_class'])?$_POST['company_class']:'') ,'class="form-control"');
                    ?>
                    <input type="text" class="form-control follow-up-date planned_at" data-date-format="DD-MM-YYYY" id="eff_to" name="eff_to" placeholder="Date">
                    <span class="catError eff_to"></span>
                </div>
            </div>


            <div class="form-group"> 
                <div class="modal-footer">
                    
                    <input type="hidden" name="itemid" value="" id="itemid" >
                    <input type="hidden" name="masterID" value="" id="master" >
                    <input type="hidden"   value="" id="activeform" >
                    <button type="submit" id="sender" class="btn btn-primary btn-block submit_value">Save</button>
                </div>
            </div>

<?php echo form_close(); ?>
            
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
      
      
    </div>
</div>
<div class="row" >
 
    <div class="panel-body">
        <div class="panel-heading profile-heading" style="background-color: #FC6F65;">
           <button style="float:right; margin-top: -9px;
"  class="btn btn-primary addTagBtn ">Add  Tag</button>
            <h3 class="tagstitle">&nbsp;</h3>
        </div>
        <div class="col-sm-12" style="background-color: #FFFFFF;" id="listings"> 
  <ul class="tags">  
    <li class="tagAdd taglist">
      <input type="text" id="tags-field">
    </li>
  </ul>
   
</div>

  
</div>
</div>
    <div class="row">
    <div class="col-lg-12">
        <div class="panel-heading profile-heading" style=" background-color: #FC6F65;">

        <h3>Category</h3>
        </div>
 
            
            <div class="col-sm-12"> 
             <table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
        
      <th>MaCategory</th>
      <th colspan="2">Sub Category</th>
    
        <th colspan="2">Edit</th>
    </tr>
  </thead>
  <tbody id="tagCatList" >
 
  
  </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>
      
      <p>&nbsp;</p>
 

    

 <?=$jq;?>
 
  </div>
    
</div>

<script type="text/javascript" src="<?=$test?>"></script>
 
 