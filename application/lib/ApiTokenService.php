<?php
namespace Baselist;

class ApiTokenService {
    public function isTokenValid($token) {
        if ($token === "764f427e0f687d987f6a0f5c5324cdbd") {
            return true;
        }
        return false;
    }
}