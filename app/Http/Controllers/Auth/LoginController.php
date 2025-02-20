<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the authenticated method to check if user is active
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status !== 'active') {
            auth()->logout();
            throw ValidationException::withMessages([
                'email' => ['Akun Anda belum diaktifkan. Silahkan tunggu approval dari admin atau hubungi kami melalui WhatsApp di 085320555394.'],
            ]);
        }
    }

    /**
     * Override credentials to use username instead of email
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}