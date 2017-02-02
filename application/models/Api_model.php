<?php
     
     class Api_model extends MY_Model {
         
         
         
         
         function logAgent($header_post){
             
            $incoming = json_decode($header_post);
             file_put_contents('incoming.txt', $incoming,FILE_APPEND | LOCK_EX);
            
             
         }
         
         
         
         
         
         
     
     
     }


