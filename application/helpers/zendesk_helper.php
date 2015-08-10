<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function add_to_zendesk($company_name){
	echo $company_name;
$ch = curl_init();
$username = 'dchapple@sonovate.com';
$password = '25Million';
//curl_setopt($ch, CURLOPT_URL, "https://sonovate.zendesk.com/api/v2/organizations.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
echo $body = '{"organization": {"name": $company_name}}';							
curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Connection: Keep-Alive'
));
$result=curl_exec($ch);
$data = json_decode($result, true);
$data["organization"]["id"]; // "John"
curl_close($ch);
}