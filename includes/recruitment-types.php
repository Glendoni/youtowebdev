<?php
$rectypesql = "SELECT contract,perm from business where id = '".$business_id."'";
$rectyperesult=pg_query($con,$rectypesql);
while($rectyperow = pg_fetch_array($rectyperesult)) {
 $hascontract = $rectyperow['contract'];
 $hasperm = $rectyperow['perm'];
};
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" id="update-tags">
<input type="hidden" name="id" value="<?php echo $business_id;?>">
<input type="hidden" name="updaterectypes" value="1">

<div class="tag-holder">  
  <span class="button-checkbox" id="contract">
        <button type="button" class="btn" data-color="primary"  id="contract">Contract</button>
         <input type="checkbox" name="contract" value="1" id="contract" class="hidden" <?php if ($hascontract =='1') {
			 echo "checked";
		 }
		 ?> >
    </span>
      <span class="button-checkbox" id="contract">
        <button type="button" class="btn" data-color="primary"  id="permanent">Permanent</button>
         <input type="checkbox" name="perm" value="1" id="permanent" class="hidden" <?php if ($hasperm ==='1') {
			 echo "checked";
		 }
		 ?>  >
    </span>
    </div>

