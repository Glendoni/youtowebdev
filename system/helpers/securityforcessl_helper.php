<?php
class SecurityHelper extends MY_Controller
{
    // CONTROLLERS FORCED TO SSL
    private $arrHttps = array(
        'companies/company',
        'dashboard/'
    );

    // CONTROLLERS ACCESSIBLE FROM BOTH
    private $arrAgnostic = array (
        'users/profile'
    );

    function redirectSsl()
    {
        // SSL MODULES
        if(in_array(uri_string(), $this->arrHttps))
        {
            // ONLY REDIRECT IF NECESSARY
            if ($_SERVER['HTTPS'] != "on")
            {
                // REDIRECTING TO SSL
                $newUrl = str_replace('http://', 'https://', base_url($_SERVER['REQUEST_URI']));
                redirect($newUrl);
            }
        }
        // NON-SSL MODULES
        else
        {
            // IF AGNOSTIC, DON'T REDIRECT
            if(in_array(uri_string(), $this->arrAgnostic))
                return;

            // ONLY REDIRECT IF NECESSARY
            if ($_SERVER['HTTPS'] == "on")
            {
                $newUrl = str_replace('https://', 'http://', base_url($_SERVER['REQUEST_URI']));
                redirect($newUrl);
            }
        }
    }
}
