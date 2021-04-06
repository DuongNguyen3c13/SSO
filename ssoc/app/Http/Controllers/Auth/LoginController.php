<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SSOServiceInterfaces;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $ssoService;

    /**
     * Create a new controller instance.
     *
     * @param SSOServiceInterfaces $ssoService
     */
    public function __construct(SSOServiceInterfaces $ssoService)
    {
        $this->middleware('guest')->except('logout');
        $this->ssoService = $ssoService;
    }

    public function logout()
    {
        $token = Cookie::get('sso_token');
        $this->ssoService->logOut($token);

        return redirect()->back()->withCookie(Cookie::forget('sso_token'));;
    }
}
