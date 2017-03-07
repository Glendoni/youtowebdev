<?php
require 'application/helpers/ssl_helper.php';

use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function test_gets_https_url_from_http_url()
    {
        $url = getHttpsUrl('http', 'http://blah.com');
        $this->assertEquals($url, 'https://blah.com');
    }

    /**
     * @expectedException Exception
     */
    public function test_gets_https_url_from_http_url_when_https_null()
    {
        $url = getHttpsUrl(null, 'http://blah.com');
    }

    /**
     * @expectedException Exception
     */
    public function test_gets_https_url_from_http_url_development_env()
    {
        $url = getHttpsUrl('https', 'https://blah.com');
    }
}