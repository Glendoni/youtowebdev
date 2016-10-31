<?php
function redirect_ssl() 
{
    //$CI->load->helper("url_helper");
    $CI =& get_instance();
    $class = $CI->router->fetch_class();
    $exclude =  array();  // add more controller name to exclude ssl.
    if(!in_array($class,$exclude)) 
     {
         // redirecting to ssl. 
         if ($_SERVER['SERVER_PORT'] != 443)
         { 
            redirect($CI->config->config['base_url'].$_SERVER['REQUEST_URI']);}
          } 
       else 
      // redirecting with no ssl.
      $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
      if ($_SERVER['SERVER_PORT'] == 443) redirect($CI->uri->uri_string());
    }
