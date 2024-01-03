<?php

namespace Modules\LirCrud\app\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Modules\LirCrud\app\Http\Requests\LoginRequest;
use Modules\LirCrud\app\Supports\Validate\ValidateTransform;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('LirCrud::Login', [
            'rules' => resolve(ValidateTransform::class)->transformed(LoginRequest::class)
        ]);
    }

    /**
     * Handle an authentication attempt.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->merge(['email' => $request->username]);
 
        if (Auth::attempt($request->only(['email', 'password']))) {
            // logout other device
            Auth::logoutOtherDevices($request->password);

            $request->session()->regenerate();
 
            return redirect()->intended('admin/dashboard');
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('admin/login');
    }
}
