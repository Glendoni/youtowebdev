<?php

 set_time_limit(3000); 
 /* connect to gmail with your credentials */
$hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
    $email = "gsmall@sonovate.com";
    $password = "LiverpoolFC";
/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());



        
        
        
        
        
        //	$this->data['main_content'] = 'companies/editor';
		//$this->load->view('layouts/default_layout', $this->data);	
        
    