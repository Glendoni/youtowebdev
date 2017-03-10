<?php

function getHttpsUrl($herokuForwardedProto, $url) {
    if (! isset($herokuForwardedProto)) {
        throw new Exception('No http on local environment.');
    }

    if (isset($herokuForwardedProto) && $herokuForwardedProto == "https") {
        throw new Exception('Https already enabled');
    }
    return str_replace('http', 'https', $url);
}