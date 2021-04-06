<?php

namespace App\Services\Facades;

use App\Services\Interfaces\SSOServiceInterfaces;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed verifyToken($token, $originUrl)
 *
 *
 * @see SSOServiceInterfaces
 */
class SSO extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return SSOServiceInterfaces::class;
    }
}
