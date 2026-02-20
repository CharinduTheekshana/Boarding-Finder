<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if ($request->filled('intended')) {
            $intended = (string) $request->input('intended');
            $baseUrl = url('/');

            if (Str::startsWith($intended, $baseUrl) || Str::startsWith($intended, '/')) {
                $request->session()->put('url.intended', $intended);
            }
        }

        $request->authenticate();

        if ($request->input('intended_role') === 'student' && $request->user()?->role?->name !== 'student') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'This login form is for student accounts only.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $role = $request->user()?->role?->name;

        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        if ($role === 'owner') {
            return redirect()->intended(route('owner.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
