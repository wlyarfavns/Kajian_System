<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Notifikasi Reset Kata Sandi - KajianKu')
                ->greeting('Halo!')
                ->line('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.')
                ->action('Reset Kata Sandi', url(route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false)))
                ->line('Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit.')
                ->line('Jika Anda tidak meminta reset kata sandi, abaikan email ini.')
                ->salutation('Salam hormat, Tim KajianKu');
        });
    }
}
