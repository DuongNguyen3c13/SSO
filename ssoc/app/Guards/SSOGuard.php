<?php

namespace App\Guards;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

use App\Services\Facades\SSO as SSOFacade;

class SSOGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = null;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->validate();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }
    }

    private function getCookieToken()
    {
        return $this->request->cookie(SSO_TOKEN);
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return string|null
     */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->id;
        }
    }

    /**
     * @param array $credentials
     * @return bool|void
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials)) {
            //check token in cookie
            $cookieToken = $this->getCookieToken();
            if (empty($cookieToken)) {
                //check token in url
                $token = $this->request->get('token' );
                if (empty($token)) {
                    return redirect()->away(env('SSO_SERVER') . 'login?origin=' . url()->current())->send();
                }
                $verifyToken = SSOFacade::verifyToken($token, url()->current());
                $payload = json_decode($verifyToken->payload);
                if ($verifyToken->success) {
                    return redirect()->to($verifyToken->message)
                        ->withCookie(cookie()->forever(SSO_TOKEN, $payload->sso_token))
                        ->send();
                } else {
                    return redirect()->away(env('SSO_SERVER') . 'login?origin=' . url()->current())->send();
                }
            }
            $verifyToken = SSOFacade::verifyToken($cookieToken, url()->current());
            if ($verifyToken->success) {
                return true;
            } else {
                return redirect()->away(env('SSO_SERVER') . 'login?origin=' . url()->current())->send();
            }
        }
        return false;
    }

    /**
     * @param Authenticatable $user
     * @return $this|void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;

        return $this;
    }
}
