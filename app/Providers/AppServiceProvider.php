<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Fortify\Contracts\LogoutResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, function () {
            return new class implements LogoutResponse {
                public function toResponse($request)
                {
                    return redirect('/login');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ WAJIB: Paksa Laravel pagination pakai Bootstrap (bukan Tailwind)
        Paginator::useBootstrapFive();
    }
}
