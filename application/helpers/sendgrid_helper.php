<?php require 'vendor/autoload.php';

function _send_me($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){
     
    
$from = new SendGrid\Email(null, $sender_email);
$subject = $subject;
$to = new SendGrid\Email(null, $contact_email );
$content = new SendGrid\Content("text/html", $email_body);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
    
    
    if(ENVIRONMENT == 'development'){
      $apiKey = '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';
    }else{
      $apiKey = SEND_GRID_API_KEY;
    }
    
$sg = new \SendGrid($apiKey);

try {
    $response = $sg->client->mail()->send()->post($mail);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

return $response->statusCode();
//echo $response->headers();
//echo $response->body();
    
}


function send_me__($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){
     
    
// If you are not using Composer
// require("path/to/sendgrid-php/sendgrid-php.php");

$request_body = json_decode('{
  "personalizations": [
    {
      "to": [
        {
          "email": "gsmall@sonovate.com"
        }
      ],
      "subject": "Sending with SendGrid is Fun"
    }
  ],
  "from": {
    "email": "gsmall@sonovate.com"
  },
  "content": [
    {
      "type": "text/html",
      "value": "'.$email_body.'"
    }
  ],
  "template_id": "49dd101c-ec16-4636-bbb4-a9f2b067b7a9"
}');

//$apiKey = getenv('SENDGRID_API_KEY');
$apiKey = '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';    
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($request_body);
echo $response->statusCode();
echo $response->body();
print_r($response->headers());
    
}
function send_me($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){
     
// If you are not using Composer
// require("path/to/sendgrid-php/sendgrid-php.php");

$from = new SendGrid\Email(null, "gsmall@sonovate.com");
$subject = "I'm replacing the subject tag";
$to = new SendGrid\Email(null, "gsmall@sonovate.com");
$content = new SendGrid\Content("text/html", $email_body);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$mail->personalization[0]->addSubstitution("-name-", "Example User");
$mail->personalization[0]->addSubstitution("-city-", "Denver");
$mail->setTemplateId("49dd101c-ec16-4636-bbb4-a9f2b067b7a9");

//$apiKey = getenv('SENDGRID_API_KEY');
$apiKey = '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'; 
$sg = new \SendGrid($apiKey);

try {
    $response = $sg->client->mail()->send()->post($mail);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo $response->statusCode();
print_r($response->headers());
echo $response->body();
    
}
//Template_20170524154530360