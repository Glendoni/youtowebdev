<?php
     
     class Api_model extends MY_Model {
         
         public function logAgent($header_post){
             if(is_array($header_post)){
            $incoming =  $header_post;
            // file_put_contents('incoming.txt', $incoming['token'] . PHP_EOL,FILE_APPEND | LOCK_EX);
            
             return true;
                 
             }else{
                 
                return false; 
             }
         }
        
     
     }


