<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Console + HTTP: keep generated links on https in production
        $appUrl = (string) config('app.url');

        if ($appUrl !== '' && ! str_contains($appUrl, '\\')) {
            URL::forceRootUrl(rtrim($appUrl, '/'));
        }

        if ($this->app->environment('production')
            || str_contains($appUrl, 'onrender.com')
            || str_contains($appUrl, 'trycloudflare.com')
            || str_contains($appUrl, 'railway.app')) {
            URL::forceScheme('https');
        }
    }
}
