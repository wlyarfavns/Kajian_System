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
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // If user exists, update their google_id if it's missing
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            } else {
                // Create a new user if they don't exist
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 'user', // Default role
                    'password' => null // No password needed for OAuth login
                ]);
            }
            
            // Log the user in
            Auth::login($user);
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin');
            } elseif ($user->role === 'organizer') {
                return redirect()->intended('/organizer');
            }
            
            return redirect()->intended('/kajian'); // default to user dashboard/home
            
        } catch (Exception $e) {
            return redirect('/login')->with('status', 'Terjadi kesalahan saat login menggunakan Google.');
        }
    }
}
