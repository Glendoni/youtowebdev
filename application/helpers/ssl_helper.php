<?php

function getHttpsUrl($herokuForwardedProto, $url, $env) {
    if (isset($herokuForwardedProto) && $herokuForwardedProto == "https") {
        throw new Exception('Https already enabled');
    }
    return str_replace('http', 'https', $url);
}