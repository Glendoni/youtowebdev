<?php

function getHttpsUrl($serverHttps, $url) {
    if (!empty($serverHttps) && $serverHttps !== 'off') {
        throw new Exception('Https already enabled');
    }
    return str_replace('http', 'https', $url);
}