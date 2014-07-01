<?php
session_start();
if(! isset($_SESSION['myusername']) ){
}
?>
<?php include('connection.php'); ?>
<?php 
$id = $_GET['id'];
$endlink = $_GET['link'];
$addtobasesql = "update business set base = 1 where id = '$id'";
pg_query($con,$addtobasesql);
$result = pg_query($con,"SELECT * from business where id = '$id'");
 while ($row = pg_fetch_assoc($result)) {
         		 $companyname = $row["name"];
				 $industry = $row["sector"];
				 $country = $row["country"];
				 $finance = "Finance Provider: ".$row["provider"];
				 $address = $row["address"];
}
?>

<?php
		#} Contact Form Posted

		#} Validate request
		$validRequest = true;

			#} Get Vars
			$posted = array();
			$posted['bcmPhone'] 		= $_POST['lead-phone'];
			$posted['bcmEmail'] 		= $_POST['lead-email'];
			$posted['bcmCountry'] 		= $_POST['lead-country'];
	
			#} Get Options
			$bmcConfig = array();
			$bmcConfig['bmc_customcontact_email'] = "nharriman@sonovate.com";					#Default: ""
			$bmcConfig['bmc_customcontact_base_username'] ="nharriman@sonovate.com";			#Default: ""
			$bmcConfig['bmc_customcontact_base_userpass'] ="OzzyElmo$1";
			$bmcConfig['bmc_customcontact_base_dealName'] =$posted['bcmName']." Deal";			#Default: "contactForm"

			#} Try and split name
				$nameParts = explode(' ',$posted['bcmName']);
				if (count($nameParts) == 2){
					$firstName 	= $nameParts[0];
					$lastName 	= $nameParts[1];

				} else {
					if (count($nameParts) == 1){
						$firstName = $posted['bcmName'];
						$lastName = '';
					} else {
						#Not a straight forward split :/ Probably Dr. Joe Blogs or smt
						$lastName 	= array_pop($nameParts);
						$firstName 	= implode(' ',$nameParts);
					}
				}

			#} Save to Base (inc google cookie)
				require_once('base-config.php');

				#} Get base auth
				$baseToken = base_getAuth($bmcConfig['bmc_customcontact_base_username'],$bmcConfig['bmc_customcontact_base_userpass']);

				if (!empty($baseToken)){
$name="Test";
						#} If company, add it:
						if (!empty($name))
							$companyBaseContactID = base_addCompany($baseToken,$companyname,$industry,$country,$finance,$address);
						else
							$companyBaseContactID = '';

						#} Create contact

							#} Last name is required, if theres only a first then put "?"
							if (empty($lastName)) $lastName = '?';

							#} Actual API call
							$contactBaseID = base_addIndividual($baseToken,$lastName,$firstName,$companyBaseContactID,$posted['bcmPhone'],$posted['bcmMobile'],$posted['bcmEmail'],$posted['bcmCountry']);

		

							#} Build baseStr
							$baseStr = '';
							if (!empty($companyBaseContactID)) 	$baseStr .= 'Company record created, ID: '.$companyBaseContactID.'<br />';
							if (!empty($contactBaseID)) 		$baseStr .= 'Contact record created, ID: '.$contactBaseID.'<br />';
							if (!empty($noteID)) 				$baseStr .= 'Note added to contact, ID: '.$noteID.'<br />';
							if (!empty($dealID)) 				$baseStr .= 'Deal record created, ID: '.$dealID.'<br />';
							if (!empty($sourceID)) 				$baseStr .= 'Source record created/found, ID: '.$sourceID.'<br />';



				} else $baseStr = 'There was a problem connecting to Base.';


	?>
<script>window.close();</script>