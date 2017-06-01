<?php require 'vendor/autoload.php';

function send_grid_mailer($contact_email =  "gsmall@sonovate.com", $subject ="Who you looking at you mook", $email_body = "<p>Test message</p>", $sender_email = "gsmall@sonovate.com", $attachments =false){

 $a[] = '{
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
  ],';
    
    if(count($attachments) >=1){
        
        $a[] = '"attachments": [';
        foreach($attachments as $key => $file_info){
           $b[] =  '{
           "content" : "'.base64_encode(file_get_contents($file_info['full_path'])).'",
            "content_id": "'.$file_info['raw_name'].'_'.date('Y-m-d').'",    
            "disposition": "inline", 
            "filename": "'.$file_info['file_name'].'", 
            "name": "'.$file_info['orig_name'].'",
            "type": "'.$file_info['file_ext'].'"
                } ';
            
            unlink($file_info['full_path']);
        }        
        $a[] = join($b,",");
        $a[] ='],';
    }
    
    $a[] = '"template_id": "49dd101c-ec16-4636-bbb4-a9f2b067b7a9"
    }';
  
    
    $request_body =  join($a,"");  
    
    
    $request_body = json_decode($request_body);
    
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
 