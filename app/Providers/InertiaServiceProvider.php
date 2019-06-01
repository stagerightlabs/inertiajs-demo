<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Request asset versioning for cache busting
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Set up data sharing between components
        Inertia::share(function () {
            return [
                'app' => [
                    'name' => Config::get('app.name'),
                ],
                'auth' => [
                    'user' => Auth::user() ? [
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ] : null,
                ],
                'flash' => [
                    'success' => Session::get('success'),
                ],
                'errors' => Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object)[],
            ];
        });
    }
}
