<?php

namespace App\Services;

use GuzzleHttp;

use App\Services\Interfaces\SSOServiceInterfaces;

class SSOService implements SSOServiceInterfaces
{
    public function verifyToken($token, $originUrl)
    {
        $client = new GuzzleHttp\Client();
        $res = $client->get(
            env('SSO_SERVER_API') . 'verifyToken',
            [
                'query' => [
                    'token' => $token,
                    'origin' => $originUrl,
                ]
            ]
        );
        return json_decode($res->getBody()->__toString());
    }

    public function logOut($token)
    {
        $client = new GuzzleHttp\Client();
        $res = $client->get(
            env('SSO_SERVER_API') . 'logout',
            [
                'query' => [
                    'token' => $token,
                ]
            ]
        );
//        dd(json_decode($res->getBody()->__toString()));
        return json_decode($res->getBody()->__toString());
        // TODO: Implement logOut() method.
    }
}
