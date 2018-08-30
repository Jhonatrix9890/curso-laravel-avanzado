<?php

namespace App\Providers;

use Auth;
use Hash;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->validaciones();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    private function validaciones()
    {
        Validator::extend('current_password', function ($attribute, $value, $parametes) {
            return Hash::check($value, Auth::user()->password);
        });
        Validator::extend('strong_password', function ($attribute, $value, $parametes) {
            return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[!$%&?@#\._-])(?=.*[0-9])[A-Za-z0-9!$%&?@#\._-]{8,25}$/', $value);
        });
    }
}
