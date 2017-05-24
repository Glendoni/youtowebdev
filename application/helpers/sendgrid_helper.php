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


function send_me($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){
     
    
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
      "value": "'.str_replace('\'', '&apos;', $email_body).'"
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
function send_me__($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com"){
     
// If you are not using Composer
// require("path/to/sendgrid-php/sendgrid-php.php");

$from = new SendGrid\Email(null, "gsmall@sonovate.com");
$subject = "I'm replacing the subject tag";
$to = new SendGrid\Email(null, "gsmall@sonovate.com");
$content = new SendGrid\Content("text/html", "Hi Glendon,<br /> <br /> Thank you for your time today.<br /> <br /> As discussed please do keep us in mind for the future if you look to run any contractors.<br /> <br /> We have been set up specifically for the recruitment industry and we do not structure finance like the current Invoice Discounting or Factoring products out there.<br /> <br /> We understand what is important to recruitment agencies so we have removed the risk, hassle and other barriers associated with running contractors.<br /> <br /> Here are some key reasons why agencies are using Sonovate to assist them in placing contractors.<br /> <br /> <b>Ease of Entry</b><br /> By removing unnecessary barriers to entry Sonovate compliments a permanent offering exceptionally. We understand set-up fees, personal guarantees and long contracts are needless barriers to prospective agencies, which is why Sonovate does not require any of these.<br /> <br /> <b>Cashflow</b><br /> As your contract business grows, so will the pressure on your business’s cashflow and its potential problems. We alleviate the pressure by releasing 100;% of your profit the week after a timesheet is approved, paying contractors on your behalf, and securing the money from your clients.<br /> <br /> <b>Technology Eliminating Contract Administration</b><br /> As a business that has traditionally supplied permanent or executive search services, the prospect of running contractors can be daunting from an administrative point of view. Using Sonovate means you don't need to worry about back-office related headaches. Included in our offering: Flexible finance, credit control, online timesheets, invoicing, candidate payroll and a cloud based portal to monitor your contract business.<br /> <br /> I have attached the following documents which explain:<br /> <br /> - How Sonovate works<br /> - How Sonovate compares to other providers<br /> <br /> Also have a look at our website which has more detail - www.sonovate.com<br /> <br /> Please feel free to email or call if you have any questions.<br /> <br /> <br /> <br /> <br />");
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