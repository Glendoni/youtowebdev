<?php

function getHttpsUrl($serverHttps, $url, $env) {
    if ($env === 'development') {
        throw new Exception('No ssl needed in development');
    }
    dd($serverHttps);
    if (!empty($serverHttps) && $serverHttps !== 'off') {
        throw new Exception('Https already enabled');
    }
    return str_replace('http', 'https', $url);
}