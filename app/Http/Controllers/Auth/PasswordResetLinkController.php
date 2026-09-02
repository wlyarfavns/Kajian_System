<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if (app()->environment('local') && $status == Password::RESET_LINK_SENT) {
            $user = \App\Models\User::where('email', $request->email)->first();
            if ($user) {
                $token = app('auth.password.broker')->createToken($user);
                $resetLink = url(route('password.reset', [
                    'token' => $token,
                    'email' => $request->email,
                ], false));
                session()->flash('reset_link', $resetLink);
            }
        }

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
