<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorAuthController extends Controller
{
    public function showChallenge()
    {
        return view('auth.2fa-challenge');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = User::find($request->session()->get('2fa:user_id'));

        if ($user && $user->verifyTwoFactorCode($request->code)) {
            Auth::login($user);
            $request->session()->forget('2fa:user_id');
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors(['code' => 'The provided two-factor code was invalid.']);
    }

    protected function redirectPath()
    {
        return '/home';
    }
}
