<?php


$data = '{
  "event": "contact_added",
  "contact_id": "person_ED75BA78-2405-4564-B24C-F2B8F936C7C6",
  "contact": {
      "MailingPostalCode": "94913",
      "FirstName": "Tom",
      "Title": "CEO",
      "LastName": "Greyson",
      "LinkedIn": "tomgreyson",
      "owner_name": "James McKinsey",
      "MailingState": "CA",
      "Email": "trgreyson@gmail.com",
      "Website": "greysondesigns.com",
      "Fax": "3736162442",
      "NumberOfEmployees": 3000,
      "Company": "Greyson Designs",
      "Phone": "3738482121",
      "unsubscribed": false,
      "MailingCity": "San Rafael",
      "owner_first_name": "James",
      "Status": "Nurture",
      "MailingStreet": "Kendra Way",
      "MailingCountry": "United States",
      "Industry": "Technology",
      "LeadSource": "Trial Signup",
      "MobilePhone": "2345456677",
      "Twitter": "trgreyson",
      "Salutation": "Mr."
  }
}';

$data = 'I was trggered by Auto Pilot';
file_put_contents('hook.txt', $data);
echo '...';