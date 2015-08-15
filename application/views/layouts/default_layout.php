<?php $this->load->view('layouts/header'); ?>
<!--<div id="<?php if(!isset($hide_side_nav)): ?>page-wrapper<?php endif; ?>">-->
<div id="single-page">
    <div class="<?php if(isset($full_container)): ?>container-fluid<?php else: ?>container<?php endif; ?>">
	<?php  $this->load->view($main_content); ?>
	</div>
</div>
<?php $this->load->view('layouts/footer'); ?>