<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahkan ini
use Carbon\Carbon;

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
        // if (config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }

        setlocale(LC_TIME, 'id_ID.utf8'); // Pastikan sistem mendukung id_ID
        Carbon::setLocale('id'); // Ubah bahasa Carbon ke Indonesia
    }
}
