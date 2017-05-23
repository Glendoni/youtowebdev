<?php require 'vendor/autoload.php';

function send_me($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){
     
    
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


-Added server environmental variable to read API key.
Sonovate/BaseList: Pull Request 31 - send_grid_pure

- Enables a user to add number of employee(s) and estimated company turnover to a company. Information added is then presented on the associated company details page.
Sonovate/BaseList: Pull Request 29 - emp_turnover_v1

- Sonovate/BaseList: Pull Request 30 -