<?php require 'vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
function sonovate_zendesk($zd_id,$company_id = false,$output =false, $action='', $domain = false)
{
   
    $subdomain = getenv('ZENDESK_API_SUBDOMAIN');
    $username  = getenv('ZENDESK_API_USERNAME'); 
    $token     = getenv('ZENDESK_API_KEY');     
    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);

    switch ($action){
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
