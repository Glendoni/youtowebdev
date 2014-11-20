<div class="assign-to-wrapper ">
	<button  class="btn btn-info edit-btn" data-toggle="modal" id="create_contact_<?php echo $company['id']; ?>"  data-target="#create_contact_<?php echo $company['id']; ?>" >
        <span class="ladda-label"> <i class="fa fa-plus"></i> Contact </span>
    </button>
	<button class="btn btn-warning  edit-btn" data-toggle="modal" id="editbtn<?php echo $company['id']; ?>"  data-target="#editModal<?php echo $company['id']; ?>">
        <span class="ladda-label"> Edit </span>
    </button> 
	<?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
		<?php if($company['assigned_to_id'] == $current_user['id']) : ?>			
			<?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
			echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
			<button type="submit" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
			    <span class="ladda-label"> Unassign from me </span>
			</button>
			<?php echo form_close(); ?>
		<?php endif; ?>
	<?php else: ?>
	<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
	echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
	<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
        <span class="ladda-label"> Assign to me </span>
    </button>
	<?php echo form_close(); ?>
	<?php endif; ?>
</div>