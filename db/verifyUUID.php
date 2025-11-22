<?php
class verifyUUID {
    public function __construct(){}
    public function verifyUUID($uuid) {
        return preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid
        ) === 1;
    }
}