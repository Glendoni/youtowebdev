<?php require 'vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 



function create_zd_user($contact_id,$contact_name, $zendesk_id, $contact_email){
    
    
    $subdomain = "sonovate1482226651";
$username  = "gsmall@sonovate.com"; // replace this with your registered email
$token     = "iTGNBMsgFEoz9OzofuRTSYgWbdpebOjbrZkg6moK"; // replace this with your token

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
                                //echo "<pre>";
                                //print_r($query);
                                //echo "</pre>";
                            } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
                                echo 'Please check your credentials. Make sure to change the $subdomain, $username, and $token variables in this file.';
                            }
    
}





function sonovate_zendesk($zd_id,$company_id = false,$output =false, $action='', $domain = false, $new_user_array = ''){
     //echo '<pre>' ; print_r($destination); echo '</pre>'; 
   // return $output[0]->registration;
   //exit();
$subdomain = "sonovate1482226651";
$username  = "gsmall@sonovate.com"; // replace this with your registered email
$token     = "iTGNBMsgFEoz9OzofuRTSYgWbdpebOjbrZkg6moK"; // replace this with your token

$client = new ZendeskAPI($subdomain);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);

    switch ($action){
         case "create_a_new_organisation":
            try { 
                    $newOrganzation = $client->organizations()->create(array(
               
                   'domain' => $domain,
                    'name' => $output['name'],
                    'external_id' => $output['registration'],
                    'domain_names' => [$domain],
                    'organization_fields'  => [
                    'company_registration' => $output['registration'],
                         'baselist_id' => $output['id'],
                             'name' =>  $output['name']
                        ]
                    ));
                
                
                
                /* eg:response
                
                [organization] => stdClass Object
        (
            [url] => https://sonovate1482226651.zendesk.com/api/v2/organizations/3057643983.json
            [id] => 3057643983
            [name] => AMV Global Ltd
            [shared_tickets] => 
            [shared_comments] => 
            [external_id] => 09420183
            [created_at] => 2017-04-03T16:32:50Z
            [updated_at] => 2017-04-03T16:32:50Z
            [domain_names] => Array
                (
                    [0] => amv-global.com
                )

            [details] => 
            [notes] => 
            [group_id] => 
            [tags] => Array
                (
                )

            [organization_fields] => stdClass Object
                (
                    [candidate] => 
                    [candidate_id] => 
                    [client] => 
                    [client_id] => 
                    [company_registration] => 
                    [name] => 
                    [notes] => 
                    [type] => 
                )

        )*/
                    return $newOrganzation;
       // echo '<pre>' ; print_r($newOrganzation); echo '</pre>';
                 } catch (Exception $e) {
                   echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
          break;
            
            
            
            
        case "create_new_user":

                                        try {
                                $query = $client->users()->create(
                                    [
                                    'name' => 'API Demo',
                                    'email' => 'demo@example.com',
                                    'phone' => '+1-954-704-6031',
                                    'role'  => 'end-user',
                                    'details' => 'This user has been created with the API.'
                                    ]
                                );
                                echo "<pre>";
                                print_r($query);
                                echo "</pre>";
                            } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
                                echo 'Please check your credentials. Make sure to change the $subdomain, $username, and $token variables in this file.';
                            }
            
            
            
            
            break;
            
            
          case "create_a_new_ticket":
                try { 
                        $newTicket = $client->tickets()->create([
                        'id' => $output[0]->id,
                        'external_id'  => $output[0]->registration,
                        'name'  =>  $output[0]->name,
                        'priority' => 'normal',
                          'comment'  => [
                            'body' => 'Baselist Zendesk API test ' 
                        ],
                        'priority' => 'normal',
                        'assignee_id' => 'risk@sononvate.com'
                        ]);                              
                        echo '<pre>' ; print_r($newTicket); echo '</pre>';
                    } catch (Exception $e) {
                      echo 'Caught exception: ',  $e->getMessage(), "\n"; 
                    }
            break; 
            
            case  "get_all_tickets_regarding_a_user":
            
                try {
                        $tickets = $client->users()->requests()->findAll();
                        echo '<pre>' ;
                        print_r($tickets); 
                        echo '</pre>'; 
                    } catch (Exception $e) {
                            echo 'Caught exception: ',  $e->getMessage(), "\n";
                    } finally {
                            echo "First finally.\n";
                    }
            break;
            
            case  "get_all_tickets_regarding_a_specific_user_test":

             // Get all tickets regarding a specific user.
                try {
                        $tickets = $client->users(5122633586)->requests()->findAll();
                        //echo '<pre>' ;
                        return json_encode($tickets); 
                        //echo '</pre>'; 
                    } catch (Exception $e) {
                        //echo 'Caught exception: ',  $e->getMessage(), "\n";
                    } finally {
                        //echo "First finally.\n";
                    }
            break;
            case  "get_all_tickets_regarding_a_specific_user":
                
            $sorter = array('sort_by' => 'created_at',
                            'sort_order' => 'asc',
                            'status'=> 'open'
                           );
             // Get all tickets regarding a specific user.
                try {
                        $tickets = $client->organizations($zd_id)
                            ->tickets()
                            ->findAll($sorter);
                    
                    //
                        return json_encode($tickets); 
                        //echo '</pre>'; 
                    } catch (Exception $e) {
                        return json_encode($e->getMessage());
                    } finally {
                        //echo "First finally.\n";
                    }
            break;
        case  "get_all_tickets_placements":
                
      return $response  = array('success' => 'ok');
            break;
            
            
        } //end of switch
}



