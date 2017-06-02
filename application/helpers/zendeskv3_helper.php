<?php require 'vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function create_zd_user($contact_id,$contact_name, $zendesk_id, $contact_email)
{
    
    
    $subdomain = getenv('ZENDESK_API_SUBDOMAIN');
    $username  = getenv('ZENDESK_API_USERNAME'); // replace this with your registered email
    $token     = getenv('ZENDESK_API_KEY');

    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);
    
   try {
                    $query = $client->users()->create(
                        [
                        'id' => $contact_id,
                        'name' => $contact_name,
                        'organization_id' => $zendesk_id,
                        'email' => $contact_email,
                        'role'  => 'end-user',
                        'user_type' => 'agency',
                        ]
                    );
                    
        } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
            echo 'Please check your credentials. Make sure to change the $subdomain, $username, and $token variables in this file.';
        }
    
}


function sonovate_zendesk($zd_id,$company_id = false,$output =false, $action='', $domain = false)
{
   
    $subdomain = getenv('ZENDESK_API_SUBDOMAIN');
    $username  = getenv('ZENDESK_API_USERNAME'); 
    $token     = getenv('ZENDESK_API_KEY'); 
 
    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);

    switch ($action){
                     case "create_a_new_organisation":
            try { 
                    $newOrganzation = $client->organizations()->create(array(
               
                   'domain' => $domain,
                    'name' => $output['name'],
                    'external_id' => $output['registration'],
                    'domain_names' => $domain,
                    'organization_fields'  => [
                    'company_registration' => $output['registration'],
                         'baselist_id' => $output['id'],
                             'name' =>  $output['name']
                        ]
                    ));

                    return $newOrganzation;
                 } catch (Exception $e) {
                   echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
          break;
                    case  "get_all_tickets_regarding_a_specific_user":
                
                                $sorter = array('sort_by' => 'created_at',
                            'sort_order' => 'asc',
                            'status'=> 'open'
                           );
                try {
                        $tickets = $client->organizations($zd_id)
                            ->tickets()
                            ->findAll($sorter);
 
                        return json_encode($tickets);  
                    } catch (Exception $e) {
                        return json_encode($e->getMessage());
                    } finally {
                    }
            break;  
        } 
}