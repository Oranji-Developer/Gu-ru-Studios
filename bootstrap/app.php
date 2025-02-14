<?php

use App\Http\Middleware\EnsureProfileIsFilled;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RoleAccessMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->alias([
            'profiled' => EnsureProfileIsFilled::class,
            'role' => RoleAccessMiddleware::class,
        ]);

        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('courses:update-expired')
            ->dailyAt('00:00');
        $schedule->command('events:update-inactive')
            ->dailyAt('00:00');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthorizationException $e) {
            return back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini!!');
        });
    })
    ->create();
