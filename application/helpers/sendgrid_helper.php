<?php require 'vendor/autoload.php';

function send_me(){
     
 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"personalizations\": [{\"to\": [{\"email\": \"gsmall@sonovate.com\"}]}],\"from\": {\"email\": \"gsmall@sonovate.com\"},\"subject\": \"Hello, World!\",\"content\": [{\"type\": \"text/plain\", \"value\": \"Heya!\"}]}",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer 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",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: aace37d3-78f2-5145-6ca7-1281f1de206b"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
    
}
