<?php $this->load->view('layouts/header'); ?>
<div id="single-page">
    <div class="container">
    <?php $msg = $this->session->flashdata('message'); $msg_2 = validation_errors(); if($msg or $msg_2): ?>
        <div class="row alert alert-<?php echo $this->session->flashdata('message_type'); ?> alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php echo $msg ?>
            <?php echo $msg_2 ?>
        </div>
    <?php endif; ?>
	<?php  $this->load->view($main_content); ?>
	</div>
</div>
<?php $this->load->view('layouts/footer'); ?>