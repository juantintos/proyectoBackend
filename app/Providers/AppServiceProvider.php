<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CodeGeneratorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CodeGeneratorService::class);
        $this->app->singleton(ProductService::class);
        $this->app->singleton(AvatarService::class);
        $this->app->singleton(UserService::class);
        $this->app->singleton(ProfileService::class);
        $this->app->singleton(AuditLogService::class);
        $this->app->singleton(ExportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
