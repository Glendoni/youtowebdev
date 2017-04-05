<?php require 'vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
function sonovate_zendesk($output, $action='', $domain = false){
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
                         'name' =>  $output['name'],
                    'external_id' => $output['registration'],
                    'domain_names' => $domain ? $domain : $output['email'],
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
            
            case  "get_all_tickets_regarding_a_specific_user":

             // Get all tickets regarding a specific user.
                try {
                        $tickets = $client->users(1420889283)->requests()->findAll();
                        echo '<pre>' ;
                        print_r($tickets); 
                        echo '</pre>'; 
                    } catch (Exception $e) {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                    } finally {
                        echo "First finally.\n";
                    }
            break;
            
            case "update_a_ticket":

                $client->tickets()->update(24,[
                    'priority' => 'high'
                ]); 
            break;
            
            case "delete_a_ticket":
                $client->tickets()->delete(123);
            break;
        } //end of switch
}

