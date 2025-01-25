<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        Gate::define('access', function ($user, ...$roles) {
            return in_array($user->role, $roles) ? Response::allow() : Response::deny();
        });

        Gate::define('can-update', function ($user, $model) {
            return $user->id === $model->user_id;
        });

        Gate::define('can-view', function ($user, $model) {
            return $user->id === $model->user_id;
        });

        Gate::define('can-delete', function ($user, $model) {
            return $user->id === $model->user_id;
        });

        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }
    }
}
