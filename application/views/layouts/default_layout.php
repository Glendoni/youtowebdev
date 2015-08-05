<?php $this->load->view('layouts/header'); ?>
<div id="<?php if(!isset($hide_side_nav)): ?>page-wrapper<?php endif; ?>">
    <div class="container-fluid">
   
	<?php  $this->load->view($main_content); ?>
	</div>
</div>
<?php $this->load->view('layouts/footer'); ?>