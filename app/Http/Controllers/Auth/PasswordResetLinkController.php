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
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        
        $status = Password::sendResetLink(
            $request->only('email')
        );


        if ($status == Password::RESET_LINK_SENT) {
            if ($request->wantsJson()) {
                return response()->json(['status' => __($status)]);
            }
            return back()->with('status', __($status));
        }

        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }
}
