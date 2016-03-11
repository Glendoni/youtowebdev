<?php $this->load->view('layouts/header'); ?>
        <?php $msg = $this->session->flashdata('message'); $msg_2 = validation_errors(); if($msg or $msg_2): ?>
    <div class="top-alert">
        <div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?> alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php echo $msg ?>
            <?php echo $msg_2 ?>
        </div>
        </div>
    <?php endif; ?>
    <?php if (!empty($_GET['campaign_id'])):   ?>
            <div class="top-alert">

<div class="return_to_campaign">

<a class="btn btn-default btn-sm" href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $_GET['campaign_id']; ?>" role="button">Return to Campaign</a>
</div>
</div>
<?php endif; ?>
<div id="single-page">
    <div class="container-fluid">
    

	<?php  $this->load->view($main_content); ?>
	</div>
</div>
<?php $this->load->view('layouts/footer'); ?>