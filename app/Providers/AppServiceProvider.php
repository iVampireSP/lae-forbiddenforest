<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
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
        Paginator::useBootstrapFive();

        Http::macro('wp', function ($url, $username = null, $password = null) {
            return Http::baseUrl($url)
                ->withBasicAuth($username, $password)
                ->withHeaders([
                    'User-Agent' => 'LAE Forbidden Forest (https://dash.laecloud.com)',
                ]);
        });
    }
}
