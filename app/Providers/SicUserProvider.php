<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\SicUser;
use Illuminate\Support\Facades\Hash;

class SicUserProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('sic_users', function ($app, array $config) {
            return new \Illuminate\Auth\EloquentUserProvider($app['hash'], $config['model']);
        });
    }

    public function validateCredentials($user, array $credentials)
    {
        // Verifique se o usuário é válido (por exemplo, se existe)
        if (!$user) {
            return false;
        }

        // Verifique se a senha fornecida corresponde à senha do usuário no banco de dados
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }
}
