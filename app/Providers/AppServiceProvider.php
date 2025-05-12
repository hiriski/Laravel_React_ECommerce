<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

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
        JsonResource::withoutWrapping();

        // bind custom
        $this->app->bind(
            \Illuminate\Pagination\LengthAwarePaginator::class,
            \Modules\Common\Http\Transformers\BasePaginator::class,
        );
    }
}
