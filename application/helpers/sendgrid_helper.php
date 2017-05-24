<?php require 'vendor/autoload.php';

function send_me(){
     
    $apiKey =  $apiKey = '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';
$from = new SendGrid\Email("gsmall@sonovate.com");
$subject = "Sending with SendGrid is Fun";
$to = new SendGrid\Email("Example User", "gsmall@sonovate.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

//$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
print_r($response->headers());
echo $response->body();
    
}
