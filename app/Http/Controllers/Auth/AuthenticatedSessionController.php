<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $role = $request->user()->role;
        
        $url = '/';
        if ($role === 'admin') {
            $url = '/admin';
        } elseif ($role === 'organizer') {
            $url = '/organizer';
        } else {
            $url = session()->pull('url.intended', '/');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['redirect' => $url]);
        }
        
        return redirect()->intended($url);
    }
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
