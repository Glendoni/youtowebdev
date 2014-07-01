<?php
function base_getAuth($e,$p){
$e = "nharriman@sonovate.com";
$p = "OzzyElmo$1";  
$url = 'https://sales.futuresimple.com/api/v1/authentication.json';
$tokenJsonResponse = wCURL($url,array('email'=>$e,'password'=>$p));
$jsonToken = json_decode($tokenJsonResponse);
if (isset($jsonToken->authentication->token)) return $jsonToken->authentication->token; else return false;
}
	
function base_addCompany($token,$companyname,$industry,$country,$finance,$address){
$url = 'https://sales.futuresimple.com/api/v1/contacts.json';
$postArr = array('contact'=>array('name'=>$name,'is_organisation'=>true));
$postArr['contact']['name'] =$companyname;
$postArr['contact']['address'] = $address;
$postArr['contact']['industry'] = $industry;
$postArr['contact']['country'] = $country;
$postArr['contact']['tag_list'] = $finance;
$postArr['contact']['address'] = $address;



			$jsonResponse = wCurl($url,$postArr,array('X-Pipejump-Auth'=>$token));
			$jsonContact = json_decode($jsonResponse);
			if (isset($jsonContact->contact->id)) return $jsonContact->contact->id; else return false;		
}
	
	#} Added for api contact
	function wCURL($url, $post = null, $headers = null, $retries = 3) 
	{
		$curl = curl_init($url);
	
		if (is_resource($curl) === true)
		{
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);#use facebook default
			
			if (isset($headers)){
			
				if (is_array($headers)) {
					
					foreach ($headers as $name => $val)
						curl_setopt($curl, CURLOPT_HTTPHEADER,	array($name.': '.$val));
					
				} else curl_setopt($curl, CURLOPT_HTTPHEADER,	array($headers));
	
			}	
			
			if (isset($post) === true)
			{
				if (!empty($post)){
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($post) === true) ? http_build_query($post, '', '&') : $post);
				}
			}
	
			$result = false;
	
			while (($result === false) && (--$retries > 0))
			{
				$result = curl_exec($curl);
			}
			
			curl_close($curl);
		}
		
		return $result;
	}
	
	function wObjectToArray( $object )
		{
			if( !is_object( $object ) && !is_array( $object ) )
			{
				return $object;
			}
			if( is_object( $object ) )
			{
				$object = get_object_vars( $object );
			}
			return array_map( 'wObjectToArray', $object );
		}

?>
<script>window.close();</script>