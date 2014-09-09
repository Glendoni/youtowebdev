<div class="row page-results-list">
	<h1 class="page-header"><?php echo $company->name; ?></h1>
	<?php 
	// Display companies
	$this->load->view('companies/companies_list.php');
	?>
</div>