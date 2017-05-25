<?php require 'vendor/autoload.php';

function send_grid_mailer($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){

$request_body = json_decode('{
  "personalizations": [
    {
      "to": [
        {
          "email": "'.$contact_email.'"
        }
      ],
      "subject": "'.$subject.'"
    }
  ],
  "from": {
    "email": "'.$sender_email.'"
  },
  "content": [
    {
      "type": "text/html",
      "value": "'.str_replace('\'', '&apos;', $email_body).'"
    }
  ],
  "template_id": "49dd101c-ec16-4636-bbb4-a9f2b067b7a9"
}');
  
    
     if(ENVIRONMENT != 'development'){
      $apiKey = SEND_GRID_API_KEY;
    }else{
         $apiKey = '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';
    }
    
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($request_body);
return $response->statusCode();
//echo $response->body();
//print_r($response->headers());
    
}
 