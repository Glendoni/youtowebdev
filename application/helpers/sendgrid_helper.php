<?php require 'vendor/autoload.php';

function send_me($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com",$apiKey){
     
    
$from = new SendGrid\Email(null, $sender_email);
$subject = $subject;
$to = new SendGrid\Email(null, $contact_email );
$content = new SendGrid\Content("text/html", $email_body);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
 
    
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
