<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 'user', 
                    'password' => null 
                ]);
            }
            
            Auth::login($user);
            
            if ($user->role === 'admin') {
                return redirect()->intended('/admin');
            } elseif ($user->role === 'organizer') {
                return redirect()->intended('/organizer');
            }
            return redirect()->intended('/kajian'); 
        } catch (Exception $e) {
            return redirect('/login')->with('status', 'Terjadi kesalahan saat login menggunakan Google.');
        }
    }
}
