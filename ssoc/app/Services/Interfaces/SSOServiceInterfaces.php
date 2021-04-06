<?php

namespace App\Services\Interfaces;

interface SSOServiceInterfaces
{
    public function verifyToken($token, $originUrl);
    public function logOut($token);
}
