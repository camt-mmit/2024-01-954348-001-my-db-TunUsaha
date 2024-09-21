<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function showLoginForm(): View
    {
        return view('logins.form');
    }

    function logout(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();

        // regenerate CSRF token
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function authenticate(ServerRequestInterface $request): RedirectResponse
    {

        // get credentials from user.
        $data = $request->getParsedBody();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        // authenticate by using method attempt()
        if (Auth::attempt($credentials)) {
            // regenerate the new session ID
            session()->regenerate();

            // redirect to the requested URL or to route products.list if does not specify
            return redirect()->intended(route('products.list'));
        } else {
            // if cannot authenticate redirect back to loginForm with error message.
            return redirect()->back()->withErrors([
                'credentials' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();
    // search user in database
    $existingUser = User::where('email', $user->getEmail())->first();
    if ($existingUser) {
        // user exist, login
        Auth::login($existingUser);
    } else {
        // new user, create new user
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => Hash::make(uniqid()), // generate random password
        ]);
        Auth::login($newUser);
    }
    return redirect()->intended(route('products.list'));
}

public function handleFacebookCallback()
{
    $user = Socialite::driver('facebook')->user();
}

public function handleGithubCallback()
{
    $user = Socialite::driver('github')->user();
}

}
