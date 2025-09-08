<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // dd("test");
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // Update Google ID and details if not set
                if (!$user->google_id) {
                    $nameParts = explode(' ', $googleUser->getName(), 2);
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                    
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'first_name' => $user->first_name ?: $firstName,
                        'last_name' => $user->last_name ?: $lastName,
                    ]);
                }
            } else {
                // Create new user
                $nameParts = explode(' ', $googleUser->getName(), 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)), // Random password since they're using OAuth
                ]);
            }

            // Log the user in
            Auth::login($user, true);
            
            session()->flash('success', 'Welcome! You have been logged in successfully via Google.');
            
            return redirect()->intended('/');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong with Google authentication. Please try again.');
            return redirect()->route('login');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        session()->flash('success', 'You have been logged out successfully.');
        
        return redirect()->route('home');
    }
}
