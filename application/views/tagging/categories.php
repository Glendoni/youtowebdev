<style>
body { font-family: tahoma; }

ol,
ul { list-style: outside none none; }

#container {
  margin: 0 auto;
  width: 60rem;
}

.tags {
  background: none repeat scroll 0 0 #fff;
  border: 1px solid #ccc;
  display: table;
  padding: 0.5em;
  width: 100%;
}

.tags li.tagAdd,
.tags li.addedTag {
  float: left;
  margin-left: 0.25em;
  margin-right: 0.25em;
}

.tags li.addedTag {
  background: none repeat scroll 0 0 #428BCA;
  border-radius: 5px;
    font-size:11px;
  color: #fff;
  padding: .5em;
        margin-bottom: 5px;
}

.tags input,
li.addedTag {
  border: 1px solid transparent;
  border-radius: 5px;
  box-shadow: none;
  display: block;
  padding: 0.5em;
}

.tags input:hover { border: 1px solid #000; }

span.tagRemove {
  cursor: pointer;
  display: inline-block;
  padding-left: 0.5em;
}

span.tagRemove:hover { color: #222222; }


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
</style>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">



<!-- Parent Category-->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default cr_switch create">
        <div class="panel-heading profile-heading" style="background-color: #FC6F65;">
            <h3 style="float: right;" class="cr_switch_title">Add Sub Section</h3>
            <h3 class="tagtitle">Create Category</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php  
            $attributes = array( 'class'=>'form-horizontal new_category');
            $hidden = array('user_id'=>$current_user['id']);
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
                    <input type="text" class="form-control follow-up-date planned_at" required="required"  data-date-format="YYYY/MM/DD H:m" name="eff_from" placeholder="date"><span class="catError eff_from"></span>
                </div>


                <div class="col-sm-3">
                    <label for="emp_count" class="control-label">Effective to (optional)</label>
                    <?php

                    $catStatus = array('opt1'=>'active','opt2'=>'non-active' );
                    // echo form_dropdown('company_class', $catStatus, (isset($_POST['company_class'])?$_POST['company_class']:'') ,'class="form-control"');
                    ?>
                    <input type="text" class="form-control follow-up-date planned_at" data-date-format="YYYY/MM/DD H:m" name="eff_to" placeholder="">
                    <span class="catError eff_to"></span>
                </div>
            </div>


            <div class="form-group"> 
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                </div>
            </div>

<?php echo form_close(); ?>
            





            
        </div>
        <!-- /.panel-body -->
        
       
    </div>
    <!-- /.panel -->
      
      
    </div>
</div>



    <div class="row">
    <div class="col-lg-12">
        <div class="panel-heading profile-heading" style=" background-color: #FC6F65;">

        <h3>Category List</h3>
        </div>
 
            
            <div class="col-sm-12"> 
             <table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
        
      <th>Category</th>
      <th>Sub Category</th>
    <th>Sub Category 2</th>
        <th>Edit</th>
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
      <div  ></div>
      
      
      
      
      
      
 
    
<div id="container" style="margin-top:10px;">
  <h1>Sonovate Tagging</h1>
  <ul class="tags">
      <li class="addedTag"><span class="tagName">Residential</span><span onclick="$(this).parent().remove();" class="tagRemove">x</span>
      <input type="hidden" name="tags[]" value="Residential">
    </li>
      <li class="addedTag"><span class="tagName">More Than 12 Contacts</span><span onclick="$(this).parent().remove();" class="tagRemove">x</span>
      <input type="hidden" name="tags[]" value="More Than 12 Contacts">
    </li>
      <li class="addedTag"><span class="tagName" >Moving To New Location</span><span onclick="$(this).parent().remove();" class="tagRemove">x</span>
      <input type="hidden" name="tags[]" value="Moving To New Location">
    </li>
    <li class="tagAdd taglist">
      <input type="text" id="tags-field">
    </li>
  </ul>
</div>
 <?=$jq;?>
<script>
    $(document).ready(function() {

    editName();
    $('#addTagBtn').click(function() {
            $('#tags option:selected').each(function() {
                $(this).appendTo($('#selectedTags'));
            });
        });
        $('#removeTagBtn').click(function() {
            $('#selectedTags option:selected').each(function(el) {
                $(this).appendTo($('#tags'));
            });
        });
    $('.tagRemove').click(function(event) {
            event.preventDefault();
            $(this).parent().remove();
        });
        $('ul.tags').click(function() {
            $('#tags-field').focus();
        });
        $('#tags-field').keypress(function(event) {
            if (event.which == '13') {
                if ($(this).val() != '') {
                    $('<li class="addedTag"><span class="tagName">' + $(this).val() + '</span><span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + $(this).val() + '" name="tags[]"></li>').insertBefore('.tags .tagAdd');
                    $(this).val('');

                    editName();
                }
            }
        });

    });
    
  
</script>
  </div>
    
</div>

<script type="text/javascript" src="<?=$test?>"></script>


 