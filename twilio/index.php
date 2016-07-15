<?php
// Install the library via PEAR or download the .zip file to your project folder.
// This line loads the library
require('Services/Twilio.php');

$sid = "PN31ee3b895ad9eb2bd34fa3496d03f907"; // Your Account SID from www.twilio.com/user/account
$token = "a0e60f034ba2e74a1230f444b1f18691"; // Your Auth Token from www.twilio.com/user/account

$client = new Services_Twilio($sid, $token);
$message = $client->account->messages->sendMessage(
  '+441488760052', // From a valid Twilio number
  '07834077855', // Text this number
  "Hello monkey!"
);

print $message->sid;